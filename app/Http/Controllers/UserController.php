<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $data['vendor'] = DB::select("SELECT count(kd_vendor) as jml_vendor FROM vendor");
        $data['reklame'] = DB::select("SELECT count(kd_reklame) as jml_reklame FROM data_reklame");
        $data['belum_disewa'] = DB::select("SELECT count(kd_reklame) as jml_reklame FROM data_reklame WHERE status = 0 ");
        $data['lagi_disewa'] = DB::select("SELECT count(kd_reklame) as jml_reklame FROM data_reklame WHERE status = 1 ");
        $data['data_vendor'] = Vendor::all();
        $data['user'] = User::all();
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $data['pesanan'] = DB::select("SELECT pesanan.*, max(tgl_pesan) as tgl_penurunan FROM pesanan WHERE status !='selesai' GROUP BY kd_reklame");
        return view('user.index', $data);
    }

    public function harga()
    {
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $data['pesanan'] = DB::select("SELECT pesanan.*, max(tgl_pesan) as tgl_penurunan FROM pesanan WHERE status !='selesai' GROUP BY kd_reklame");

        $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $cek_pesanan = DB::select("SELECT data_reklame.*, max(tgl_pesan), jenis_reklame.nama_reklame, wilayah.nama_wilayah, pesanan.tgl_pesan, pesanan.lama_sewa, penyewa.email as penyewa, users.name FROM data_reklame, jenis_reklame, wilayah, pesanan, penyewa, users WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND pesanan.kd_reklame = data_reklame.kd_reklame AND data_reklame.status = 1 AND penyewa.kd_penyewa = pesanan.kd_penyewa AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci GROUP BY pesanan.kd_reklame ");

        
        $data_reklame = [];
        foreach ($reklame as $dr) {
            foreach ($cek_pesanan as $c) {
                if ($dr->kd_reklame == $c->kd_reklame) {
                    $lama_sewa = $c->lama_sewa * 30;
                    $tgl_penurunan = date('Y-m-d', strtotime((date($c->tgl_pesan)) . "+ $lama_sewa day"));
                    // dd($tgl_penurunan);
            
                    $awal  = date_create();
                    $akhir = date_create($tgl_penurunan);
                    $diff = date_diff($awal, $akhir);
                    // dd($diff->days);
            
                    if ($diff->days < 2) {
                        $marker = 'merah';
                    } elseif ($diff->days <=7) {
                        $marker = 'kuning';
                    } elseif ($diff->days >7) {
                        $marker = 'hijau';
                    }
                    $data_reklame[] = [
                        'kd_reklame' => $c->kd_reklame,
                        'lat' => $c->lat,
                        'lng' => $c->lng,
                        'nama_wilayah' => $c->nama_wilayah,
                        'nama_reklame' => $c->nama_reklame,
                        'marker' => $marker,
                        'email' => $dr->email,
                        'alamat' => $dr->alamat,
                        'penyewa' => $c->name
                    ];
                }
            }
        }

        foreach ($reklame as $dr) {
            if ($dr->status == 0) {
                array_push($data_reklame, [
                    'kd_reklame' => $dr->kd_reklame,
                    'lat' => $dr->lat,
                    'lng' => $dr->lng,
                    'nama_wilayah' => $dr->nama_wilayah,
                    'nama_reklame' => $dr->nama_reklame,
                    'marker' => 'biru',
                    'email' => $dr->email,
                    'alamat' => $dr->alamat,
                    'penyewa' => 'not'
                ]);
            }
        }
        // dd($data_reklame);
        $data['data_vendor'] = Vendor::all();
        $data['user'] = User::all();
        $data['peta_reklame'] = $data_reklame;
        return view('user.harga', $data);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND (wilayah.nama_wilayah LIKE '$cari%' OR jenis_reklame.nama_reklame LIKE '$cari%' OR data_reklame.ukuran LIKE '$cari%' ) ");
        $data['pesanan'] = DB::select("SELECT pesanan.*, max(tgl_pesan) as tgl_penurunan FROM pesanan WHERE status !='selesai' GROUP BY kd_reklame");
        $data['data_vendor'] = Vendor::all();
        $data['user'] = User::all();

        $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND (wilayah.nama_wilayah LIKE '$cari%' OR jenis_reklame.nama_reklame LIKE '$cari%' OR data_reklame.ukuran LIKE '$cari%' )");
        $cek_pesanan = DB::select("SELECT data_reklame.*, max(tgl_pesan), jenis_reklame.nama_reklame, wilayah.nama_wilayah, pesanan.tgl_pesan, pesanan.lama_sewa, penyewa.email as penyewa, users.name FROM data_reklame, jenis_reklame, wilayah, pesanan, penyewa, users WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND pesanan.kd_reklame = data_reklame.kd_reklame AND data_reklame.status = 1 AND penyewa.kd_penyewa = pesanan.kd_penyewa AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci GROUP BY pesanan.kd_reklame ");
        $data_reklame = [];
        foreach ($reklame as $dr) {
            foreach ($cek_pesanan as $c) {
                if ($dr->kd_reklame == $c->kd_reklame) {
                    $lama_sewa = $c->lama_sewa * 30;
                    $tgl_penurunan = date('Y-m-d', strtotime((date($c->tgl_pesan)) . "+ $lama_sewa day"));
                    // dd($tgl_penurunan);
            
                    $awal  = date_create();
                    $akhir = date_create($tgl_penurunan);
                    $diff = date_diff($awal, $akhir);
                    // dd($diff->days);
            
                    if ($diff->days < 2) {
                        $marker = 'merah';
                    } elseif ($diff->days <=7) {
                        $marker = 'kuning';
                    } else {
                        $marker = 'hijau';
                    }
                    $data_reklame[] = [
                        'kd_reklame' => $c->kd_reklame,
                        'lat' => $c->lat,
                        'lng' => $c->lng,
                        'nama_wilayah' => $c->nama_wilayah,
                        'nama_reklame' => $c->nama_reklame,
                        'marker' => $marker,
                        'email' => $dr->email,
                        'alamat' => $dr->alamat,
                        'penyewa' => $c->name
                    ];
                }
            }
        }

        foreach ($reklame as $dr) {
            if ($dr->status == 0) {
                array_push($data_reklame, [
                    'kd_reklame' => $dr->kd_reklame,
                    'lat' => $dr->lat,
                    'lng' => $dr->lng,
                    'nama_wilayah' => $dr->nama_wilayah,
                    'nama_reklame' => $dr->nama_reklame,
                    'marker' => 'biru',
                    'email' => $dr->email,
                    'alamat' => $dr->alamat,
                    'penyewa' => 'not'
                ]);
            }
        }
        $data['peta_reklame'] = $data_reklame;

        if (empty($data_reklame)) {
            return redirect('/harga')->with('error', 'Maaf pencarian tidak di temukan');
        }

        return view('user.harga', $data);
    }

    public function vendor()
    {
        $data['vendor'] = Vendor::all();
        return view('user.vendor', $data);
    }

    public function galeri()
    {
        $data['data_reklame'] = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        return view('user.galeri', $data);
    }

    public function pesanan(Request $request, $kd_reklame)
    {
        $user = $request->user();
        $email = $user->email;
        $penyewa = DB::table('penyewa')->where('email', $email)->first();

        
        $pesanan = DB::select("SELECT pesanan.*, max(tgl_pesan) as tgl_penurunan FROM pesanan WHERE kd_reklame = '$kd_reklame' AND status !='selesai' GROUP BY kd_reklame");

        $tgl_pesan = new DateTime($request->tgl_pesan);
        $tgl_sekarang =  new DateTime(date('Y-m-d'));
        $tgl_diff = date_diff($tgl_sekarang, $tgl_pesan);
        $tgl_selisih = $tgl_diff->format('%r%a');

        if ($tgl_selisih < 0) {
            return redirect('/harga')->with('error', 'maaf tanggal tidak boleh kurang dari tanggal sekarang');
        }

        if (!empty($pesanan)) {
            $lama_sewa = $pesanan[0]->lama_sewa * 30;
            $tgl_penurunan = date('Y-m-d', strtotime((date($pesanan[0]->tgl_penurunan)) . "+ $lama_sewa day"));
            $tgl1 = new DateTime($request->tgl_pesan);
            $tgl2 = new DateTime($tgl_penurunan);
            $diff = date_diff($tgl2, $tgl1);
            $selisih = $diff->format('%r%a');

            if ($selisih < 0) {
                return redirect('/harga')->with('error', 'Tgl pemasangan yang anda pilih lagi disewa');
            }
        }

        $tgl_pesan = $request->tgl_pesan;
        $kd_reklame = $request->kd_reklame;
        $kd_penyewa = $penyewa->kd_penyewa;
        $lama_sewa = $request->lama_sewa;

        $data_penyewa = [
            'tgl_pesan' => $tgl_pesan,
            'kd_reklame' => $kd_reklame,
            'kd_penyewa' => $kd_penyewa,
            'status' => 'belum upload bukti pembayaran',
            'lama_sewa' => $lama_sewa
        ];
        
        Pesanan::insert($data_penyewa);
        DB::table('data_reklame')->where('kd_reklame', $kd_reklame)->update(['status' => 1]);

        return redirect("/infopesanan");
    }
}
