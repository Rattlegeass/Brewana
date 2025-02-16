<?php

namespace Database\Seeders;

use App\Models\Komentar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Komentar::create([
            'user_id' => 2,
            'barang_id' => 1,
            'komentar' => 'Saya sudah mencoba biji kopi ini dan rasanya sangat enak',
        ]);

        Komentar::create([
            'user_id' => 2,
            'barang_id' => 3,
            'komentar' => 'Alat pembuatan kopi ini sangat praktis dan mudah digunakan',
        ]);
    }
}
