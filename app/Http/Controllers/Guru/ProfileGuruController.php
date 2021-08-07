<?php

namespace App\Http\Controllers\Guru;

use App\Helper\CustomController;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileGuruController extends CustomController
{
    //
    public function index(){
        $profile = User::with('getGuru')->find(Auth::id());
        return view('guru.profile')->with(['data' => $profile]);
    }
}
