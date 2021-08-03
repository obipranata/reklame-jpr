@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Jenis Reklame</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Jenis Reklame</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="/jenisreklame/create" class="btn btn-success btn-sm">
                            + Tambah Jenis Reklame
                        </a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Jenis Reklame
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Nama Reklame</th>
                                    <th class="text-center" colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis_reklame as $j)
                                    <tr>
                                        <td>{{$j->nama_reklame}}</td>
                                        <td class="text-center">
                                            <a href="/jenisreklame/{{$j->kd_jenis}}/edit" class="btn btn-warning btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                                <a href="#" data-id="{{$j->kd_jenis}}" data-nama="{{$j->nama_reklame}}" class="btn btn-sm btn-danger hapus text-white">
                                                    <form action="/jenisreklame/{{$j->kd_jenis}}" id="delete{{$j->kd_jenis}}" method="post">
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