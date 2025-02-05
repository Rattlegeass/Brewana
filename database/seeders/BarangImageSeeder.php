<?php

namespace Database\Seeders;

use App\Models\BarangImage;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BarangImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangImage::create([
            'image' => 'barang/barang-image(1).png',
            'barang_id' => 1,
        ]);
        BarangImage::create([
            'image' => 'barang/barang-image(2).png',
            'barang_id' => 2,
        ]);
        BarangImage::create([
            'image' => 'barang/barang-image(3).png',
            'barang_id' => 3,
        ]);
        BarangImage::create([
            'image' => 'barang/barang-image(4).png',
            'barang_id' => 4,
        ]);
    }
}
