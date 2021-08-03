@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Reklame</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Reklame</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="/datareklame/create" class="btn btn-success btn-sm">
                            + Tambah Data Reklame
                        </a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Reklame
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ukuran</th>
                                    <th>Harga</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>email</th>
                                    <th>Jenis</th>
                                    <th>Wilayah</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th class="text-center" colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_reklame as $d)
                                    <tr>
                                        <td>
                                            <img src="/foto_reklame/{{$d->foto}}" width="100" alt="">
                                        </td>
                                        <td>{{$d->ukuran}}</td>
                                        <td>{{$d->harga}}</td>
                                        <td>{{$d->alamat}}</td>
                                        <td class="text-center">{{$d->status}}</td>
                                        <td>{{$d->email}}</td>
                                        <td>{{$d->nama_reklame}}</td>
                                        <td>{{$d->nama_wilayah}}</td>
                                        <td>{{$d->lat}}</td>
                                        <td>{{$d->lng}}</td>
                                        <td class="text-center">
                                            <a href="/datareklame/{{$d->kd_reklame}}/edit" class="btn btn-warning btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                                <a href="#" data-id="{{$d->kd_reklame}}" data-nama="{{$d->ukuran}}" class="btn btn-sm btn-danger hapus text-white">
                                                    <form action="/datareklame/{{$d->kd_reklame}}" id="delete{{$d->kd_reklame}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                        </td>
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
@endsection