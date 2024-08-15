<?php

namespace App\Http\Controllers;

use App\Models\JadwalTayang;
use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'judul_movie' => 'required',
            'nama_studio' => 'required',
            'tanggal_tayang' => ['required','date'],
            'jam_tayang' =>  ['required'],
            'harga_tiket' => 'required'
        ]);
        $user = Auth::guard('api')->user();
        if (!$user->is_admin) {
            return response()->json([
                'message' => 'Forbidden access',
            ], 403);
        }
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }
        $movie = Movie::where('judul', $request->judul_movie)->first();
        if (!$movie) {
            return response()->json([
                'message' => 'Movie not found'
            ], 404);
        }
        $studio = Studio::where('name', $request->nama_studio)->first();
        if (!$studio) {
            return response()->json([
                'message' => 'Studio not found'
            ], 404);
        }
        $jadwal = new JadwalTayang();
        $jadwal->id_movie = $movie->id;
        $jadwal->id_studio = $studio->id;
        $jadwal->tanggal_tayang = $request->tanggal_tayang;
        $jadwal->jam_tayang = $request->jam_tayang;
        $jadwal->harga_tiket = $request->harga_tiket;
        $jadwal->save();

        return response()->json([
            'message' => 'Add jadwal success',
            'jadwal' => $jadwal
        ], 200);
    }
    public function get(){
        $jadwal = JadwalTayang::get();

        return response()->json([
            'message' => 'Get all jadwal success',
            'jadwal' => $jadwal
        ], 200);
    }

}
