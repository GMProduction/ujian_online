<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\NilaiGuruController;
use App\Http\Controllers\Guru\ProfileGuruController;
use App\Http\Controllers\Guru\SoalGuruController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuruMiddleware;
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
        return redirect('/login');
    }
);

Route::get(
    '/login',
    function () {
        return view('login');
    }
);

Route::post('/login', [AuthController::class, 'loginAdmin']);
Route::get('/logout', [AuthController::class, 'logoutAdmin']);
Route::prefix('/admin')->middleware(AdminMiddleware::class)->group(
    function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::match(['post', 'get'], '/kelas', [KelasController::class, 'index']);
        Route::get( '/kelas/{id}/delete', [KelasController::class, 'delete']);
        Route::get('/kelas/all',[KelasController::class,'getKelas']);
        Route::match(['post', 'get'], '/paket-soal', [SoalController::class, 'paketAll'])->name('paket');
        Route::get('/paket-soal/{id}', [SoalController::class, 'paketSoal'])->name('paket_soal');
        Route::match(['post', 'get'], '/paket-soal/{id}/soal', [SoalController::class, 'soal'])->name('detail_soal');
        Route::get('/paket-soal/{id}/soal/detail', [SoalController::class, 'getDetailSoal'])->name('detail_soal_jawaban');
        Route::get('/paket-soal/delete/{id}', [SoalController::class, 'deletePaket'])->name('delete_paket_guru');
        Route::get('/paket-soal/soal/delete/{id}', [SoalController::class, 'soal'])->name('detail_soal_guru');

        Route::get('/guru', [GuruController::class, 'index']);
        Route::get('/guru/{id}/delete', [GuruController::class, 'delete']);
        Route::get('/siswa', [SiswaController::class, 'index']);
        Route::get('/siswa/{id}/delete', [SiswaController::class, 'delete']);
        Route::get('/nilai', [NilaiController::class, 'index']);
        Route::get('/nilai/{id}', [NilaiController::class, 'detail'])->name('nilai_paket');
    }
);

Route::prefix('/guru')->middleware(GuruMiddleware::class)->group(
    function () {
        Route::get('/', [\App\Http\Controllers\Guru\DashboardController::class, 'index']);
        Route::get('/profile', [ProfileGuruController::class, 'index']);

        Route::match(['post', 'get'], '/paket-soal', [SoalGuruController::class, 'paketAll'])->name('paket_guru');
        Route::get('/paket-soal/{id}', [SoalGuruController::class, 'paketSoal'])->name('paket_soal_guru');
        Route::get('/paket-soal/delete/{id}', [SoalGuruController::class, 'deletePaket'])->name('delete_paket_guru');
        Route::match(['post', 'get'], '/paket-soal/{id}/soal', [SoalGuruController::class, 'soal'])->name('detail_soal_guru');
        Route::get('/paket-soal/soal/delete/{id}', [SoalGuruController::class, 'soal'])->name('detail_soal_guru');
        Route::get('/paket-soal/{id}/soal/detail', [SoalGuruController::class, 'getDetailSoal'])->name('detail_soal_jawaban_guru');
        Route::get('/nilai', [NilaiGuruController::class, 'index']);
        Route::get('/nilai/{id}', [NilaiGuruController::class, 'detail'])->name('nilai_paket_guru');
    }
);

