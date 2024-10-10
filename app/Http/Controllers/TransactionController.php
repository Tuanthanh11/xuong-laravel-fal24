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
            'amount' => $amount,  // Số tiền
            'recipient' => $recipient,  // Người nhận
            'status' => 'pending',  // Trạng thái giao dịch là "pending" khi mới tạo
        ]);

        // Lưu vào session để người dùng có thể tiếp tục giao dịch nếu cần
        session()->put('transaction', [
            'id' => $transaction->id,  // ID giao dịch vừa lưu vào DB
            'amount' => $amount,
            'recipient' => $recipient,
            'status' => 'pending',
        ]);

        // Chuyển đến view xác nhận giao dịch
        return view('transaction.confirm', compact('transaction'));
    }

    public function completeTransaction(Request $request)
    {
        // Lấy thông tin giao dịch từ session
        $transactionId = session()->get('transaction.id');

        // Tìm giao dịch trong cơ sở dữ liệu
        $transaction = Transaction::find($transactionId);

        if ($transaction) {
            // Cập nhật trạng thái giao dịch là 'completed'
            $transaction->update(['status' => 'completed']);

            // Xóa thông tin giao dịch khỏi session
            session()->forget('transaction');

            return view('transaction.success', compact('transaction'));
        }

        return redirect()->route('transaction.start');  // Quay lại form nếu có lỗi
    }

    public function cancelTransaction(Request $request)
    {
        // Xóa thông tin giao dịch khỏi session
        session()->forget('transaction');

        // Chuyển người dùng về trang hủy giao dịch
        return view('transaction.cancel');
    }
}
