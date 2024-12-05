@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-12 ">
            <div class="card bg-primary ">
                <div class="card-body px-4 py-4-5 text-center">
                    <h3 class="text-white">SELAMAT DATANG DI</h3>
                    <h1 class="text-white">RUMAH SUNAT AMANAH</h1>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card bg-warning">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <h6 class="font-bold text-center">TOTAL PASIEN</h6>
                            <h1 class="text-center font-extrabold mb-0">{{ $pasien }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <h6 class="font-bold text-center">ANTRIAN HARI INI</h6>
                            <h1 class="text-center font-extrabold mb-0">{{ $antrian_hari_ini }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card bg-danger">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <h6 class="font-bold text-center">ANTRIAN SELESAI</h6>

                            <h1 class="text-center font-extrabold mb-0">{{ $antrian_selesai }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card bg-info">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 ">
                            <h6 class="font-bold text-center">SISA ANTRIAN</h6>
                            <h1 class="text-center font-extrabold mb-0">{{ $sisa_antrian }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
