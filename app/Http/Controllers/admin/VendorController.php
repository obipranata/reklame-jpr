<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index(){
        $vendor = Vendor::all();
        return view('admin.vendor.index', compact('vendor'));
    }

    public function create(){
        return view('admin.vendor.create');
    }

    public function store(Request $request){
        $nama_pt = $request->nama_pt;
        $email = $request->email;
        $alamat = $request->alamat;
        $no_tlp = $request->no_tlp;
        $no_rek = $request->no_rek;

        $request->validate([
            'nama_pt' => 'required|unique:vendor|max:35',
            'email' => 'required|unique:vendor|max:35',
        ]);

        $data_vendor = [
            'nama_pt' => $nama_pt,
            'email' => $email,
            'alamat' => $alamat,
            'no_tlp' => $no_tlp,
            'no_rek' => $no_rek,
        ];

        $data_user = [
            'name' => $nama_pt,
            'email' => $email,
            'password' => Hash::make(12345678),
            'level' => 2
        ];

        Vendor::insert($data_vendor);
        User::insert($data_user);

        return redirect('/vendor');
    }

    public function edit($kd_vendor){
        $vendor = DB::table('vendor')->where('kd_vendor', $kd_vendor)->first();
        $user = DB::table('users')->where('email', $vendor->email)->first();

        
        return view('admin.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $kd_vendor){

        $nama_pt = $request->nama_pt;
        $email = $request->email;
        $alamat = $request->alamat;
        $no_tlp = $request->no_tlp;
        $no_rek = $request->no_rek;

        $vendor = DB::table('vendor')->where('kd_vendor', $kd_vendor)->first();
        $user = DB::table('users')->where('email', $vendor->email)->first();

        // dd($user);

        $data_vendor = [
            'nama_pt' => $nama_pt,
            'email' => $email,
            'alamat' => $alamat,
            'no_tlp' => $no_tlp,
            'no_rek' => $no_rek,
        ];

        DB::table('vendor')
            ->where('kd_vendor', $kd_vendor)
            ->update($data_vendor);
            
        DB::table('users')
            ->where('id', $user->id)
            ->update(['email' => $email]);
        return redirect('/vendor');
    }

    public function destroy($kd_vendor){
        $vendor = DB::table('vendor')->where('kd_vendor', $kd_vendor)->first();
        $user = DB::table('users')->where('email', $vendor->email)->first();

        User::where('id', $user->id)->delete();
        Vendor::where('kd_vendor', $kd_vendor)->delete();

        return redirect('/vendor');
    }
}
