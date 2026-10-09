<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherMyAssignmentResource extends JsonResource
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
            'class' => [
                'id' => $this->schoolClass?->id,
                'name' => $this->schoolClass?->name,
            ],

            'section' => [
                'id' => $this->section?->id,
                'name' => $this->section?->name,
            ],

            'subject' => [
                'id' => $this->subject?->id,
                'name' => $this->subject?->name,
                'code' => $this->subject?->code,
            ],

            'academic_session' => [
                'id' => $this->academicSession?->id,
                'name' => $this->academicSession?->name,
            ],

            'status' => $this->status,
        ];
    }
}
