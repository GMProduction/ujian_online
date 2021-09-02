<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    //
    public function index(){
        $guru = User::with('getGuru')->role('guru')->paginate(10);
        return view('admin.guru')->with(['data' => $guru]);
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            User::destroy($id);
            Guru::where('id_user', '=',$id)->delete();
            DB::commit();
            return response()->json(['msg' => 'success']);
        }catch (\Exception $err){
            DB::rollBack();
            return response()->json(['msg' => $err->getMessage()],501);
        }
    }
}
