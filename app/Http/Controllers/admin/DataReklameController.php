<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Data_reklame;
use App\Models\Jenis_reklame;
use App\Models\Wilayah;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class DataReklameController extends Controller
{
    public function index(){
        $data_reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        return view('admin.datareklame.index', compact('data_reklame'));
    }

    public function create(){
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $data['jenis_reklame'] = Jenis_reklame::all();
        $data['wilayah'] = Wilayah::all();
        $data['email'] = DB::select("SELECT * FROM users WHERE level = '1' OR level = '2' ");
        return view('admin.datareklame.create', $data);
    }

    public function store(Request $request){
        $ukuran = $request->ukuran;
        $harga = $request->harga;
        $status = 0;
        $email = $request->email;
        $kd_jenis = $request->kd_jenis;
        $kd_wilayah = $request->kd_wilayah;
        $lat = $request->lat;
        $lng = $request->lng;
        $alamat = $request->alamat;

        $request->validate([
            'foto' => 'required|mimes:jpg,png'
        ]);

        $namaFoto = time().'.'.$request->foto->extension();

        $request->foto->move(public_path('foto_reklame'), $namaFoto);

        $data_reklame = [
            'ukuran' => $ukuran,
            'harga' => $harga,
            'status' => $status,
            'email' => $email,
            'kd_jenis' => $kd_jenis,
            'kd_wilayah' => $kd_wilayah,
            'lat' => $lat,
            'lng' => $lng,
            'foto' => $namaFoto,
            'alamat' => $alamat
        ];

        Data_reklame::insert($data_reklame);

        return redirect('/datareklame');
    }

    public function edit($kd_reklame){
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $data['reklame'] = DB::table('data_reklame')->where('kd_reklame', $kd_reklame)->first();
        $data['jenis_reklame'] = Jenis_reklame::all();
        $data['wilayah'] = Wilayah::all();
        $data['email'] = DB::select("SELECT * FROM users WHERE level = '1' OR level = '2' ");
        
        return view('admin.datareklame.edit', $data);
    }

    public function update(Request $request, $kd_reklame){

        $reklame = DB::table('data_reklame')->where('kd_reklame', $kd_reklame)->first();

        if(!$request->foto){
            $namaFoto = $reklame->foto;
        }else{
            $request->validate([
                'foto' => 'mimes:jpg,png'
            ]);
            $namaFoto = time().'.'.$request->foto->extension();
            if (!empty($reklame->foto)) {
                unlink('foto_reklame/'.$reklame->foto);
            }
            $request->foto->move(public_path('foto_reklame'), $namaFoto);
        }

        $ukuran = $request->ukuran;
        $harga = $request->harga;
        $email = $request->email;
        $kd_jenis = $request->kd_jenis;
        $kd_wilayah = $request->kd_wilayah;
        $lat = $request->lat;
        $lng = $request->lng;
        $alamat = $request->alamat;

        $data_reklame = [
            'ukuran' => $ukuran,
            'harga' => $harga,
            'alamat' => $alamat,
            'email' => $email,
            'kd_jenis' => $kd_jenis,
            'kd_wilayah' => $kd_wilayah,
            'lat' => $lat,
            'lng' => $lng,
            'foto' => $namaFoto
        ];

        DB::table('data_reklame')->where('kd_reklame', $kd_reklame)->update($data_reklame);

        return redirect('/datareklame');
    }

    public function destroy($kd_reklame){
        Data_reklame::where('kd_reklame',$kd_reklame)->delete();
        return redirect('/datareklame');
    }
}
