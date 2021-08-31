<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class APIKelasController extends Controller
{
    //
    public function index(){
        $kelas = Kelas::all();
        return $kelas;
    }
}
