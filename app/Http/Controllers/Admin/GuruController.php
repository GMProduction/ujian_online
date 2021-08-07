<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    //
    public function index(){
        $guru = User::with('getGuru')->role('guru')->paginate(10);
        return view('admin.guru')->with(['data' => $guru]);
    }
}
