<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => Barang::all(),
        ]);
    }

    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Barang::where(function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%')
                ->orWhere('harga', 'LIKE', '%' . $request->search . '%')
                ->orWhereHas('kategori', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->search . '%');
                });
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:1',
            'kategori_id' => 'required|exists:kategoris,id',
            'promo_id' => 'nullable|exists:promos,id',
        ]);

        $barang = Barang::create($data);

        if ($request->hasFile('image')) {
            $images = [];

            foreach ($request->file('image') as $image) {
                $images[] = ['image' => $image->store('barang', 'public')];
            }

            $barang->barang_images()->createMany($images);
        }

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $barang
        ]);
    }

    public function show($uuid)
    {
        $barang = Barang::with('barang_images')->where('uuid', $uuid)->first();

        return response()->json([
            'data' => $barang
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:1',
            'kategori_id' => 'required|exists:kategoris,id',
            'promo_id' => 'nullable|exists:promos,id',
        ]);

        $barang = Barang::findByUuid($uuid);

        if ($request->hasFile('image')) {
            $images = [];

            foreach ($barang->barang_images as $barang_image) {
                Storage::disk('public')->delete($barang_image->image);
            }
            $barang->barang_images()->delete();

            foreach ($request->file('image') as $image) {
                $images[] = ['image' => $image->store('barang', 'public')];
            }
            $barang->barang_images()->createMany($images);
        }

        $barang->update($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $barang
        ]);
    }

    public function destroy($uuid)
    {
        $barang = Barang::findByUuid($uuid);

        $barang->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
