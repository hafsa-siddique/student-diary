<?php

namespace App\Http\Resources;

use App\Http\Resources\DiaryAttachmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentDiaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => [
                'id' => $this->studentContext?->id,
                'student_code' => $this->studentContext?->student_code,
                'name' => $this->studentContext?->name,
            ],
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
            'teacher' => [
                'id' => $this->teacherAssignment?->teacher?->id,
                'name' => $this->teacherAssignment?->teacher?->user?->name,
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
            'published_at' => $this->published_at?->format('d-m-Y h:i A'),
            'attachments' => DiaryAttachmentResource::collection(
                $this->whenLoaded('attachments')
            ),
        ];
    }
}