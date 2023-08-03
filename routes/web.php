<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\BukuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

//Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/registrasi', [LoginController::class, 'registrasi']);
Route::post('/prosesRegistrasi', [LoginController::class, 'prosesregistrasi']);
Route::post('/prosesLogin', [LoginController::class, 'proseslogin']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    //Buku
    Route::name('buku.')
        ->prefix('buku')
        ->group(function () {
            Route::get('/', [BukuController::class, 'index'])->name('index');
            Route::get('/export', [BukuController::class, 'export'])->name('export');
            Route::post('/tambah', [BukuController::class, 'store'])->name('tambah');
            Route::put('/edit/{id}', [BukuController::class, 'update'])->name('edit');
            Route::put('/upload/{id}', [BukuController::class, 'upload'])->name('upload');
            Route::delete('/hapus/{id}', [BukuController::class, 'destroy'])->name('hapus');
        });

    //Kategori
    Route::name('kategori.')
        ->prefix('kategori')
        ->group(function () {
            Route::get('/', [KategoriBukuController::class, 'index'])->name('index');
            Route::post('/tambah', [KategoriBukuController::class, 'store'])->name('tambah');
            Route::put('/edit/{id}', [KategoriBukuController::class, 'update'])->name('edit');
            Route::delete('/hapus/{id}', [KategoriBukuController::class, 'destroy'])->name('hapus');
        });
});