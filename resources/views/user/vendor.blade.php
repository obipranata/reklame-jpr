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
        <span>Vendor <i class="ion-ios-arrow-forward"></i></span>
      </p>
      <h1 class="mb-0 bread">Vendor Kami</h1>
    </div>
  </div>
</div>
</section>

<section class="ftco-section bg-light">
<div class="container">
  <div class="row">
    @foreach ($vendor as $v)
        <div class="col-md-6 col-lg-3 ftco-animate">
        <div class="staff">
            <div class="text pt-3 px-3 pb-4 text-center">
            <h3>{{$v->nama_pt}}</h3>
            <span class="position mb-2">{{$v->email}}</span>
            <div class="faded">
                <p>
                    Alamat : {{$v->alamat}}
                </p>
                <p>
                    Telpon : {{$v->no_tlp}}
                </p>
                <ul class="ftco-social text-center">
                <li class="ftco-animate">
                    <a
                    href="#"
                    class="d-flex align-items-center justify-content-center"
                    ><span class="fa fa-twitter"></span
                    ></a>
                </li>
                <li class="ftco-animate">
                    <a
                    href="#"
                    class="d-flex align-items-center justify-content-center"
                    ><span class="fa fa-facebook"></span
                    ></a>
                </li>

                <li class="ftco-animate">
                    <a
                    href="#"
                    class="d-flex align-items-center justify-content-center"
                    ><span class="fa fa-instagram"></span
                    ></a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    @endforeach
  </div>
</div>
</section>
@endsection