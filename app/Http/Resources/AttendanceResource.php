<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student_id'=> $this->student_id,
            'student_name'=> $this->student->name,
            'attendence_date'=> $this->attendence_date,
            'attendence_status'=> $this->attendence_status,
        ];
    }
}
