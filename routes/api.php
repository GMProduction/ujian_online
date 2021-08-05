<?php

use App\Http\Controllers\APINilaiController;
use App\Http\Controllers\APIPaketController;
use App\Http\Controllers\APIProfileSiswaController;
use App\Http\Controllers\APISoalController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']],function () {
        Route::match(['post', 'get'], '/profile', [APIProfileSiswaController::class, 'index']);
        Route::get('/paket-ongoing', [APIPaketController::class, 'ongoing']);
        Route::get('/paket-coming-soon', [APIPaketController::class, 'comingSoon']);
        Route::get('/paket/{id}', [APIPaketController::class, 'detailPaket']);
        Route::get('/paket/{id}/soal', [APIPaketController::class, 'getSoal']);
        Route::get('/paket', [APIPaketController::class, 'paketFinish']);

        Route::get('/soal/{id}', [APISoalController::class, 'getSoal']);
        Route::post('/soal/{id}', [APISoalController::class, 'jawabSoal']);

        Route::get('/nilai/{id}', [APINilaiController::class, 'index']);

        Route::get('/rangking/{id}', [APINilaiController::class, 'rangking']);
    }
);
