<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function startTransaction(Request $request)
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return view('transaction.form', compact('transactions'));
    }

    public function processTransaction(Request $request)
    {
        // Lấy dữ liệu từ request
        $amount = $request->input('amount');
        $recipient = $request->input('recipient');

        // Lưu giao dịch vào database
        $transaction = Transaction::create([
            'amount' => $amount,
            'recipient' => $recipient,
            'status' => 'pending',
        ]);


        session()->put('transaction', [
            'id' => $transaction->id,
            'amount' => $amount,
            'recipient' => $recipient,
            'status' => 'pending',
        ]);


        return view('transaction.confirm', compact('transaction'));
    }

    public function completeTransaction(Request $request)
    {

        $transactionId = session()->get('transaction.id');

        $transaction = Transaction::find($transactionId);

        if ($transaction) {

            $transaction->update(['status' => 'completed']);
            session()->forget('transaction');
            return view('transaction.success', compact('transaction'));
        }
        return redirect()->route('transaction.start');
    }

    public function cancelTransaction(Request $request)
    {

        session()->forget('transaction');


        return view('transaction.cancel');
    }
}
