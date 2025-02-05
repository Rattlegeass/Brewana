<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function show($uuid)
    {
        $user = User::findByUuid($uuid);

        return response()->json([
            'data' => $user
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->validate([
            'foto' => 'nullable|image',
            'name' => 'required|string',
        ]);

        $user = User::findByUuid($uuid);

        if ($request->hasFile('foto')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        } else {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
                $data['foto'] = null;
            }
        }

        $user->update([
            'name' => $data['name'],
            'photo' => $data['foto'],
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $user
        ]);
    }

    public function updatePassword(Request $request, $uuid)
    {
        $data = $request->validate([
            'password' => ['nullable', 'confirmed', Password::default()],
        ]);

        $user = User::findByUuid($uuid);

        $user->update($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $user
        ]);
    }

    public function riwayat()
    {
        $data = Pembayaran::with('pengiriman')->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(3);

        return response()->json(['items' => $data]);
    }
}
