@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Vendor</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Vendor</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="/vendor/create" class="btn btn-success btn-sm">
                            + Tambah Vendor
                        </a>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Vendor
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Nama PT</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>No Tlp</th>
                                    <th>No Rekening</th>
                                    <th class="text-center" colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vendor as $v)
                                    <tr>
                                        <td>{{$v->nama_pt}}</td>
                                        <td>{{$v->email}}</td>
                                        <td>{{$v->alamat}}</td>
                                        <td>{{$v->no_tlp}}</td>
                                        <td>{{$v->no_rek}}</td>
                                        <td class="text-center">
                                            <a href="/vendor/{{$v->kd_vendor}}/edit" class="btn btn-warning btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                                <a href="#" data-id="{{$v->kd_vendor}}" data-nama="{{$v->nama_pt}}" class="btn btn-sm btn-danger hapus text-white">
                                                    <form action="/vendor/{{$v->kd_vendor}}" id="delete{{$v->kd_vendor}}" method="post">
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