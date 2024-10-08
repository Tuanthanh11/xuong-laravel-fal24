<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('customer')->id;
        return [
            [
                'name'        => 'required|max:255',
                'address'     => 'required|max:255',
                'avatar'      => 'nullable|image|max:2048',
                'phone'       => ['required', 'string', 'max:20', Rule::unique('customers')->ignore($id)],
                'email'       => 'required|email|max:255',
                'is_active'   => ['nullable', Rule::in([0, 1])],
            ]
        ];
    }
}
