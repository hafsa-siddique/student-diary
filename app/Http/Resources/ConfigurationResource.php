<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
            'institute' => [
                'id' => $this->institute?->id,
                'name' => $this->institute?->name,
                'code' => $this->institute?->code,
            ],
            'main_logo' => $this->main_logo,
            'small_logo' => $this->small_logo,
            'login_logo' => $this->login_logo,
            'favicon' => $this->favicon,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'address' => $this->address,
            'website' => $this->website,
        ];
    }
}
