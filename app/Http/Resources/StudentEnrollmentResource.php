<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentEnrollmentResource extends JsonResource
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

            'student' => [
                'id' => $this->student?->id,
                'student_code' => $this->student?->student_code,
                'name' => $this->student?->name,
            ],

            'class' => [
                'id' => $this->schoolClass?->id,
                'name' => $this->schoolClass?->name,
            ],

            'section' => [
                'id' => $this->section?->id,
                'name' => $this->section?->name,
            ],

            'academic_session' => [
                'id' => $this->academicSession?->id,
                'name' => $this->academicSession?->name,
            ],
            'subjects' => $this->schoolClass?->subjects?->map(fn ($subject) => [
                'id' => $subject->id,
                'name' => $subject->name,
            ])->values() ?? [],
            'enrollment_date' => $this->enrollment_date?->format('Y-m-d'),
            'status' => $this->status,
        ];
    }
}
