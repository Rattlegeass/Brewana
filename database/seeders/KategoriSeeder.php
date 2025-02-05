<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'nama' => 'Biji Kopi',
        ]);
        Kategori::create([
            'nama' => 'Peralatan Kopi',
        ]);
    }
}
