<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebSetting;

class WebSettingSeeder extends Seeder
{
    public function run(): void
    {
        WebSetting::create([
            'logo_web'       => 'default-logo.png', // Pastikan file ini ada di /storage/app/public/
            'nama_web'       => 'Nobarkuy',
            'deskripsi_web'  => 'Aplikasi nobar terbaik untuk cari tempat dan teman nobar.',
            'alamat_web'     => 'Jl. Teknokrat No. 1, Bandung',
            'email_web'      => 'info@nobarkuy.com',
            'telepon_web'    => '08123456789',
            'facebook_web'   => 'https://facebook.com/nobarkuy',
            'instagram_web'  => 'https://instagram.com/nobarkuy',
            'twitter_web'    => 'https://twitter.com/nobarkuy',
        ]);
    }
}
