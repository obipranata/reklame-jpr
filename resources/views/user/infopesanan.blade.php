@extends('layouts.templateuser')
@section('content_user')
<section
class="hero-wrap hero-wrap-2"
style="background-image: url('/assets/user/images/billboard1.jpg')"
data-stellar-background-ratio="0.5"
>
<div class="overlay"></div>
<div class="container">
  <div class="row no-gutters slider-text align-items-end">
    <div class="col-md-9 ftco-animate pb-5">
      <p class="breadcrumbs mb-2">
        <span class="mr-2"
          ><a href="index.html"
            >Home <i class="ion-ios-arrow-forward"></i></a
        ></span>
        <span>Info Pesanan <i class="ion-ios-arrow-forward"></i></span>
      </p>
      <h1 class="mb-0 bread">Info Pesanan</h1>
    </div>
  </div>
</div>
</section>

<section class="ftco-section bg-light">
<div class="container">
  <div class="row">
    <div class="col-lg-12 ftco-animate">
      <div class="block-7">
        <div class=" p-4">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Tgl Pemasangan</th>
                  <th scope="col">Ukuran</th>
                  <th scope="col">Pemilik Reklame</th>
                  <th scope="col">Email</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Lama Sewa</th>
                  <th scope="col">No Rek</th>
                  <th scope="col">Status</th>
                  <th scope="col">Info Vendor</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                   
                      @php
                          $pesan = '';
                      @endphp
                   
                    @foreach ($pesanan as $p)
                    @foreach ($vendor as $v)
                      @if ($p->level == 2)
                        @if ($v->email == $p->email)
                          @php
                              $no_rek = $v->no_rek;
                          @endphp
                        @endif
                      @else
                        @php
                            $no_rek = '1234567';
                        @endphp
                      @endif
                    @endforeach
  
                    @foreach ($pengajuan as $pj)
                        @if ($p->level == 2)
                            @if ($p->kd_pesan == $pj->kd_pesan)
                              @if ($pj->status_pengajuan == 'diizinkan')
                                @php
                                    $pesan = 'sudah diizinkan dinas';
                                @endphp
                              @else
                                @php
                                    $pesan = 'belum diizinkan dinas';
                                @endphp
                              @endif
                            @endif
                        @else
                            @php
                                $pesan = '-';
                            @endphp
                        @endif
                      @endforeach
                      <tr>
                        <td>{{$p->tgl_pesan}}</td>
                        <td>{{$p->ukuran}}</td>
                        <td>{{$p->name}}</td>
                        <td>{{$p->email}}</td>
                        <td>{{number_format($p->harga * $p->lama_sewa)}}</td>
                        <td class="text-center">{{$p->lama_sewa}} Bulan</td>
                        <td>{{$no_rek}}</td>
                        <td>
                          {{$p->status_pesanan}}
                        </td>
                        <td>
                          {{$pesan}}
                        </td>
                        <td class="text-center">
                          @if ($p->status_pesanan == 'belum upload bukti pembayaran')
                            <a href="" class="tombol-bayar" data-toggle="modal" data-target="#bayar" data-id="{{$p->kd_pesan}}">Upload Bukti</a>
                            <small>(jpg, png, jpeg max 1 mb)</small>
                          @elseif($p->status_pesanan == 'verifikasi gagal')
                            <a href="" class="tombol-update" data-toggle="modal" data-target="#bayar" data-id="{{$p->kd_pesan}}">Upload Ulang</a>
                          @elseif($p->status_pesanan == 'tunggu verifikasi')
                            -
                          @elseif($p->status_pesanan == 'verifikasi sukses')
                            @if ($p->level == 1)
                              <a class="" href="/user/downloadsurat/{{$p->kd_pesan}}" onclick="event.preventDefault(); document.getElementById('surat-izin').submit();">
                                Download Surat
                              </a>
                              <form id="surat-izin" action="/user/downloadsurat/{{$p->kd_pesan}}" method="POST">
                                  @csrf
                              </form>
                            @elseif($p->level == 2)
                              -
                            @endif
                          @else
                              {{$p->status_pesanan}}
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
  </div>
</div>
</section>

  <!-- Modal -->
  <div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Upload bukti pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/buktipembayaran/" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="foto_bukti" lang="es" name="foto_bukti">
                <label class="custom-file-label" for="foto_bukti">pilih foto</label>
              </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script src="/assets/user/js/jquery.min.js"></script>
<script>
  $(".tombol-bayar").click(function(){
    let kd_pesan = $(this).data("id");
    console.log(kd_pesan);
    $("form").attr("action", `/buktipembayaran/${kd_pesan}`);
  });
  $(".tombol-update").click(function(){
    let kd_pesan = $(this).data("id");
    console.log(kd_pesan);
    $("form").attr("action", `/updatebuktipembayaran/${kd_pesan}`);
  });
</script>
@endsection