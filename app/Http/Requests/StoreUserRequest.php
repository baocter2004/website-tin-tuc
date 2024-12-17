<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => [
                'required',
                Rule::unique('users'),
                'email'
            ],
            'password' => 'required|confirmed',
            'role' => [
                'required',
                Rule::in(User::USER_ROLE)
            ],
            'image' => 'nullable|image|max:2048',
            'is_active' => [
                'nullable',
                Rule::in([0,1])
            ]
        ];
    }
}
