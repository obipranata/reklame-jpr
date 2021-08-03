<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Reklame Kota Jayapura</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link
      href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <link rel="stylesheet" href="/assets/user/css/animate.css" />

    <link rel="stylesheet" href="/assets/user/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/assets/user/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/assets/user/css/magnific-popup.css" />

    <link rel="stylesheet" href="/assets/user/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="/assets/user/css/jquery.timepicker.css" />

    <link rel="stylesheet" href="/assets/user/css/flaticon.css" />
    <link rel="stylesheet" href="/assets/user/css/style.css" />
    {{-- <link rel="stylesheet" href="/assets/sweetalert2/sweetalert2.all.min.css" /> --}}
  </head>
  <body>
    <nav
      class="
        navbar navbar-expand-lg navbar-dark
        ftco_navbar
        bg-dark
        ftco-navbar-light
      "
      id="ftco-navbar"
    >
      <div class="container">
        <a class="navbar-brand" href="/">Reklame kota Jayapura</a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#ftco-nav"
          aria-controls="ftco-nav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="fa fa-bars"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ Request::segment(1) == '/' ? 'active' : '' }}">
              <a href="/" class="nav-link">Home</a>
            </li>
            <!-- <li class="nav-item">
              <a href="vet.html" class="nav-link">Vendor</a>
            </li> -->
            <li class="nav-item {{ Request::segment(1) == 'datavendor' ? 'active' : '' }}">
              <a href="/datavendor" class="nav-link">Vendor</a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'galeri' ? 'active' : '' }}">
              <a href="/galeri" class="nav-link">Galeri</a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'harga' ? 'active' : '' }}">
              <a href="/harga" class="nav-link">Info Reklame</a>
            </li>
            
            @guest
              @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>

              @endif

              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li> 
              @endif

              @else

              @if (Auth::user()->level == 3)
                <li class="nav-item {{ Request::segment(1) == 'infopesanan' ? 'active' : '' }}">
                  <a href="/infopesanan" class="nav-link">Info Pesanan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li> 
              @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li> 
              @endif

            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->

    @yield('content_user')

    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p class="copyright">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
              made with
              <i class="fa fa-heart text-danger" aria-hidden="true"></i> by
              <a href="#" target="_blank">Fauzan M.</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
      <svg class="circular" width="48px" height="48px">
        <circle
          class="path-bg"
          cx="24"
          cy="24"
          r="22"
          fill="none"
          stroke-width="4"
          stroke="#eeeeee"
        />
        <circle
          class="path"
          cx="24"
          cy="24"
          r="22"
          fill="none"
          stroke-width="4"
          stroke-miterlimit="10"
          stroke="#F96D00"
        />
      </svg>
    </div>


    <script src="/assets/user/js/jquery.min.js"></script>
    <script src="/assets/user/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="/assets/user/js/popper.min.js"></script>
    <script src="/assets/user/js/bootstrap.min.js"></script>
    <script src="/assets/user/js/jquery.easing.1.3.js"></script>
    <script src="/assets/user/js/jquery.waypoints.min.js"></script>
    <script src="/assets/user/js/jquery.stellar.min.js"></script>
    <script src="/assets/user/js/jquery.animateNumber.min.js"></script>
    <script src="/assets/user/js/bootstrap-datepicker.js"></script>
    <script src="/assets/user/js/jquery.timepicker.min.js"></script>
    <script src="/assets/user/js/owl.carousel.min.js"></script>
    <script src="/assets/user/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/user/js/scrollax.min.js"></script>
    <script src="/assets/user/js/google-map.js"></script>
    <script src="/assets/user/js/main.js"></script>
    <script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>

  
    @if ($message = Session::get('success'))
    <div class="info">
        {{$message}}
    </div>
    <script>
        let message = '{{$message}}';
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text:  message
        })
    </script>
@endif

@if ($message = Session::get('error'))
    <div class="info-gagal">
        {{$message}}
    </div>
    <script>
        let message = '{{$message}}';
        Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text:  message
        })
    </script>
@endif
  </body>
</html>


