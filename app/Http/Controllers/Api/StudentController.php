<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return $this->respondSuccess(StudentResource::collection($students));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentRequest $request)
    {
        $student = Student::create($request->all());
        return $this->respondSuccess(new StudentResource($student));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if ($student) {
            return $this->respondSuccess(new StudentResource($student));
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->update($request->all());
            return $this->respondSuccess(new StudentResource($student));
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return $this->respondSuccess(new StudentResource($student));
        } else {
            return $this->respondNotFound();
        }
    }
}
