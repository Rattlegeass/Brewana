<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function get()
    {
        return response()->json([
            'success' => true,
            'data' => Promo::all(),
        ]);
    }

    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0+' . $page * $per);
        $data = Promo::where(function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%');
        })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
        ], [
            'periode_awal.before' => 'Periode awal harus sebelum periode akhir',
            'periode_akhir.after' => 'Periode akhir harus setelah periode awal',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promo', 'public');
        }
        $promo = Promo::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $promo
        ]);
    }

    public function show($uuid)
    {
        $promo = Promo::findByUuid($uuid);

        return response()->json([
            'data' => $promo
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
        ], [
            'periode_awal.before' => 'Periode awal harus sebelum periode akhir',
            'periode_akhir.after' => 'Periode akhir harus setelah periode awal',
        ]);

        $promo = Promo::findByUuid($uuid);
        if ($request->hasFile('image')) {
            if ($promo->image) {
                Storage::disk('public')->delete($promo->image);
            }
            $data['image'] = $request->file('image')->store('promo', 'public');
        } else {
            if ($promo->image) {
                Storage::disk('public')->delete($promo->image);
                $data['image'] = null;
            }
        }
        $promo->update($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $promo
        ]);
    }

    public function destroy($uuid)
    {
        $promo = Promo::findByUuid($uuid);

        if ($promo->image) {
            Storage::disk('public')->delete($promo->image);
        }
        $promo->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
