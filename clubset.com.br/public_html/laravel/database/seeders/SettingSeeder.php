<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['group' => 'listings', 'key' => 'max_images', 'value' => '5'],
            ['group' => 'listings', 'key' => 'max_description_length', 'value' => '5000'],
            ['group' => 'listings', 'key' => 'require_moderation', 'value' => 'true'],
            ['group' => 'services', 'key' => 'require_moderation', 'value' => 'false'],
            ['group' => 'platform', 'key' => 'name', 'value' => config('app.name', 'ClubTem')],
        ];

        foreach ($defaults as $setting) {
            Setting::set($setting['key'], $setting['value'], $setting['group']);
        }
    }
}
