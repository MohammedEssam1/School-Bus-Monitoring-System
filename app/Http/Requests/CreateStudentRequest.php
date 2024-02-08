<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class CreateStudentRequest extends ApiRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'national_id' => 'required|digits:14|unique:students,national_id',
            'date_birth' => 'required|date',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
