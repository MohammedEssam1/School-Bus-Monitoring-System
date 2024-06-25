<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
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
            'tag' => 'sometimes|required|max:255|unique:tags,tag,' . $this->route('tag'),
            'student_id' => 'sometimes|required|exists:students,id|unique:tags,student_id,'.  $this->route('tag'),
        ];
    }
}
