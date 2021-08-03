<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayah = Wilayah::all();
        return view('admin.wilayah.index', compact('wilayah'));
    }

    public function create()
    {
        return view('admin.wilayah.create');
    }

    public function store(Request $request)
    {
        $nama_wilayah = $request->nama_wilayah;

        Wilayah::insert(['nama_wilayah' => $nama_wilayah]);

        return redirect('/wilayah');
    }

    public function edit($kd_wilayah)
    {
        $wilayah = DB::table('wilayah')->where('kd_wilayah', $kd_wilayah)->first();
        
        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, $kd_wilayah)
    {
        $nama_wilayah = $request->nama_wilayah;
        DB::table('wilayah')->where('kd_wilayah', $kd_wilayah)->update(['nama_wilayah' => $nama_wilayah]);

        
        return redirect('/wilayah');
    }

    public function destroy($kd_wilayah)
    {
        Wilayah::where('kd_wilayah', $kd_wilayah)->delete();
        return redirect('/wilayah');
    }
}
