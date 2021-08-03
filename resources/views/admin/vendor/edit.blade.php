@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Vendor</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Vendor</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="/vendor/{{$vendor->kd_vendor}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_pt" class="form-label">Nama PT</label>
                                <input type="text" class="form-control" id="nama_pt" name="nama_pt" value="{{$vendor->nama_pt}}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$vendor->email}}">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{$vendor->alamat}}">
                            </div>
                            <div class="mb-3">
                                <label for="no_tlp" class="form-label">No Telpon</label>
                                <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{$vendor->no_tlp}}">
                            </div>
                            <div class="mb-3">
                                <label for="no_rek" class="form-label">No Rekening</label>
                                <input type="text" class="form-control" id="no_rek" name="no_rek" value="{{$vendor->no_rek}}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

    @include('layouts.footer')
    </div>
@endsection