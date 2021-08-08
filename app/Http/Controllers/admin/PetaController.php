<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jenis_reklame;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    public function index()
    {
        $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah");
        $cek_pesanan = DB::select("SELECT data_reklame.*, max(tgl_pesan), jenis_reklame.nama_reklame, wilayah.nama_wilayah, pesanan.tgl_pesan, pesanan.lama_sewa, penyewa.email as penyewa, users.name FROM data_reklame, jenis_reklame, wilayah, pesanan, penyewa, users WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND pesanan.kd_reklame = data_reklame.kd_reklame AND data_reklame.status = 1 AND penyewa.kd_penyewa = pesanan.kd_penyewa AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci GROUP BY pesanan.kd_reklame ");

        

        $data_reklame = [];
        foreach ($reklame as $dr) {
            foreach ($cek_pesanan as $c) {
                if ($dr->kd_reklame == $c->kd_reklame) {
                    // $lama_sewa = $c->lama_sewa * 30;
                    $lama_sewa = $c->lama_sewa;
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
        // dd($data_reklame);
        $data['data_vendor'] = Vendor::all();
        $data['user'] = User::all();
        $data['data_reklame'] = $data_reklame;
        $data['jenis_reklame'] = Jenis_reklame::all();
        // dd($data_reklame);


        return view('admin.peta', $data);
    }

    public function filter(Request $request)
    {
        $kd_jenis = $request->kd_jenis;
        $email = $request->email;
        
        if ($email == 'all' and $kd_jenis == 'all') {
            $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah  ");
        } elseif ($email != 'all' and $kd_jenis == 'all') {
            $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND data_reklame.email = '$email' ");
        } elseif ($email == 'all' and $kd_jenis != 'all') {
            $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND jenis_reklame.kd_jenis = '$kd_jenis' ");
        } elseif ($email != 'all' and $kd_jenis != 'all') {
            $reklame = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah FROM data_reklame, jenis_reklame, wilayah WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND jenis_reklame.kd_jenis = '$kd_jenis' AND data_reklame.email = '$email'");
        }

        $cek_pesanan = DB::select("SELECT data_reklame.*, jenis_reklame.nama_reklame, wilayah.nama_wilayah, pesanan.tgl_pesan, pesanan.lama_sewa, penyewa.email as penyewa, users.name, max(tgl_pesan) FROM data_reklame, jenis_reklame, wilayah, pesanan, penyewa, users WHERE data_reklame.kd_jenis = jenis_reklame.kd_jenis AND wilayah.kd_wilayah = data_reklame.kd_wilayah AND pesanan.kd_reklame = data_reklame.kd_reklame AND data_reklame.status = 1 AND penyewa.kd_penyewa = pesanan.kd_penyewa AND users.email = penyewa.email COLLATE utf8mb4_unicode_ci GROUP BY pesanan.kd_reklame");

        $data_reklame = [];
        foreach ($reklame as $dr) {
            foreach ($cek_pesanan as $c) {
                if ($dr->kd_reklame == $c->kd_reklame) {
                    // $lama_sewa = $c->lama_sewa * 30;
                    $lama_sewa = $c->lama_sewa;
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

        $data['data_vendor'] = Vendor::all();
        $data['user'] = User::all();
        $data['data_reklame'] = $data_reklame;
        $data['jenis_reklame'] = Jenis_reklame::all();
        // dd($data_reklame);


        return view('admin.peta', $data);
    }
}
