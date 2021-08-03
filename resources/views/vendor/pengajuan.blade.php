@extends('layouts.sidebar')

@section('content_vendor')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Pengajuan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengajuan</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Pengajuan. <span class="text-success">No Rekening Dinas : 1234567</span>
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
                                        <td class="text-center">{{$p->lama_sewa}} bulan</td>
                                        <td class="text-center">{{$p->status_pengajuan}}</td>
                                        @if ($p->status_pengajuan == 'diizinkan')
                                            <td class="text-center text-success">
                                                <a class="" href="/vendor/pengajuan/download/{{$p->kd_pengajuan}}" onclick="event.preventDefault(); document.getElementById('surat-izin').submit();">
                                                    Download Surat
                                                </a>
                                                <form id="surat-izin" action="/vendor/pengajuan/download/{{$p->kd_pengajuan}}" method="POST">
                                                    @csrf
                                                </form>
                                            </td>
                                        @elseif($p->status_pengajuan == 'tunggu verifikasi dari dinas')
                                            <td class="text-center text-success">
                                                -
                                            </td>
                                        @elseif($p->status_pengajuan == 'foto bukti belum di upload' || $p->status_pengajuan == 'bukti tidak valid')
                                            <td>
                                                <a href="#" class="tombol-upload btn btn-success btn-sm" role="button" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="{{$p->kd_pengajuan}}">Upload Bukti</a>
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
  <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/vendor/pengajuan/" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Foto Bukti</label>
                    <input class="form-control" type="file" id="formFile" name="foto_bukti">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script src="/assets/user/js/jquery.min.js"></script>
<script>
    $( document ).ready(function() {
    console.log( "ready!" );

        $(".tombol-upload").click(function(){
            let kd_pengajuan = $(this).data("id");
            console.log(kd_pengajuan);
            $("form").attr("action", `/vendor/pengajuan/${kd_pengajuan}`);
        });
    });
</script>
@endsection