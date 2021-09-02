<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    //
    public function index(){
        $siswa = User::with('getSiswa')->role('siswa')->paginate(10);
        $kelas = Kelas::all();
        $data = [
            'data' => $siswa,
            'kelas' => $kelas
        ];
//        return $siswa;
        return view('admin.siswa')->with($data);
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            User::destroy($id);
            Siswa::where('id_user', '=',$id)->delete();
            DB::commit();
            return response()->json(['msg' => 'success']);
        }catch (\Exception $err){
            DB::rollBack();
            return response()->json(['msg' => $err->getMessage()], 501);
        }
    }
}
