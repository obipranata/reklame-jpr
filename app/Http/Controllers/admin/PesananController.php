<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        $email = $user->email;

        $pesanan = DB::select("SELECT pesanan.*, penyewa.email as penyewa, data_reklame.*, pesanan.status as status_pesan, users.name, users.level FROM pesanan, penyewa, data_reklame, users WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND data_reklame.email = '$email' AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci ");
        return view('admin.pesanan', compact('pesanan'));
    }

    public function verifikasi(Request $request){
        $user = $request->user();
        $email = $user->email;

        $pesanan = DB::select("SELECT * FROM pesanan WHERE status !='selesai' ");

        // dd($pesanan);

        foreach ($pesanan as $p){
            $lama_sewa = $p->lama_sewa * 30;
            $tgl_penurunan = date('Y-m-d', strtotime((date($p->tgl_pesan)) . "+ $lama_sewa day"));
            $tgl1 = new DateTime(date('Y-m-d'));
            $tgl2 = new DateTime($tgl_penurunan);
            $diff = date_diff($tgl2, $tgl1);
            $selisih = $diff->format('%r%a');

            // var_dump($selisih);
            if ($selisih >= 0){
                DB::table('pesanan')->where('kd_pesan', $p->kd_pesan)->update(['status' => 'selesai']);
                DB::table('data_reklame')->where('kd_reklame', $p->kd_reklame)->update(['status' => 0]);
            }
        }

        // dd($selisih);

        $bukti_bayar = DB::select("SELECT pesanan.*, penyewa.email as penyewa, data_reklame.*, bukti_bayar.*, pesanan.status as status_pesan, users.name, users.level FROM pesanan, penyewa, data_reklame, bukti_bayar, users WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND data_reklame.email = '$email' AND bukti_bayar.kd_pesan = pesanan.kd_pesan AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci");
        return view('admin.bukti_bayar', compact('bukti_bayar'));
    }

    public function updatebayar(Request $request, $kd_pesan){
        $status = $request->status;
        DB::table('pesanan')->where('kd_pesan', $kd_pesan)->update(['status' => $status]);

        return redirect('/admin/buktibayar');
    }
    public function updatepesan(Request $request, $kd_pesan){
        $status = $request->status;
        DB::table('pesanan')->where('kd_pesan', $kd_pesan)->update(['status' => $status]);

        return redirect('/admin/pesanan');
    }

    public function hapus($kd_pesan){
        $pesanan = DB::table('pesanan')->where('kd_pesan', $kd_pesan)->first();
        $kd_reklame = $pesanan->kd_reklame;
        
        $data_pesanan = DB::select("SELECT * FROM pesanan WHERE kd_reklame = '$kd_reklame' AND status != 'selesai' AND status != 'belum upload bukti pembayaran' ");

        
        if(empty($data_pesanan)){
            DB::table('data_reklame')->where('kd_reklame', $kd_reklame)->update(['status' => 0]);
        }
        DB::table('pesanan')->where('kd_pesan', $kd_pesan)->delete();

        return redirect('/admin/pesanan');
    }
}
