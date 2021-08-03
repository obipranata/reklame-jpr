<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jenis_reklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisReklameController extends Controller
{
    public function index(){
        $jenis_reklame = Jenis_reklame::all();
        return view('admin.jenisreklame.index', compact('jenis_reklame'));
    }

    public function create(){
        return view('admin.jenisreklame.create');
    }

    public function store(Request $request){
        $nama_reklame = $request->nama_reklame;

        $kd_terakhir = DB::select("SELECT * FROM `jenis_reklame` ORDER BY kd_jenis DESC LIMIT 1");
        if(empty($kd_terakhir)){
            $kd_jenis = 'JNS-01';
        }else{
            $kd_terakhir_gejala = substr($kd_terakhir[0]->kd_jenis, 4);
            $kd_jenis = 'JNS-'.sprintf('%02d', $kd_terakhir_gejala+1);
        }

        Jenis_reklame::insert([
            'kd_jenis' => $kd_jenis,
            'nama_reklame' => $nama_reklame
        ]);

        return redirect('/jenisreklame');
    }

    public function edit($kd_jenis){
        $jenis_reklame = DB::table('jenis_reklame')->where('kd_jenis', $kd_jenis)->first();
        
        return view('admin.jenisreklame.edit', compact('jenis_reklame'));
    }

    public function update(Request $request, $kd_jenis){
        $nama_reklame = $request->nama_reklame;
        DB::table('jenis_reklame')->where('kd_jenis', $kd_jenis)->update(['nama_reklame' => $nama_reklame]);

        return redirect('/jenisreklame');
    }

    public function destroy($kd_jenis){
        Jenis_reklame::where('kd_jenis',$kd_jenis)->delete();
        return redirect('/jenisreklame');
    }
}
