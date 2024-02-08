<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'email' => 'sometimes|required|email|unique:students,email,' . $this->id . '|max:255',
            'national_id' => 'sometimes|required|digits:14|unique:students,national_id,' . $this->id,
            'date_birth' => 'sometimes|required|date',
            'grade_id' => 'sometimes|required|exists:grades,id',
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
            'section_id' => 'sometimes|required|exists:sections,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ];
    }
}
