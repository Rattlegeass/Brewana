<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalPemasukan()
    {
        $pembayaran = Pembayaran::where('status', 'success')->get();

        $totalPenjualan = $pembayaran->sum('total_harga');

        return response()->json(['total_penjualan' => $totalPenjualan]);
    }

    public function totalPengiriman()
    {
        $pengiriman = Pengiriman::whereIn('status', ['diterima', 'dikirim'])->count();

        return response()->json(['total_pengiriman' => $pengiriman]);
    }

    public function totalTransaksi()
    {
        $pembayaran = Pembayaran::where('status', 'success')->count();

        return response()->json(['total_transaksi' => $pembayaran]);
    }
}
