@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Wilayah</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Wilayah</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="/wilayah/create" class="btn btn-success btn-sm">
                            + Tambah Wilayah
                        </a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Wilayah
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Nama Wilayah</th>
                                    <th class="text-center" colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wilayah as $w)
                                    <tr>
                                        <td>{{$w->nama_wilayah}}</td>
                                        <td class="text-center">
                                            <a href="/wilayah/{{$w->kd_wilayah}}/edit" class="btn btn-warning btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                                <a href="#" data-id="{{$w->kd_wilayah}}" data-nama="{{$w->nama_wilayah}}" class="btn btn-sm btn-danger hapus text-white">
                                                    <form action="/wilayah/{{$w->kd_wilayah}}" id="delete{{$w->kd_wilayah}}" method="post">
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