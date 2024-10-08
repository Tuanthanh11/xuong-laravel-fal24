<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $term = request('term',null);
        $data = Customer::query()->latest('id')
        ->when($term,function($query,$term){
            $query->whereAny([
                'name',
                'email',
                'phone',
            ], 'like', "%$term%");
        })
        ->paginate(10);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|max:255',
            'address'     => 'required|max:255',
            'avatar'      => 'nullable|image|max:2048',
            'phone'       => ['required', 'string', 'max:20', Rule::unique('customers')],
            'email'       => 'required|email|max:255',
            'is_active'   => ['nullable', Rule::in([0, 1])],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $data['avatar'] = Storage::put('customers', $request->file('avatar'));
            }
            $customer =Customer::query()->create($data);
            return response()->json($customer, 201);
        } catch (\Throwable $th) {

            if (!empty($data['avatar']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avatar']);
            }
            return response()->json([
                'msg'=> 'loi he thong'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        
        $data = $request->validated(); 
        
        $customer = Customer::query()->find($id);
        try {

            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            if ($request->hasFile('avatar')) {
                $data['avatar'] = Storage::put('customers', $request->file('avatar'));
            }
            $currentAvatar = $customer->avatar;
            $customer->update($data);
            if ($request->hasFile('avatar') &&  !empty($currentAvatar) && Storage::exists($currentAvatar)) {
                Storage::delete($currentAvatar);
            }



            return response()->json($customer, 200);
        } catch (\Throwable $th) {

            if (!empty($data['avatar']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avatar']);
            }
            return response()->json([
                'msg'=> 'loi he thong'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
