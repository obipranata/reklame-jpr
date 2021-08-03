@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Peta Penyebaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Peta Penyebaran</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="/petareklame/filter" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="">Pemilik</label>
                                    <select class="form-select form-control" name="email">
                                        <option value="all">Semua</option>
                                        <option value="{{Auth::user()->email}}">Reklame BAPENDA</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Jenis Reklame</label>
                                    <select class="form-select form-control" name="kd_jenis">
                                        <option value="all">Semua</option>
                                        @foreach ($jenis_reklame as $j)
                                            <option value="{{$j->kd_jenis}}">{{$j->nama_reklame}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <br>
                                    <button type="submit" class="btn btn-success form-control">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div id="googleMap" style="height: 800px; width: 100%"></div>
                    </div>
                </div>
            </div>
        </main>

    @include('layouts.footer')
    </div>

    <script src="/js/jquery.3.2.1.min.js"></script>
<script type="text/javascript">
    var cord = [];
</script>

@foreach ($data_reklame as $dr)
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