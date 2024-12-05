@extends('layouts.layout')
@section('title', 'Daftar Pasien')
@section('content')
    <div class="row h-100">
        <div class="col-12 col-lg-3 d-none d-lg-block">
        </div>
        <div class="col-12 col-lg-6">
            <div class="m-2">
                <div class="row align-items-center">
                    <div class="col-6 text-center">
                        <a href="/login">
                            <img src="{{ asset('logo.png') }}" width="150px" alt="Logo" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 text-left">
                        <h4 class="fw-bold text-primary mb-1">RUMAH SUNAT AMANAH</h4>
                        <p class="mb-0 text-muted">Pendaftaran Pasien Online</p>
                    </div>
                </div>

                <form action="/simpan-pasien" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nik" class="form-label text-dark">Nomor Induk Kependudukan</label>
                            <div class="form-group position-relative mb-2">
                                <input type="text" class="form-control" name="nik" id="nik" maxlength="16"
                                    placeholder="Nomor Induk Kependudukan" required autofocus>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="nama_pasien" class="form-label text-dark">Nama Pasien</label>
                            <div class="form-group position-relative mb-2">
                                <input type="text" class="form-control" name="nama_pasien" id="nama_pasien"
                                    placeholder="Nama Pasien" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="email" class="form-label text-dark">Email Pasien</label>
                            <div class="form-group position-relative mb-2">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="jenis_kelamin" class="form-label text-dark">Jenis Kelamin</label>
                            <div class="form-group position-relative mb-2">
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                    <option value="L">L</option>
                                    <option value="P">P</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="tempat_lahir" class="form-label text-dark">Tempat Lahir</label>
                            <div class="form-group position-relative mb-2">
                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="tanggal_lahir" class="form-label text-dark">Tanggal Lahir</label>
                            <div class="form-group position-relative mb-2">
                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="agama" class="form-label text-dark">Agama</label>
                            <div class="form-group position-relative mb-2">
                                <select name="agama" id="agama" class="form-select" required>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Khatolik">Khatolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="pekerjaan" class="form-label text-dark">Pekerjaan</label>
                            <div class="form-group position-relative mb-2">
                                <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="nomor_tlp" class="form-label text-dark">Nomor Telepon</label>
                            <div class="form-group position-relative mb-2">
                                <input type="text" class="form-control" name="nomor_tlp" id="nomor_tlp" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="status" class="form-label text-dark">Status</label>
                            <div class="form-group position-relative mb-2">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Lajang">Lajang</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="alamat" class="form-label text-dark">Alamat</label>
                            <textarea class="form-control mb-2" name="alamat" id="alamat" id="" cols="30" rows="5"
                                required></textarea>
                        </div>

                    </div>



                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg">Simpan</button>
                </form>

            </div>
        </div>
        <div class="col-12 col-lg-3 d-none d-lg-block">
        </div>
    </div>
@endsection
