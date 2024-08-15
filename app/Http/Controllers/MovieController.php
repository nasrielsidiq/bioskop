<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'judul' => ['required','unique:movies'],
            'deskripsi' => 'required',
            'durasi' => ['required', 'numeric'],
            'rating' => 'required',
            'tanggal_rilis' => ['required','date'],
            'kategori' => 'required',
            'gambar' => 'required'
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
        $gambar = $request->file('gambar');
        if ($gambar) {
            $fileName = $request->judul."_thumbnail.".$gambar->getClientOriginalExtension();
            $gambar->storeAs('thumbnail',$fileName);
        }


        $movies = new Movie();
        $movies->judul = $request->judul;
        $movies->deskripsi = $request->deskripsi;
        $movies->durasi = $request->durasi;
        $movies->rating = $request->rating;
        $movies->tanggal_rilis = $request->tanggal_rilis;
        $movies->kategori = $request->kategori;
        $movies->gambar = $fileName;
        $movies->save();

        return response()->json([
            'message'=> 'add movie success',
            'movie' => $movies
        ],200);
    }
    public function get(){
        $movies = Movie::get();
        return response()->json([
            'messagge' => 'Get movies success',
            'movies' => $movies
        ], 200);
    }
    public function getById($id){
        $movies = Movie::find($id);
        return response()->json([
            'messagge' => 'Get movies success',
            'movies' => $movies
        ], 200);
    }
}
