<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SoalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::prefix('/admin')->group(
    function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::match(['post', 'get'],'/paket-soal', [SoalController::class, 'paketAll'])->name('paket');
        Route::get('/paket-soal/{id}', [SoalController::class, 'paketSoal'])->name('paket_soal');
        Route::match(['post', 'get'], '/paket-soal/{id}/soal', [SoalController::class, 'soal'])->name('detail_soal');
        Route::get('/paket-soal/{id}/soal/detail', [SoalController::class, 'getDetailSoal'])->name('detail_soal_jawaban');

        Route::get('/guru', [GuruController::class, 'index']);
        Route::get('/siswa', [SiswaController::class, 'index']);
        Route::get('/nilai', [NilaiController::class, 'index']);
}
);

