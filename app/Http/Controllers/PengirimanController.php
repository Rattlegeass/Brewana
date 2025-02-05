<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Pengiriman::whereHas('pembayaran', function ($q) use ($request) {
            $q->whereHas('barang', function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function updateStatus(Request $request, $uuid)
    {
        $pembayaran = Pengiriman::findByUuid($uuid);

        if ($request->status == 'dikemas') {
            $pembayaran->update(['status' => 'dikirim']);
        } else if ($request->status == 'dikirim') {
            $pembayaran->update(['status' => 'diterima']);
        } else if ($request->status == 'diterima') {
            $pembayaran->update(['status' => 'refund']);
        } else {
            return response()->json(['message' => 'Error!'], 400);
        }

        return response()->json(['message' => 'Status Berhasil Diubah!']);
    }
}
