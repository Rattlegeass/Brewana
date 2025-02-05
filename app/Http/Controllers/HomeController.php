<?php

namespace App\Http\Controllers;

use App\Models\UmpanBalik;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function umpanBalik(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
        ]);

        $umpanBalik = UmpanBalik::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $umpanBalik
        ]);
    }
}
