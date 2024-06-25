<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParentRequest extends FormRequest
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
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->route('parent') . '|max:255',
            'phone'=> 'sometimes|required|regex: /^01[0-5]{1}[0-9]{8}$/',
        ];
    }
}
