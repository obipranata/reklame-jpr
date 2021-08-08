@extends('layouts.sidebar')

@section('content_dinas')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Izin Vendor</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Izin Reklame</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Perizinan Vendor
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Tgl Pemasangan</th>
                                    <th>Penyewa</th>
                                    <th>Ukuran</th>
                                    <th>Pajak(Rp)</th>
                                    <th>Alamat Pemasangan</th>
                                    <th>Lama Sewa</th>
                                    <th>Foto Bukti</th>
                                    <th>Status Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuan as $p)
                                @php
                                    $pajak = ($p->lama_sewa * $p->harga) * 0.25;
                                @endphp
                                    <tr>
                                        <td>{{$p->tgl_pesan}}</td>
                                        <td>{{$p->penyewa}}</td>
                                        <td>{{$p->ukuran}}</td>
                                        <td>{{number_format($pajak)}}</td>
                                        <td>{{$p->alamat}}</td>
                                        <td class="text-center">{{$p->lama_sewa}} hari</td>
                                        <td class="text-center">
                                            <a href="/foto_bukti/{{$p->foto_bukti}}">Lihat</a>
                                        </td>
                                        <td class="text-center">{{$p->status_pengajuan}}</td>
                                        @if ($p->status_pengajuan == 'diizinkan')
                                            <td class="text-center text-success">
                                                -
                                            </td>
                                        @elseif($p->status_pengajuan == 'tunggu verifikasi dari dinas')
                                            <td class="text-center text-success">
                                                <a href="#" class="tombol-izin btn btn-success btn-sm" role="button" data-bs-toggle="modal" data-bs-target="#izinModal" data-id="{{$p->kd_pengajuan}}">Perizinan</a>
                                            </td>
                                        @elseif($p->status_pengajuan == 'foto bukti belum di upload' || $p->status_pengajuan == 'bukti tidak valid')
                                            <td>
                                                -
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

    @include('layouts.footer')
    </div>

      <!-- Modal -->
    <div class="modal fade" id="izinModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Izin Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/dinas/izinvendor/" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <select class="form-select" aria-label="Default select example" name="status">
                            <option selected>Pilih</option>
                            <option value="diizinkan">Izinkan</option>
                            <option value="bukti tidak valid">Bukti tidak valid</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <script src="/js/jquery.3.2.1.min.js"></script>
<script>
  
  $(document).on('click','.tombol-izin',function(e) {
            console.log( "ready!" );
            let kd_pengajuan = $(this).data("id");
            console.log(kd_pengajuan);
            $("form").attr("action", `/dinas/izinvendor/${kd_pengajuan}`);
        });
 
</script>
@endsection