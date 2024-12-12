<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => Kategori::all(),
        ]);
    }

    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Kategori::where(function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%');
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string'
        ]);

        $kategori = Kategori::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $kategori
        ]);
    }

    public function show($uuid)
    {
        $kategori = Kategori::findByUuid($uuid);

        return response()->json([
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->validate([
            'nama' => 'required|string'
        ]);

        $kategori = Kategori::findByUuid($uuid);
        $kategori->update($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $kategori
        ]);
    }

    public function destroy($uuid)
    {
        $kategori = Kategori::findByUuid($uuid);

        $kategori->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
