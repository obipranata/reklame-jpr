@extends('layouts.sidebar')

@section('content_admin')   
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Wilayah</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tambah Wilayah</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="/wilayah" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_wilayah" class="form-label">Nama Wilayah</label>
                                <input type="text" class="form-control" id="nama_wilayah" name="nama_wilayah">
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