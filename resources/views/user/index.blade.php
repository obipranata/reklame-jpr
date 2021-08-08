@extends('layouts.templateuser')

@section('content_user')
<div
class="hero-wrap js-fullheight"
style="background-image: url('/assets/user/images/billboard.jpg')"
data-stellar-background-ratio="0.5"
>
<div class="overlay"></div>
<div class="container">
  <div
    class="
      row
      no-gutters
      slider-text
      js-fullheight
      align-items-center
      justify-content-center
    "
    data-scrollax-parent="true"
  >
    <div class="col-md-11 ftco-animate text-center">
      <h1 class="mb-4">Percayakan promosi anda pada kami</h1>
      <p>
        <a href="/harga" class="btn btn-primary mr-md-4 py-3 px-4"
          >Lihat Reklame <span class="ion-ios-arrow-forward"></span
        ></a>
      </p>
    </div>
  </div>
</div>
</div>

<section class="ftco-section bg-light ftco-no-pt ftco-intro">
<div class="container">
  <div class="row">
    <div class="col-md-6 d-flex align-self-stretch px-4 ftco-animate">
      <div class="d-block services text-center">
        <div class="media-body">
          <h3 class="heading">Visi</h3>
          <p>
            “Terwujudnya Pendapatan Daerah Yang Dinamis
              Dan Optimal Guna Menunjang Kemandirian
              Keuangan Daerah Kota Jayapura”
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-6 d-flex align-self-stretch px-4 ftco-animate">
      <div class="d-block services">
        <div class="media-body">
          <h3 class="heading text-center">Misi</h3>
          <ol>
            <li>
              Menggali dan mengembangkan sumber-sumber pendapatan lainnya melalui intensifikasi dan ekstensifikasi.
            </li>
            <li>
              Terciptanya sistem informasi Pengelolaan Pendapatan Daerah secara efektif, Transparan dan Akuntabel
            </li>
            <li>
              Meningkatkan kemampuan sumber daya manusia.
            </li>
            <li>
              Meningkatkan pelayanan yang cepat, tepat dan memuaskan
            </li>
            <li>
              Meningkatkan sosialisasi PAD terhadap masyarakat.
            </li>
            <li>
              Meningkatkan kemitraan dengan pihak ke tiga.
            </li>
            <li>
              Meningkatkan koordinasi dengan instansi teknis terkait.
            </li>
            <li>
              Meningkatkan pengawasan dan penertiban aparatur pengelola PAD
            </li>
            <li>
              Meningkatkan sarana dan prasarana yang memadai.
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="ftco-counter" id="section-counter">
<div class="container">
  <div class="row">
    <div
      class="
        col-md-6 col-lg-3
        d-flex
        justify-content-center
        counter-wrap
        ftco-animate
      "
    >
      <div class="block-18 text-center">
        <div class="text">
          <strong class="number" data-number="{{$vendor[0]->jml_vendor}}">0</strong>
        </div>
        <div class="text">
          <span>Vendor</span>
        </div>
      </div>
    </div>
    <div
      class="
        col-md-6 col-lg-3
        d-flex
        justify-content-center
        counter-wrap
        ftco-animate
      "
    >
      <div class="block-18 text-center">
        <div class="text">
          <strong class="number" data-number="{{$reklame[0]->jml_reklame}}">0</strong>
        </div>
        <div class="text">
          <span>Reklame</span>
        </div>
      </div>
    </div>
    <div
      class="
        col-md-6 col-lg-3
        d-flex
        justify-content-center
        counter-wrap
        ftco-animate
      "
    >
      <div class="block-18 text-center">
        <div class="text">
          <strong class="number" data-number="{{$belum_disewa[0]->jml_reklame}}">0</strong>
        </div>
        <div class="text">
          <span>Belum Disewa</span>
        </div>
      </div>
    </div>
    <div
      class="
        col-md-6 col-lg-3
        d-flex
        justify-content-center
        counter-wrap
        ftco-animate
      "
    >
      <div class="block-18 text-center">
        <div class="text">
          <strong class="number" data-number="{{$lagi_disewa[0]->jml_reklame}}">0</strong>
        </div>
        <div class="text">
          <span>Lagi Disewa</span>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="ftco-section bg-light">
<div class="container">
  <div class="row justify-content-center pb-5 mb-3">
    <div class="col-md-7 heading-section text-center ftco-animate">
      <h2>Harga</h2>
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
              @foreach ($pesanan as $p)
                @if ($p->kd_reklame == $r->kd_reklame)
                  @php
                    $lama_sewa = $p->lama_sewa * 30;
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

<section class="ftco-section">
<div class="container">
  <div class="row justify-content-center pb-5 mb-3">
    <div class="col-md-7 heading-section text-center ftco-animate">
      <h2>Gallery Reklame</h2>
    </div>
  </div>
  <div class="row">
    @foreach ($data_reklame as $r) 
      <div class="col-md-4 ftco-animate">
        <div
          class="work mb-4 img d-flex align-items-end"
          style="background-image: url(/foto_reklame/{{$r->foto}})"
        >
          <a
            href="/foto_reklame/{{$r->foto}}"
            class="
              icon
              image-popup
              d-flex
              justify-content-center
              align-items-center
            "
          >
            <span class="fa fa-expand"></span>
          </a>
          <div class="desc w-100 px-4">
            <div class="text w-100 mb-3">
              <span>{{$r->alamat}}</span>
              <h2><a href="">{{$r->nama_wilayah}}</a></h2>
            </div>
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
            <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan">
          </div>
          <div class="form-group">
            <label for="lama_sewa">Lama Sewa</label>
            <input type="text" class="form-control" id="lama_sewa" name="lama_sewa">
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

<script src="/js/jquery.3.2.1.min.js"></script>
<script>
  $(".tombol-pesan").click(function(){
    let kd_reklame = $(this).data("kd_reklame");
    $("form").attr("action","/pesanan/"+kd_reklame);
  });
</script>

@endsection