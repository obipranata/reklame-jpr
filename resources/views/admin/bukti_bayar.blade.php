@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Verifikasi Bukti Pembayaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Verifikasi Bukti Pembayaran</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Bukti Pembayaran
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Tgl Pemasangan</th>
                                    <th>Penyewa</th>
                                    <th>Email</th>
                                    <th>Ukuran Reklame</th>
                                    <th>Harga(Rp)</th>
                                    <th>Alamat</th>
                                    <th>Lama Sewa</th>
                                    <th>Bukti Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukti_bayar as $p)
                                    <tr>
                                        <td>{{$p->tgl_pesan}}</td>
                                        <td>{{$p->name}}</td>
                                        <td>{{$p->penyewa}}</td>
                                        <td>{{$p->ukuran}}</td>
                                        <td>{{number_format($p->harga)}}</td>
                                        <td>{{$p->alamat}}</td>
                                        <td class="text-center">{{$p->lama_sewa}} hari</td>
                                        <td class="text-center">
                                            <a href="/foto_bukti/{{$p->foto_bukti}}" >lihat</a>
                                        </td>
                                        <td class="text-center">{{$p->status_pesan}}</td>
                                        @if ($p->status_pesan == 'verifikasi sukses')
                                            <td class="text-success text-center">
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'verifikasi gagal')
                                            <td class="text-center">
                                                <a href="" class="tombol-verifikasi btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasiModal" data-id="{{$p->kd_pesan}}">Verifikasi</a>
                                            </td>
                                        @elseif($p->status_pesan == 'reupload')
                                            <td class="text-center">
                                                <a href="" class="tombol-verifikasi btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasiModal" data-id="{{$p->kd_pesan}}">Verifikasi</a>
                                            </td>
                                        @elseif($p->status_pesan == 'selesai')
                                            <td class="text-center">
                                                -
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <a href="" class="tombol-verifikasi btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasiModal" data-id="{{$p->kd_pesan}}">Verifikasi</a>
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
  <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/admin/verifikasi/" method="POST">
            @csrf
            <div class="modal-body">
                <select class="form-select" aria-label="Default select example" name="status">
                    <option selected>Pilih</option>
                    <option value="verifikasi sukses">Bukti Valid</option>
                    <option value="verifikasi gagal">Bukti tidak valid</option>
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

  <script src="/assets/user/js/jquery.min.js"></script>
<script>
    $( document ).ready(function() {
    console.log( "ready!" );

        $(".tombol-verifikasi").click(function(){
            let kd_pesan = $(this).data("id");
            console.log(kd_pesan);
            $("form").attr("action", `/admin/verifikasi/${kd_pesan}`);
        });
    });
</script>
@endsection