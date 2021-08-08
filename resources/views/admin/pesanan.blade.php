@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Pesanan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pesanan</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Pesanan
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Tgl Pemasangan</th>
                                    <th>Penyewa</th>
                                    <th>email</th>
                                    <th>Ukuran Reklame</th>
                                    <th>Harga(Rp)</th>
                                    <th>Alamat</th>
                                    <th>Lama Sewa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $p)
                                    <tr>
                                        <td>{{$p->tgl_pesan}}</td>
                                        <td>{{$p->name}}</td>
                                        <td>{{$p->penyewa}}</td>
                                        <td>{{$p->ukuran}}</td>
                                        <td>{{number_format($p->harga)}}</td>
                                        <td>{{$p->alamat}}</td>
                                        <td class="text-center">{{$p->lama_sewa}} hari</td>
                                        <td class="text-center">{{$p->status_pesan}}</td>
                                        @if ($p->status_pesan == 'belum upload bukti pembayaran')
                                            <td class="text-center text-success">
                                                <a href="#" data-id="{{$p->kd_pesan}}" data-nama="{{$p->kd_pesan}}" class="btn btn-sm btn-danger hapus">
                                                    <form action="/admin/pesanan/{{$p->kd_pesan}}" id="delete{{$p->kd_pesan}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    Hapus
                                                </a>
                                            </td>
                                        @elseif($p->status_pesan == 'dibatalkan')
                                            <td class="text-center text-success">
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'verifikasi sukses')
                                            <td>
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'verifikasi gagal')
                                            <td>
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'reupload')
                                            <td>
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'selesai')
                                            <td>
                                                -
                                            </td>
                                        @elseif($p->status_pesan == 'tunggu verifikasi')
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
  <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesanan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/admin/konfirmasi/" method="POST">
            @csrf
            <div class="modal-body">
                <select class="form-select" aria-label="Default select example" name="status">
                    <option selected>Pilih</option>
                    <option value="dikonfirmasi">Konfrimasi</option>
                    <option value="dibatalkan">Batalkan</option>
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

        $(".tombol-konfirmasi").click(function(){
            let kd_pesan = $(this).data("id");
            console.log(kd_pesan);
            $("form").attr("action", `/admin/konfirmasi/${kd_pesan}`);
        });
    });
</script>
@endsection