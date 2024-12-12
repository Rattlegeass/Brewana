<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->truncate();

        Setting::create([
            'app' => 'BREWANA',
            'description' =>  'Kopi Kita',
            'logo' =>  '/media/coffee-logo.png',
            'bg_auth' =>  '/media/misc/coffee-bg.jpg',
            'banner' =>  '/media/misc/coffee-banner.jpg',
            'pemerintah' =>  'Jawa Timur',
            'dinas' =>  'Surabaya',
            'alamat' =>  'Kendung Jaya',
            'telepon' =>  '08123456789',
            'email' =>  'admin@gmail.com',
        ]);
    }
}
