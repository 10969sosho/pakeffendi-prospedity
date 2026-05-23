<?php

namespace Database\Seeders;

use App\Models\HomeSetting;
use Illuminate\Database\Seeder;

class HomeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'DISCOVER YOUR DREAM PARADISE IN BALI',
                'hero_subtitle' => 'Explore the finest selection of villas, land, and investment properties in the island of gods.',
                'email' => 'contact@prospedity.com',
                'facebook_url' => 'https://facebook.com',
                'instagram_url' => 'https://instagram.com',
                'whatsapp_url' => '6281234567890',
                'tiktok_url' => 'https://tiktok.com',
            ]
        );
    }
}
