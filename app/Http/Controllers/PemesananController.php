<?php

namespace App\Http\Controllers;

use App\Models\KursiPesanan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'no_kursi' => ['required', 'array'],
            'id_jadwal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input',
                'erorrs' => $validator->errors()
            ], 422);
        }
        $user = Auth::guard('api')->user();
        $pesanan = new Pemesanan();
        $pesanan->id_user = $user->id;
        $pesanan->id_jadwal = $request->id_jadwal;
        $pesanan->save();

        if ($pesanan) {
            foreach ($request->no_kursi as $key) {
                $kursi = new KursiPesanan();
                $kursi->id_pemesanan = $pesanan->id;
                $kursi->no_kursi = $key;
                $kursi->save();
            }
        }
        // $getKursi = KursiPesanan::where('id_pemesanan', $pesanan->id)->get();

        return response()->json([
            'message' => 'Pesanan success',
            'pesanan' =>    $pesanan->with('kursi')
        ], 200);
    }
    public function get(){
        $movies = Pemesanan::with('kursi')->get();
        return response()->json([
            'messagge' => 'Get movies success',
            'movies' => $movies
        ], 200);
    }
}
