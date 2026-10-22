<?php

namespace App\Http\Resources;

use App\Models\PlatformSetting;
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
        $settings = PlatformSetting::pluck('value', 'key')->toArray();
        return [
            'id' => $this->id,
            'institute' => [
                'id' => $this->institute?->id,
                'name' => $this->institute?->name,
                'code' => $this->institute?->code,
            ],
            'main_logo' => $this->main_logo ?? $settings['default_main_logo'] ?? null,
            'small_logo' => $this->small_logo ?? $settings['default_small_logo'] ?? null,
            'login_logo' => $this->login_logo ?? $settings['default_login_logo'] ?? null,
            'favicon' => $this->favicon ?? $settings['default_favicon'] ?? null,
            'login_layout' => $this->login_layout ?? $settings['login_layout'] ?? 'layout_one',
            'primary_color' => $this->primary_color ?? $settings['default_primary_color'] ?? '#166534',
            'secondary_color' => $this->secondary_color ?? $settings['default_secondary_color'] ?? '#84CC16',
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'address' => $this->address,
            'website' => $this->website,
        ];
    }
}
