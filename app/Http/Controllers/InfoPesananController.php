<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Bukti_bayar;
use App\Models\Penyewa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class InfoPesananController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $email = $user->email;
        $data['pesanan'] = DB::select("SELECT pesanan.*, pesanan.status as status_pesanan ,penyewa.email as penyewa, data_reklame.*, users.name, users.level FROM pesanan, penyewa, data_reklame, users WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND penyewa.email = '$email' AND users.email = data_reklame.email COLLATE utf8mb4_unicode_ci GROUP BY pesanan.kd_pesan DESC");
        $data['pengajuan'] = Pengajuan::all();
        $data['vendor'] = DB::table('vendor')->get();
        return view('user.infopesanan', $data);
    }

    public function bayar(Request $request, $kd_pesan)
    {
        $request->validate([
            'foto_bukti' => 'required|mimes:jpg,png'
        ]);

        $namaFoto = time().'.'.$request->foto_bukti->extension();

        $request->foto_bukti->move(public_path('foto_bukti'), $namaFoto);

        $data_bukti = [
            'foto_bukti' => $namaFoto,
            'kd_pesan' => $kd_pesan
        ];

        Bukti_bayar::insert($data_bukti);
        DB::table('pesanan')->where('kd_pesan', $kd_pesan)->update(['status' => 'tunggu verifikasi']);
        return redirect("/infopesanan")->with('success', 'Tunggu konfirmasi dari pemilik reklame');
    }

    public function updatebukti(Request $request, $kd_pesan)
    {
        $request->validate([
            'foto_bukti' => 'required|mimes:jpg,png'
        ]);

        $namaFoto = time().'.'.$request->foto_bukti->extension();

        $request->foto_bukti->move(public_path('foto_bukti'), $namaFoto);

        $data_bukti = [
            'foto_bukti' => $namaFoto,
            'kd_pesan' => $kd_pesan
        ];

        $bukti_bayar = DB::table('bukti_bayar')->where('kd_pesan', $kd_pesan)->first();
        unlink('foto_bukti/'.$bukti_bayar->foto_bukti);
        DB::table('bukti_bayar')->where('kd_pesan', $kd_pesan)->delete();

        Bukti_bayar::insert($data_bukti);
        DB::table('pesanan')->where('kd_pesan', $kd_pesan)->update(['status' => 'reupload']);
        return redirect("/infopesanan")->with('success', 'Tunggu verifikasi dari pemilik reklame');
    }

    public function downloadsurat(Request $request, $kd_pesan)
    {
        $user = $request->user();
        $email = $user->email;

        $data['user'] = User::all();
        // $data['penyewa'] = Penyewa::all();
        $data['surat_izin'] = DB::select("SELECT pesanan.*, penyewa.email as penyewa, penyewa.alamat as alamat_penyewa, data_reklame.*, pesanan.status as status_pesan, pesanan.*, jenis_reklame.*, data_reklame.alamat as alamat_pemasangan FROM pesanan, penyewa, data_reklame, jenis_reklame WHERE pesanan.kd_reklame = data_reklame.kd_reklame AND penyewa.kd_penyewa = pesanan.kd_penyewa AND pesanan.kd_pesan = '$kd_pesan' AND jenis_reklame.kd_jenis = data_reklame.kd_jenis ");
        $pdf = PDF::loadView('user.surat_izin', $data);
        return $pdf->download('surat_izin.pdf');
    }
}
