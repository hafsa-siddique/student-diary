<?php

namespace Database\Seeders;

use App\Models\PlatformSetting;
use Illuminate\Database\Seeder;

class PlatformSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'max_diary_length', 'value' => '2000', 'group' => 'limits'],
            ['key' => 'maintenance_mode', 'value' => '0', 'group' => 'general'],
            ['key' => 'maintenance_message', 'value' => 'System is currently undergoing scheduled maintenance. Please check back shortly.', 'group' => 'general'],
            ['key' => 'default_primary_color', 'value' => '#166534', 'group' => 'appearance'],
            ['key' => 'default_secondary_color', 'value' => '#84CC16', 'group' => 'appearance'],
            ['key' => 'default_main_logo', 'value' => '/storage/images/student-diary-logo.png', 'group' => 'appearance'],
            ['key' => 'default_small_logo', 'value' => '/storage/images/student-diary-logo.png', 'group' => 'appearance'],
            ['key' => 'default_login_logo', 'value' => '/storage/images/student-diary-logo.png', 'group' => 'appearance'],
            ['key' => 'default_login_cover', 'value' => '/storage/images/default-school-login.jfif', 'group' => 'appearance'],
            ['key' => 'login_layout', 'value' => 'layout_one', 'group' => 'appearance'],
        ];

        foreach($settings as $setting){
            PlatformSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
