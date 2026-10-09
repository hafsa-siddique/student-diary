<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
             'class_id' => $this->class_id, 
             'name' => $this->name, 
             'status' => $this->status, 
             'student_count' => isset($this->student_count) ? (int) $this->student_count : 0, 
        ];
    }
}
