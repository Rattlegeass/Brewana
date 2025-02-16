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
            'image' => 'promo/promo-image(1).png',
            'periode_awal' => '2025-01-01',
            'periode_akhir' => '2025-02-28',
            'potongan_harga' => 25,
        ]);

        Promo::create([
            'nama' => 'Ramadhan 2025',
            'deskripsi' => 'Nikmati momen berbuka dan sahur dengan secangkir kopi terbaik dari Brewana!',
            'image' => 'promo/promo-image(2).png',
            'periode_awal' => '2025-02-01',
            'periode_akhir' => '2025-03-31',
            'potongan_harga' => 15,
        ]);
    }
}
