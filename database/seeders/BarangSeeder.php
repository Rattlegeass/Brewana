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
            'promo_id' => 1,
        ]);
        Barang::create([
            'nama' => 'Kopi Toraja',
            'deskripsi' => 'Biji kopi Toraja kami menawarkan cita rasa yang kaya dan kompleks, dengan aroma yang menggoda. Nikmati secangkir kopi yang bercerita tentang keindahan alam Indonesia!',
            'stok' => 25,
            'harga' => 150000,
            'kategori_id' => 1,
            'promo_id' => 2,
        ]);
        Barang::create([
            'nama' => 'Kopi Gayo',
            'deskripsi' => 'Biji kopi Gayo kami memiliki profil rasa yang seimbang, dengan sentuhan manis dan asam yang harmonis. Temukan keunikan kopi Gayo dalam setiap cangkir!',
            'stok' => 30,
            'harga' => 50000,
            'kategori_id' => 1,
            'promo_id' => 2,
        ]);
        Barang::create([
            'nama' => 'Kopi Luwak',
            'deskripsi' => 'Dikenal sebagai salah satu kopi termahal di dunia, biji kopi Luwak menawarkan kelezatan yang luar biasa. Setiap cangkir adalah perjalanan rasa yang tak terlupakan!',
            'stok' => 12,
            'harga' => 200000,
            'kategori_id' => 1,
        ]);
        Barang::create([
            'nama' => 'Kopi Ekselsa',
            'deskripsi' => 'Biji kopi Ekselsa kami dipetik dengan hati-hati dari kebun kopi terbaik, menjadikannya pilihan sempurna bagi pecinta kopi yang menghargai kualitas dan keunikan.',
            'stok' => 16,
            'harga' => 85000,
            'kategori_id' => 1,
        ]);
        Barang::create([
            'nama' => 'French Press',
            'deskripsi' => 'Alat sederhana yang menggunakan metode penyeduhan manual dengan menyaring kopi menggunakan plunger. Ideal untuk menghasilkan kopi dengan tubuh penuh dan rasa alami yang kuat.',
            'stok' => 5,
            'harga' => 300000,
            'kategori_id' => 2,
            'promo_id' => 1,
        ]);
        Barang::create([
            'nama' => 'Espresso Machine',
            'deskripsi' => 'Mesin kopi yang menggunakan tekanan tinggi untuk mengekstraksi kopi, menghasilkan espresso kental dengan crema di atasnya. Cocok untuk penyuka kopi yang kuat dan berbagai jenis kopi berbasis susu.',
            'stok' => 2,
            'harga' => 5000000,
            'kategori_id' => 2,
        ]);
        Barang::create([
            'nama' => 'Grinder',
            'deskripsi' => 'Dapatkan pengalaman kopi yang lebih baik dengan grinder kopi kami. Mudah digunakan dan menghasilkan gilingan yang konsisten!',
            'stok' => 10,
            'harga' => 150000,
            'kategori_id' => 2,
            'promo_id' => 2,
        ]);
        Barang::create([
            'nama' => 'Tamper',
            'deskripsi' => 'Alat tamper kami dirancang untuk memberikan tekanan yang konsisten, memastikan setiap cangkir kopi Anda memiliki rasa yang kaya dan seimbang.',
            'stok' => 25,
            'harga' => 75000,
            'kategori_id' => 2,
            'promo_id' => 2,
        ]);
    }
}
