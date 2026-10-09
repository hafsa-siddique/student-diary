<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicSessionResource extends JsonResource
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
            'start_date' => $this->start_date?->format('d M Y'),
            'end_date' => $this->end_date?->format('d M Y'),
            'status' => $this->status,
        ];
    }
}
