<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'institute_id' => $this->institute_id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
            'classes_count' => $this->whenCounted('classes'),
            'teacher_assignments_count' => $this->whenCounted('teacherAssignments'),
            'class_names' => $this->class_names ?? [],
        ];
    }
}
