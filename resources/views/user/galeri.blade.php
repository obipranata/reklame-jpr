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
        <span>Gallery <i class="ion-ios-arrow-forward"></i></span>
      </p>
      <h1 class="mb-0 bread">Gallery</h1>
    </div>
  </div>
</div>
</section>

<section class="ftco-section">
<div class="container">
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
@endsection