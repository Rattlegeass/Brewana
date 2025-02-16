<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Pembayaran::with('pengiriman')->where(function ($q) use ($request) {
            $q->whereHas('barang', function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
            });
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function updateStatus(Request $request, $uuid)
    {
        $pembayaran = Pembayaran::findByUuid($uuid);

        if ($request->status == 'refund') {
            $pembayaran->update(['status' => $request->status]);

            $barang = Barang::where('id', $pembayaran->barang_id)->first();
            $barang->update(['stok' => $barang->stok + $pembayaran->kuantitas]);

            // $pengiriman = Pengiriman::where('pembayaran_id', $pembayaran->id)->first();
            // $pengiriman->update(['status' => 'refund']);
        } else {
            return response()->json(['message' => 'Error!'], 400);
        }

        return response()->json(['message' => 'Status Berhasil Diubah!']);
    }
}
