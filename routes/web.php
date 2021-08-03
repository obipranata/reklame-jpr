<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['user'])->group(function () {
    Route::get('/', 'UserController@index');
    Route::get('/harga', 'UserController@harga');
    Route::post('/harga/cari', 'UserController@cari');
    Route::get('/datavendor', 'UserController@vendor');
    Route::get('/galeri', 'UserController@galeri');
});

Route::middleware(['pesan'])->group(function () {
    Route::post('/pesanan/{kd_reklame}', 'UserController@pesanan');
    Route::get('/infopesanan', 'InfoPesananController@index');
    Route::post('/buktipembayaran/{kd_pesan}', 'InfoPesananController@bayar');
    Route::post('/updatebuktipembayaran/{kd_pesan}', 'InfoPesananController@updatebukti');
    Route::post('/user/downloadsurat/{kd_pesan}', 'InfoPesananController@downloadsurat');
});

Route::middleware(['vendor'])->group(function () {
    Route::get('/vendor/pesanan', 'vendor\PesananController@index');
    Route::delete('/vendor/pesanan/{kd_pesan}', 'vendor\PesananController@hapus');
    Route::get('/vendor/buktibayar', 'vendor\PesananController@verifikasi');
    Route::get('/vendor/pengajuan', 'vendor\PengajuanController@index');
    Route::get('/vendor/petareklame', 'vendor\DataReklameController@index');
    Route::post('/vendor/petareklame/filter', 'vendor\DataReklameController@filter');
    Route::post('/vendor/verifikasi/{kd_pesan}', 'vendor\PesananController@updatebayar');
    Route::post('/vendor/konfirmasi/{kd_pesan}', 'vendor\PesananController@updatepesan');
    Route::put('/vendor/pengajuan/{kd_pengajuan}', 'vendor\PengajuanController@uploadbukti');
    Route::post('/vendor/pengajuan/download/{kd_pengajuan}', 'vendor\PengajuanController@download');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/pesanan', 'admin\PesananController@index');
    Route::delete('/admin/pesanan/{kd_pesan}', 'admin\PesananController@hapus');
    Route::get('/admin/buktibayar', 'admin\PesananController@verifikasi');
    Route::post('/admin/verifikasi/{kd_pesan}', 'admin\PesananController@updatebayar');
    Route::post('/admin/konfirmasi/{kd_pesan}', 'admin\PesananController@updatepesan');
    Route::post('/petareklame/filter', 'admin\PetaController@filter');

    Route::resource('vendor', 'admin\VendorController');
    Route::resource('jenisreklame', 'admin\JenisReklameController');
    Route::resource('wilayah', 'admin\WilayahController');
    Route::resource('datareklame', 'admin\DataReklameController');
    Route::resource('petareklame', 'admin\PetaController');
});

Route::middleware(['dinas'])->group(function () {
    Route::get('/dinas/izinvendor', 'dinas\IzinVendorController@index');
    Route::put('/dinas/izinvendor/{kd_pengajuan}', 'dinas\IzinVendorController@perizinan');
});
