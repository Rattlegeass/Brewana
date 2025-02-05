<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promo::create([
            'nama' => 'New Year 2025',
            'deskripsi' => 'Resolusi belanja hemat? Kami punya jawabannya! Promo spesial Tahun Baru 2025 menanti Anda!',
            'image' => 'promo/promo-image.jpg',
            'periode_awal' => '2025-01-01',
            'periode_akhir' => '2025-01-31',
            'potongan_harga' => 15,
        ]);
    }
}
