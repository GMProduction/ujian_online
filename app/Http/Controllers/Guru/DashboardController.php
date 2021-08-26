<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Nilai;
use App\Models\Paket;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $paket = Paket::where('id_user', '=', Auth::id())->limit(10)->get();
        $nilai = Nilai::setNilai()->with(['getPaket', 'getUser.getSiswa'])->whereHas('getPaket', function ($q) {
            $q->where('id_user','=',Auth::id());
        })->limit(10)->get();

        return view('guru.dashboard')->with(['paket' => $paket, 'nilai' => $nilai]);
    }
}
