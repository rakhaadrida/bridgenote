<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            // 'email_verified_at' => 'date',
            'password' => 'required|min:8',
            // 'remember_token' => 'string',
            'status' => 'required|max:255|in:ACTIVE,INACTIVE',
            'position' => 'required|max:255',
        ];
    }
}
