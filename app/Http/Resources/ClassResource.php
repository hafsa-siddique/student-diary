<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
            'institute_id' => $this->institute_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,

            'sections_count' => isset($this->sections_count)
                ? (int) $this->sections_count
                : 0,

            'student_count' => isset($this->student_count)
                ? (int) $this->student_count
                : 0,
            'academic_session' => $this->academic_session
                ? new AcademicSessionResource($this->academic_session)
                : null,    
        ];
    }
}