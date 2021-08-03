@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Data Reklame</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tambah Data Reklame</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="/datareklame" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="ukuran" class="form-label">Ukuran</label>
                                <input type="text" class="form-control" id="ukuran" name="ukuran">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">harga</label>
                                <input type="text" class="form-control" id="harga" name="harga">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Pemilik Reklame</label>
                                <select id="email" class="form-select" name="email">
                                    <option>--Pilih--</option>
                                    @foreach ($email as $e)
                                        <option value="{{$e->email}}">{{$e->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kd_jenis" class="form-label">Jenis Reklame</label>
                                <select id="kd_jenis" class="form-select" name="kd_jenis">
                                    <option>--Pilih--</option>
                                    @foreach ($jenis_reklame as $j)
                                        <option value="{{$j->kd_jenis}}">{{$j->nama_reklame}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kd_wilayah" class="form-label">Wilayah</label>
                                <select id="kd_wilayah" class="form-select" name="kd_wilayah">
                                    <option>--Pilih--</option>
                                    @foreach ($wilayah as $w)
                                        <option value="{{$w->kd_wilayah}}">{{$w->nama_wilayah}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Papan Reklame</label>
                                <input class="form-control" type="file" id="foto" name="foto">
                            </div>
                            <label>Peta</label>
                            <br />
                            <div id="googleMap" class="col-md-12 col-sm-12 col-xs-12" style="height: 400px;"></div>
                            <br />
                            <p id="latLngs"></p>
                            <div class="row row-sm mg-t-20">
                                <input type="hidden" id="lat" class="form-control col-xs-5 col-md-5" name="lat" value="">
                                <input type="hidden" id="lng" class="form-control col-xs-5 col-md-5" name="lng" value="">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

    @include('layouts.footer')
    </div>
    
    <script type="text/javascript">
        var cord = [];
    </script>
    
    @foreach ($data_reklame as $dr)
        <script type="text/javascript">
            cord.push([
                {{$dr->lat}}, {{$dr->lng}},"{{$dr->nama_wilayah}}","{{$dr->nama_reklame}}"
            ]);
        </script>
    @endforeach

    <script type="text/javascript">
        function myMap() {
            var mapProp = {
                center: new google.maps.LatLng(-2.53371, 140.71813),
                zoom: 13,
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
                    // icon: ""
                });

                google.maps.event.addListener(marker_tetap, 'click', (function(marker_tetap, count) {
                            var layanan;
                            var Fasilitas;
                            return function() {
                                infowindow.setContent("<h6 class='az-content-label mg-b-5'> Wilayah: " + locations[count][2] + 
                                    "</h6><hr><p> Jenis Reklame: " + locations[count][3] + "</p> <p class='az-content-label mg-b-5' font-size='9px'>Titik Kordinat</p><p>" + locations[count][0] + "," + locations[count][1] + "</p>"
                                );
                                infowindow.open(map, marker_tetap);
                            }
                        })(marker_tetap, count));
    
            }
            function taruhMarker(peta, posisiTitik) {
            // membuat Marker
                if (marker) {
                    // pindahkan marker
                    marker.setPosition(posisiTitik);
                } else {
                    // buat marker baru
                    marker = new google.maps.Marker({
                        position: posisiTitik,
                        map: peta,
                        draggable: false
                    });
                    console.log(marker);
                }
            }

            google.maps.event.addListener(map, 'click', function(event) {
                taruhMarker(this, event.latLng);
                $("#latLngs").text('Titik Kordinat : ' + event.latLng);
                $("#lat").val(event.latLng.lat());
                $("#lng").val(event.latLng.lng());
            });
        
        }
    </script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ExGkrwcp0PSoCWV-7kXLH7-Mow-6eAI&callback=myMap"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5JYTKYZkT937FPQ11gt0-zKRdtjtLH0M&callback=myMap"></script>
@endsection