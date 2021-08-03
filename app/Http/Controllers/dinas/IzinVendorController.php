<?php

namespace App\Http\Controllers\dinas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IzinVendorController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $email = $user->email;

        $pengajuan = DB::select("SELECT pesanan.*, penyewa.email as penyewa, data_reklame.*, pesanan.status as status_pesan, pengajuan.foto_bukti ,pengajuan.kd_pengajuan ,pengajuan.status_pengajuan FROM pesanan, penyewa, data_reklame, pengajuan WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND pengajuan.kd_pesan = pesanan.kd_pesan ");
        return view('dinas.izinvendor', compact('pengajuan'));
    }

    public function perizinan(Request $request, $kd_pengajuan)
    {
        $status = $request->status;
        DB::table('pengajuan')->where('kd_pengajuan', $kd_pengajuan)->update(['status_pengajuan' => $status]);

        return redirect('/dinas/izinvendor');
    }
}
