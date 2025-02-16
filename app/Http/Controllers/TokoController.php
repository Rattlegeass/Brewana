<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Promo;
use App\Models\Barang;
use App\Models\Komentar;
use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function items(Request $request)
    {
        $data = Barang::where('stok', '>', 0)->when($request->search !== '', function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('kategori', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->search . '%');
                });
        })->paginate(5);

        $data->map(function ($item) {
            if (isset($item->promo->potongan_harga)) {
                if ($item->promo->periode_awal <= Carbon::now() && $item->promo->periode_akhir >= Carbon::now()) {
                    $item->harga_diskon = $item->harga - ($item->harga * $item->promo->potongan_harga / 100);
                }
            }
        });

        return response()->json(['items' => $data]);
    }

    public function promoItems(Request $request)
    {
        $data = Promo::get();

        return response()->json($data);
    }

    public function detailItem($uuid)
    {
        $data = Barang::findByUuid($uuid);

        if ($data) {
            if (isset($data->promo->potongan_harga)) {
                if ($data->promo->periode_awal <= Carbon::now() && $data->promo->periode_akhir >= Carbon::now()) {
                    $data->harga_diskon = $data->harga - ($data->harga * $data->promo->potongan_harga / 100);
                }
            }
        };

        return response()->json(['item' => $data]);
    }

    public function beli(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'kuantitas' => 'required|numeric|min:1',
        ]);

        $barang = Barang::where('id', $data['barang_id'])->first();
        $total = $barang->harga * $data['kuantitas'];

        if (isset($barang->promo->potongan_harga)) {
            if ($barang->promo->periode_awal <= Carbon::now() && $barang->promo->periode_akhir >= Carbon::now()) {
                $total = $total - ($total * $barang->promo->potongan_harga / 100);
            }
        }

        do {
            $order_id = 'BWID' . mt_rand(100000, 999999);
        } while (Pembayaran::where('order_id', $order_id)->exists());

        $pembayaran = Pembayaran::create([
            'order_id' => $order_id,
            'user_id' => auth()->user()->id,
            'barang_id' => $barang->id,
            'kuantitas' => $data['kuantitas'],
            'total_harga' => $total,
            'status' => 'pending',
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $pembayaran->total_harga,
            )
        );

        $token = \Midtrans\Snap::getSnapToken($params);


        return response()->json([
            'token' => $token,
            'order_id' => $order_id,
        ]);
    }

    public function checkStatus(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string',
        ]);

        $pembayaran = Pembayaran::where('order_id', $data['order_id'])->first();

        $uuid = null;

        if ($data['status'] == 'success') {
            $barang = Barang::where('id', $pembayaran->barang_id)->first();
            $barang->update(['stok' => $barang->stok - $pembayaran->kuantitas]);

            $pengiriman = Pengiriman::create([
                'order_id' => $data['order_id'],
                'status' => 'dikemas',
            ]);

            $uuid = $pengiriman->uuid;

            $pembayaran->update(['pengiriman_id' => $pengiriman->id]);
        }

        $pembayaran->update(['status' => $data['status']]);

        return response()->json([
            'order_id' => $pembayaran->order_id,
            'uuid' => $uuid,
        ]);
    }

    public function keranjang(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'harga' => 'required|numeric',
        ]);

        $keranjang = Keranjang::where('user_id', $data['user_id'])->where('barang_id', $data['barang_id'])->first();

        if ($keranjang) {
            return response()->json(['message' => 'Item sudah ada di keranjang']);
        }

        if (!$keranjang) {
            $keranjang = Keranjang::create([
                'barang_id' => $data['barang_id'],
                'user_id' => $data['user_id'],
                'kuantitas' => 1,
                'total_harga' => $data['harga'],
            ]);

            return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang']);
        }
    }

    public function invoice($uuid)
    {
        $data = Pengiriman::findByUuid($uuid);

        return response()->json(['item' => $data]);
    }

    public function komentarItem($id)
    {
        $data = Komentar::where('barang_id', $id)->paginate(5);

        return response()->json(['items' => $data]);
    }

    public function tambahKomentar(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'komentar' => 'required|string',
        ]);

        $komentar = Komentar::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $komentar
        ]);
    }
}
