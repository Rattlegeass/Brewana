<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalPenjualan()
    {
        $pembayaran = Pembayaran::where('status', 'success')->get();
        $totalPenjualan = $pembayaran->total_harga->sum();
    }
}
