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
            'image' => 'barang/arabica-beans.png',
            'barang_id' => 1,
        ]);
        BarangImage::create([
            'image' => 'barang/robusta-beans.png',
            'barang_id' => 2,
        ]);
        BarangImage::create([
            'image' => 'barang/toraja-beans.jpg',
            'barang_id' => 3,
        ]);
        BarangImage::create([
            'image' => 'barang/gayo-beans.jpg',
            'barang_id' => 4,
        ]);
        BarangImage::create([
            'image' => 'barang/luwak-beans.jpg',
            'barang_id' => 5,
        ]);
        BarangImage::create([
            'image' => 'barang/excelsa-beans.jpg',
            'barang_id' => 6,
        ]);
        BarangImage::create([
            'image' => 'barang/french-press.png',
            'barang_id' => 7,
        ]);
        BarangImage::create([
            'image' => 'barang/espresso-machine.png',
            'barang_id' => 8,
        ]);
        BarangImage::create([
            'image' => 'barang/grinder.jpg',
            'barang_id' => 9,
        ]);
        BarangImage::create([
            'image' => 'barang/tamper.jpg',
            'barang_id' => 10,
        ]);
    }
}
