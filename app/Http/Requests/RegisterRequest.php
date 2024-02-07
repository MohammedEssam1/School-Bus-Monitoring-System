<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            'phone'=> 'required|regex: /^01[0-5]{1}[0-9]{8}$/',
        ];
    }
    public function messages(): array
{
    return [
        'phone.regex' => 'please enter a valid phone number',
    ];
}
}
