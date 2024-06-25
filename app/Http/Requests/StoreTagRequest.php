<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class StoreTagRequest extends ApiRequest
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
            'tag' => 'required|max:255|unique:tags,tag',
            'student_id' => 'required|exists:students,id|unique:tags,student_id',
        ];
    }
}
