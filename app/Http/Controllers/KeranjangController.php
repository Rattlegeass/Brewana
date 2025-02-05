<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function items(Request $request)
    {
        $data = Keranjang::with(['barang', 'user'])->where('user_id', auth()->user()->id)->when($request->search !== '', function ($q) use ($request) {
            $q->whereHas('barang', function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('kategori', function ($q) use ($request) {
                        $q->where('nama', 'LIKE', '%' . $request->search . '%');
                    });
            });
        })->paginate(5);

        // salah
        $data->map(function ($item) {
            if (isset($item->barang->promo)) {
                if ($item->barang->promo->periode_awal <= Carbon::now() && $item->barang->promo->periode_akhir >= Carbon::now()) {
                    $item->barang->harga_diskon = $item->barang->harga - ($item->barang->harga * $item->barang->promo->potongan_harga / 100);
                }
            }
        });

        return response()->json(['items' => $data]);
    }

    public function aturKuantitas(Request $request, $uuid)
    {
        $keranjang = Keranjang::with(['barang', 'user'])->where('uuid', $uuid)->first();
        $kuantitas = $keranjang->kuantitas;
        $harga_satuan = $keranjang->barang->harga;

        if ($request->kuantitas == 'tambah' && $keranjang->kuantitas < $keranjang->barang->stok) {
            $kuantitas += 1;
        } elseif ($request->kuantitas == 'kurang' && $keranjang->kuantitas > 1) {
            $kuantitas -= 1;
        }

        if (isset($keranjang->barang->promo)) {
            if ($keranjang->barang->promo->periode_awal <= Carbon::now() && $keranjang->barang->promo->periode_akhir >= Carbon::now()) {
                $keranjang->barang->harga_diskon = $keranjang->barang->harga - ($keranjang->barang->harga * $keranjang->barang->promo->potongan_harga / 100);
                $harga_diskon = $keranjang->barang->harga_diskon;
                $total_harga = $harga_diskon * $kuantitas;
            } else {
                $harga_diskon = $harga_satuan;
                $total_harga = $harga_diskon * $kuantitas;
            }
        } else {
            $harga_diskon = $harga_satuan;
            $total_harga = $harga_diskon * $kuantitas;
        }

        $keranjang->update(['kuantitas' => $kuantitas, 'total_harga' => $total_harga]);

        if (isset($keranjang->barang->promo)) {
            if ($keranjang->barang->promo->periode_awal <= Carbon::now() && $keranjang->barang->promo->periode_akhir >= Carbon::now()) {
                $keranjang->barang->harga_diskon = $keranjang->barang->harga - ($keranjang->barang->harga * $keranjang->barang->promo->potongan_harga / 100);
            }
        }

        return response()->json(['data' => $keranjang]);
    }

    public function hapusItem($uuid)
    {
        $keranjang = Keranjang::findByUuid($uuid);
        $keranjang->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'barang_ids' => 'required|array'
        ]);

        $keranjangs = Keranjang::whereIn('barang_id', $request->barang_ids)
            ->where('user_id', auth()->user()->id)
            ->get();

        $total_harga = 0;

        do {
            $order_id = 'BWID' . mt_rand(100000, 999999);
        } while (Pembayaran::where('order_id', $order_id)->exists());

        foreach ($keranjangs as $keranjang) {
            Pembayaran::create([
                'order_id' => $order_id,
                'user_id' => $keranjang->user_id,
                'barang_id' => $keranjang->barang_id,
                'kuantitas' => $keranjang->kuantitas,
                'total_harga' => $keranjang->total_harga,
                'status' => 'pending',
            ]);

            $total_harga += $keranjang->total_harga;
        }

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $total_harga,
            ]
        ];

        $token = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'token' => $token,
            'order_id' => $order_id,
        ]);
    }

    public function checkStatus(Request $request)
    {
        $data = $request->validate([
            'barang_ids' => 'required|array',
            'order_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $pembayarans = Pembayaran::where('order_id', $data['order_id'])->get();

        $uuid = null;

        if ($data['status'] == 'success') {
            $keranjangs = Keranjang::whereIn('barang_id', $data['barang_ids'])->where('user_id', auth()->user()->id)->get();

            foreach ($keranjangs as $keranjang) {
                $barang = Barang::where('id', $keranjang->barang_id)->first();
                $barang->update(['stok' => $barang->stok - $keranjang->kuantitas]);

                $keranjang->delete();
            }

            $pengiriman = Pengiriman::create([
                'order_id' => $data['order_id'],
                'status' => 'dikemas',
            ]);

            $uuid = $pengiriman->uuid;

            foreach ($pembayarans as $pembayaran) {
                $pembayaran->update([
                    'pengiriman_id' => $pengiriman->id
                ]);
            }
        }

        foreach ($pembayarans as $pembayaran) {
            $pembayaran->update([
                'status' => $data['status']
            ]);
        }

        return response()->json([
            'order_id' => $data['order_id'],
            'uuid' => $uuid
        ]);
    }
}
