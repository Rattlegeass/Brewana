<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiskonController extends Controller
{
    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => Diskon::all(),
        ]);
    }

    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Diskon::with(['promo', 'barang'])->where(function ($q) use ($request) {
            $q->whereHas('promo', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('barang', function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->search . '%');
            });
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'promo_id' => 'required|exists:promos,id',
            'barang_id' => 'required|exists:barangs,id',
            'potongan_harga' => 'required|numeric|min:1',
        ]);

        $diskon = Diskon::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $diskon
        ]);
    }

    public function show($uuid)
    {
        $diskon = Diskon::findByUuid($uuid);

        return response()->json([
            'data' => $diskon
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->validate([
            'promo_id' => 'required|exists:promos,id',
            'barang_id' => 'required|exists:barangs,id',
            'potongan_harga' => 'required|numeric|min:1',
        ]);

        $diskon = Diskon::findByUuid($uuid);
        $diskon->update($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $diskon
        ]);
    }

    public function destroy($uuid)
    {
        $diskon = Diskon::findByUuid($uuid);

        $diskon->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
