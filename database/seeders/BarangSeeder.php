<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'nama' => 'Kopi Arabica',
            'deskripsi' => 'Jenis biji kopi paling populer yang tumbuh di dataran tinggi dengan cita rasa asam yang kompleks dan aroma wangi. Arabika memiliki kandungan kafein yang lebih rendah dibandingkan kopi Robusta.',
            'stok' => 18,
            'harga' => 150000,
            'kategori_id' => 1,
        ]);
        Barang::create([
            'nama' => 'Kopi Robusta',
            'deskripsi' => 'Memiliki cita rasa yang lebih pahit, dengan tubuh lebih kuat dan tingkat kafein yang lebih tinggi dibandingkan Arabika. Robusta sering digunakan dalam kopi instan dan campuran espresso.',
            'stok' => 33,
            'harga' => 75000,
            'kategori_id' => 1,
            'promo_id' => 1
        ]);
        Barang::create([
            'nama' => 'French Press',
            'deskripsi' => 'Alat sederhana yang menggunakan metode penyeduhan manual dengan menyaring kopi menggunakan plunger. Ideal untuk menghasilkan kopi dengan tubuh penuh dan rasa alami yang kuat.',
            'stok' => 5,
            'harga' => 500000,
            'kategori_id' => 2,
            'promo_id' => 1
        ]);
        Barang::create([
            'nama' => 'Espresso Machine',
            'deskripsi' => 'Mesin kopi yang menggunakan tekanan tinggi untuk mengekstraksi kopi, menghasilkan espresso kental dengan crema di atasnya. Cocok untuk penyuka kopi yang kuat dan berbagai jenis kopi berbasis susu.',
            'stok' => 2,
            'harga' => 5000000,
            'kategori_id' => 2,
            'promo_id' => 1
        ]);
    }
}
