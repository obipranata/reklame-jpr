<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $email = $user->email;

        $pengajuan = DB::select("SELECT pesanan.*, penyewa.email as penyewa, data_reklame.*, pesanan.status as status_pesan,pengajuan.kd_pengajuan, pengajuan.status_pengajuan FROM pesanan, penyewa, data_reklame, pengajuan WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND data_reklame.email = '$email' AND pengajuan.kd_pesan = pesanan.kd_pesan ");
        return view('vendor.pengajuan', compact('pengajuan'));
    }

    public function uploadbukti(Request $request, $kd_pengajuan)
    {
        $request->validate([
            'foto_bukti' => 'required|mimes:jpg,png'
        ]);

        $namaFoto = time().'.'.$request->foto_bukti->extension();

        $request->foto_bukti->move(public_path('foto_bukti'), $namaFoto);

        $data_bukti = [
            'status_pengajuan' => 'tunggu verifikasi dari dinas',
            'foto_bukti' => $namaFoto
        ];

        DB::table('pengajuan')->where('kd_pengajuan', $kd_pengajuan)->update($data_bukti);
        
        return redirect("/vendor/pengajuan");
    }

    public function download(Request $request, $kd_pengajuan)
    {
        $user = $request->user();
        $email = $user->email;

        $data['user'] = User::all();
        $data['data_vendor'] = Vendor::all();
        $data['surat_izin'] = DB::select("SELECT pesanan.*, penyewa.email as penyewa, data_reklame.*, pesanan.status as status_pesan,pengajuan.kd_pengajuan, pengajuan.status_pengajuan, jenis_reklame.*, pesanan.* FROM pesanan, penyewa, data_reklame, pengajuan, jenis_reklame WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND data_reklame.email = '$email' AND pengajuan.kd_pesan = pesanan.kd_pesan AND pengajuan.kd_pengajuan = '$kd_pengajuan' AND jenis_reklame.kd_jenis = data_reklame.kd_jenis ");
        // return view('vendor.surat_izin', $data);
        $pdf = PDF::loadView('vendor.surat_izin', $data);
        return $pdf->download('surat_izin.pdf');
    }
}
