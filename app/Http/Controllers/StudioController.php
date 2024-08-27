<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudioController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:studios'],
            'jumlah_kursi' => 'required',
            'judul_movie' => 'required',
        ]);
        // $user = Auth::guard('api')->user();
        // if (!$user->is_admin) {
        //     return response()->json([
        //         'message' => 'Forbidden access',
        //     ], 403);
        // }
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }
        $movie = Movie::where('judul', $request->judul_movie)->first();

        $studio = new Studio();
        $studio->name = $request->name;
        $studio->jumlah_kursi = $request->jumlah_kursi;
        $studio->id_movie = $movie->id;
        $studio->save();

        return response()->json([
            'message' => 'add studio success',
            'studio' => $studio
        ], 200);
    }
    public function get(){
        $movies = Studio::get();
        return response()->json([
            'messagge' => 'Get movies success',
            'movies' => $movies
        ], 200);
    }
}
