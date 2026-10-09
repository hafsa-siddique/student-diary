<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDiaryResource extends JsonResource
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

            'teacher_assignment_id' => $this->teacher_assignment_id,

            'class' => [
                'id' => $this->teacherAssignment?->schoolClass?->id,
                'name' => $this->teacherAssignment?->schoolClass?->name,
            ],

            'section' => [
                'id' => $this->teacherAssignment?->section?->id,
                'name' => $this->teacherAssignment?->section?->name,
            ],

            'subject' => [
                'id' => $this->teacherAssignment?->subject?->id,
                'name' => $this->teacherAssignment?->subject?->name,
                'code' => $this->teacherAssignment?->subject?->code,
            ],

            'academic_session' => [
                'id' => $this->teacherAssignment?->academicSession?->id,
                'name' => $this->teacherAssignment?->academicSession?->name,
            ],

            'diary_date' => $this->diary_date?->format('d-m-Y'),

            'classwork' => $this->classwork,

            'homework' => $this->homework,

            'instructions' => $this->instructions,

            'due_date' => $this->due_date?->format('d-m-Y'),

            'status' => $this->status,

            'scheduled_at' => $this->scheduled_at?->format('d-m-Y h:i A'),

            'published_at' => $this->published_at?->format('d-m-Y h:i A'),

            'attachments' => $this->attachments,
        ];
    }
}
