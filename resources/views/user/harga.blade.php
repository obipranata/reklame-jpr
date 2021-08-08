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
        <span>Harga <i class="ion-ios-arrow-forward"></i></span>
      </p>
      <h1 class="mb-0 bread">Harga</h1>
    </div>
  </div>
</div>
</section>

<section class="ftco-section bg-light">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-7 heading-section text-center ftco-animate">
      <h2>Reklame Jayapura</h2>
    </div>
  </div>
  <div class="row justify-content-center pb-5 mb-3">
    <div class="col-md-6"> 
    <form action="/harga/cari" method="POST">
      @csrf
        <div class="form-group">
          <input type="cari" class="form-control" name="cari" id="cari" placeholder="cari.." name="cari">
        </div>
      </form>
    </div>
  </div>
  
  <div class="row">
    @foreach ($data_reklame as $r)
      @if ($r->status == 0)
        @php
          $class = "fa fa-check mr-2";
          $status = 'Belum disewa';
        @endphp
      @else
        @php
          $class = "fa fa-spinner mr-2 text-danger";
          $status = 'Lagi disewa';
        @endphp
      @endif
      <div class="col-md-4 ftco-animate">
        <div class="block-7">
          <div
            class="img"
            style="background-image: url(/foto_reklame/{{$r->foto}})"
          ></div>
          <div class="text-center p-4">
            @foreach ($user as $u)
              @if ($u->email == $r->email)
                @if ($u->level == 1)
                  <span class="excerpt d-block">{{$u->name}}</span>
                @endif
              @endif
            @endforeach
            @foreach ($data_vendor as $v)
              @if ($v->email == $r->email)
                <span class="excerpt d-block">{{$v->nama_pt}}</span>
              @endif
            @endforeach
            <span class="excerpt d-block">{{$r->nama_wilayah}}</span>
            <span class="price">Rp <span class="number1">{{number_format($r->harga)}}</span>
              <sub>/hari</sub></span>
            <ul class="pricing-text mb-5">
              <li><span class="{{$class}}"></span>{{$status}}</li>
              <li><span class="fa fa-map-marker mr-2 text-success"></span>{{$r->alamat}}</li>
              <li><span class="fa fa-window-maximize"></span> {{$r->ukuran}}</li>
              <li><span class="fa fa-window-maximize"></span> {{$r->nama_reklame}}</li>
              @foreach ($pesanan as $p)
                @if ($p->kd_reklame == $r->kd_reklame)
                  @php
                    // $lama_sewa = $p->lama_sewa * 30;
                    $lama_sewa = $p->lama_sewa;
                    $tgl_penurunan = date('Y-m-d', strtotime((date($p->tgl_penurunan)) . "+ $lama_sewa day"));
                    $tgl1 = new DateTime(date('Y-m-d'));
                    $tgl2 = new DateTime($tgl_penurunan);
                    $diff = date_diff($tgl2, $tgl1);
                    $selisih = $diff->format('%r%a');

                    $tgl_turun = explode('-',$tgl_penurunan);
                    $tgl_sewa = explode('-',$p->tgl_penurunan);
                  @endphp
                  {{-- <li><span class="fa fa-calendar mr-2"></span>{{$p->tgl_penurunan}}</li> --}}
                  {{-- <li><span class="fa fa-calendar mr-2 text-danger"></span>Tgl penurunan {{$tgl_penurunan}}</li> --}}
                  <li><span class="fa fa-calendar mr-2"></span>Tgl Sewa {{$tgl_sewa[2]}}-{{$tgl_sewa[1]}}-{{$tgl_sewa[0]}}</li>
                  <li><span class="fa fa-calendar mr-2 text-danger"></span>Tgl penurunan {{$tgl_turun[2]}}-{{$tgl_turun[1]}}-{{$tgl_turun[0]}}</li>
                @endif
              @endforeach
            </ul>

            <a href="#" class="btn btn-primary d-block px-2 py-3 tombol-pesan" data-kd_reklame = "{{$r->kd_reklame}}" data-toggle="modal" data-target="#pesanModal">Pesan</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
</section>

<!-- Modal -->
<div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pesanModalLabel">Pilih Tanggal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/pesanan/" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="tgl_pesan">Tgl Pesan</label>
            <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" required>
          </div>
          <div class="form-group">
            <label for="lama_sewa">Lama Sewa (<small>per Hari</small>)</label>
            <input type="text" class="form-control" id="lama_sewa" name="lama_sewa" placeholder="/hari" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="googleMap" style="height: 800px; width: 100%"></div>

<script src="/js/jquery.3.2.1.min.js"></script>
<script type="text/javascript">
    var cord = [];
</script>

<script>
  $(".tombol-pesan").click(function(){
    let kd_reklame = $(this).data("kd_reklame");
    $("form").attr("action","/pesanan/"+kd_reklame);
  });
</script>

@foreach ($peta_reklame as $dr)
    @foreach ($user as $u)
        @if ($u->email == $dr['email'])
            @if ($u->level == 1)
                @php
                    $nama = $u->name;
                @endphp
            @endif
        @endif
    @endforeach
    @foreach ($data_vendor as $v)
        @if ($v->email == $dr['email'])
        @php
            $nama = $v->nama_pt
        @endphp
        @endif
    @endforeach
    @if ($dr['penyewa'] == 'not')
        @php
            $penyewa = '';
        @endphp
    @else
        @php
            $penyewa = "Penyewa : " . $dr['penyewa'];
        @endphp
    @endif
    <script type="text/javascript">
        cord.push([
            {{$dr['lat']}}, {{$dr['lng']}},"{{$dr['nama_wilayah']}}","{{$dr['nama_reklame']}}", "{{$nama}}", "{{$dr['alamat']}}", "{{$dr['marker']}}", "{{$penyewa}}"
        ]);
    </script>
@endforeach


<script type="text/javascript">
    function myMap() {
        var mapProp = {
            center: new google.maps.LatLng(-2.53371, 140.71813),
            zoom: 15,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        var marker;

        var locations = cord;
        var infowindow = new google.maps.InfoWindow({});

        var marker_tetap, count;

        for (count = 0; count < locations.length; count++) {
            marker_tetap = new google.maps.Marker({
                position: new google.maps.LatLng(locations[count][0], locations[count][1]),
                map: map,
                icon: "/assets/img/"+locations[count][6]+".png"
            });

            google.maps.event.addListener(marker_tetap, 'click', (function(marker_tetap, count) {
                        var layanan;
                        var Fasilitas;
                        return function() {
                            infowindow.setContent(
                                `
                                <h6 class='az-content-label mg-b-5'> Wilayah: ${locations[count][2]} </h6>
                                <hr><h5> Pemilik Reklame: ${locations[count][4]} </h5> 
                                ${locations[count][7]}
                                <hr><p> Jenis Reklame: ${locations[count][3]} </p> 
                                <hr><p> Alamat: ${locations[count][5]} </p> 
                                    
                                    <p class='az-content-label mg-b-5' font-size='9px'>Titik Kordinat</p>
                                    <p>${locations[count][0]}, ${locations[count][1]}</p>
                                `
                            );
                            infowindow.open(map, marker_tetap);
                        }
                    })(marker_tetap, count));

        }

    
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5JYTKYZkT937FPQ11gt0-zKRdtjtLH0M&callback=myMap"></script>
@endsection