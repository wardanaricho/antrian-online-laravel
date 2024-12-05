<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RegistrasiController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// ROUTE ANTRIAN DEPAN (PENGAMBILAN)
Route::get('/', [AntrianController::class, 'ambil_antrian_rm']); // page ambil antrian berdasarkan rm
Route::post('/cek-antrian-rm', [AntrianController::class, 'cek_antrian_rm']); // verifikasi no rkm medis di antrian

Route::get('/antrian-nik', [AntrianController::class, 'ambil_antrian_nik']); // page ambil antrian berdasarkan nik
Route::post('/cek-antrian-nik', [AntrianController::class, 'cek_antrian_nik']);  // verifikasi no rkm medis di antrian

// ROUTE DAFTAR PASIEN ONLINE
Route::get('/daftar-pasien-online', [PasienController::class, 'daftar_pasien_online']); // page daftar pasien online
Route::post('/simpan-pasien-online', [PasienController::class, 'simpan_pasien_online']); // simpan pasien online
Route::get('/result-pasien-online/{no_rkm_medis}', [PasienController::class, 'result_pasien_online']); // result pasien online
Route::get('/download-pasien-online/{no_rkm_medis}', [PasienController::class, 'download_pasien_online']); // download pdfhasil daftar online

// ROUTE ANTRIAN (RESULT ANTRIAN)
Route::post('/ambil-antrian-besok', [AntrianController::class, 'ambilAntrianBesok']);

Route::post('/ambil-antrian', [AntrianController::class, 'ambil_antrian']); // ambil antrian setelah verifikasi
Route::get('/result-antrian/{tgl}/{no_rkm_medis}/{no_antrian}', [AntrianController::class, 'result_antrian']); // result antrian qrCode
Route::get('/cetak-antrian/{tgl}/{no_rkm_medis}/{no_antrian}', [AntrianController::class, 'cetak_antrian']); // cetak antrian

// ROUTE AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout']);

// ROUTE DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('home')->middleware('auth');

// ROUTE PASIEN
Route::get('/pasien', [PasienController::class, 'index'])->middleware('auth');
Route::get('/pasien-create', [PasienController::class, 'create'])->middleware('auth');
Route::post('/simpan-pasien', [PasienController::class, 'simpan_pasien'])->middleware('auth');
Route::get('/pasien-edit/{no_rkm_medis}', [PasienController::class, 'edit'])->middleware('auth');
Route::put('/update-pasien/{no_rkm_medis}', [PasienController::class, 'update'])->middleware('auth');
Route::delete('/hapus-pasien/{no_rkm_medis}', [PasienController::class, 'destroy'])->middleware('auth');
Route::get('/register_pasien', [RegistrasiController::class, 'index'])->middleware('auth');
Route::get('/cari_register_pasien', [RegistrasiController::class, 'search'])->middleware('auth');

Route::get('/pasien/pdf', [PasienController::class, 'downloadPdf'])->name('pasien.pdf');
Route::get('/download-registrasi/{endDate}/{startDate}', [RegistrasiController::class, 'downloadPdf']);

// ROUTE ANTRIAN BELAKANG
Route::get('/antrian', [AntrianController::class, 'index'])->middleware('auth');
Route::post('/next_antrian', [AntrianController::class, 'next_antrian'])->middleware('auth');
Route::get('/antrian-display', [AntrianController::class, 'display'])->name('antrian.display');
Route::get('/antrian-data', [AntrianController::class, 'getAntrianData'])->name('antrian.data');
