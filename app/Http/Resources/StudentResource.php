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
        $currentEnrollment = $this->enrollments
            ->where('status', true)
            ->first();
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'institute_id' => $this->institute_id,
            'student_code' => $this->student_code,
            'name' => $this->name,
            'date_of_birth' => $this->date_of_birth->format('d M Y'),
            'gender' => $this->gender,
            'profile_picture' => $this->profile_picture,
            'status' => $this->status,
            'class' => $currentEnrollment?->schoolClass ? [
                'id' => $currentEnrollment->schoolClass->id,
                'name' => $currentEnrollment->schoolClass->name,
            ] : null,

            'section' => $currentEnrollment?->section ? [
                'id' => $currentEnrollment->section->id,
                'name' => $currentEnrollment->section->name,
            ] : null,
            'academic_session' => $currentEnrollment?->academicSession ? [
                'id' => $currentEnrollment->academicSession->id,
                'name' => $currentEnrollment->academicSession->name,
            ] : null,
        ];
    }
}
