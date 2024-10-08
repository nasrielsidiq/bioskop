<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\StudioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::middleware('jwtauth')->group(function () {
    Route::get('/admin/add/{id}', [AuthController::class, 'addAdmin']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/movie/add', [MovieController::class, 'create']);
    Route::get('/movie/get', [MovieController::class, 'get']);
    Route::get('/movie/get/{id}', [MovieController::class,'getById']);
    Route::post('/movie/update/{id}', [MovieController::class, 'update']);
    Route::delete('/movie/delete/{id}', [MovieController::class, 'delete']);
    Route::post('/studio/add', [StudioController::class, 'create']);
    Route::get('/studio/get', [StudioController::class, 'get']);
    Route::post('/jadwal/add', [JadwalController::class, 'create']);
    Route::get('/jadwal/get', [JadwalController::class, 'get']);
    Route::post('/pemesanan/add', [PemesananController::class, 'create']);
    Route::get('/pemesanan/get', [PemesananController::class, 'get']);
});
