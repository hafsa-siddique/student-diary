<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'user_id' => $this->user_id,
            'institute_id' => $this->institute_id,
            'employee_code' => $this->employee_code,
            'name' => $this->user?->name,
            'email' => $this->user?->email,
            'phone' => $this->phone,
            'profile_picture' => $this->profile_picture,
            'status' => $this->status,
            'current_assignment_count' =>
                $this->current_assignment_count ?? 0,
            'assignment_count' => $this->when(
                $this->relationLoaded('assignments'),
                fn () => $this->assignments->count()
            ),    
            'assignments' => $this->whenLoaded('assignments', function () {
                return $this->assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'class' => $assignment->schoolClass
                            ? [
                                'id' => $assignment->schoolClass->id,
                                'name' => $assignment->schoolClass->name,
                                'short_name' => preg_replace(
                                    '/^Class\s*/i',
                                    '',
                                    $assignment->schoolClass->name
                                ),
                            ]
                            : null,
                        'section' => $assignment->section
                            ? [
                                'id' => $assignment->section->id,
                                'name' => $assignment->section->name,
                                'short_name' => preg_replace(
                                    '/^Section\s*/i',
                                    '',
                                    $assignment->section->name
                                ),
                            ]
                            : null,
                        'subject' => $assignment->subject
                            ? [
                                'id' => $assignment->subject->id,
                                'name' => $assignment->subject->name,
                            ]
                            : null,

                        'academic_session' => $assignment->academicSession
                            ? [
                                'id' => $assignment->academicSession->id,
                                'name' => $assignment->academicSession->name,
                            ]
                            : null,
                        'status' => (bool) $assignment->status,
                    ];
                });
            }),   
        ];
    }
}
