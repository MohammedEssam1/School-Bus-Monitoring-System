<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'national_id' => $this->national_id,
            'date_birth' => $this->date_birth,
            'grade' => $this->grade->name,
            'classroom' => $this->classroom->name,
            'section' => $this->section->name,
            'parent' => $this->user->name,
        ];
    }
}
