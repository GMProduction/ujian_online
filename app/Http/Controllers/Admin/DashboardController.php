<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        $paket = Paket::with(['getUser.getGuru','getSoal'])->limit(10)->get();
        $nilai = Nilai::setNilai()->with(['getPaket', 'getUser.getSiswa'])->limit(10)->get();
        return view('admin.dashboard')->with(['paket' => $paket, 'nilai' => $nilai]);
    }
}
