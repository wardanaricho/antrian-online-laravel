@extends('layouts.layout')
@section('title', 'Registrasi')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Registrasi Pasien Hari ini</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="/register_pasien" method="GET">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" name="search" placeholder="Cari"
                                        aria-label="Cari" aria-describedby="button-addon2" autocomplete="off" autofocus>
                                    <button class="input-group-text btn btn-primary" type="submit" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                <br>
                                <a href="/download-registrasi/{{ $startDate }}/{{ $endDate }}"
                                    class="btn btn-primary mb-1">Download PDF</a>
                            </div>

                            <div class="col-lg-6">
                                <div class="float-end">
                                    <div class="dropdown me-1">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            id="dropdown-align-alt-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fa fa-filter"></i>
                                            <span class="ms-1 d-none d-sm-inline">Filter</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end fs-sm"
                                            aria-labelledby="dropdown-align-alt-primary">
                                            <div class="px-3 py-2">
                                                <label for="startDate">Tanggal Awal</label>
                                                <input type="date" class="form-control js-flatpickr" id="startDate"
                                                    name="start_date" placeholder="Tanggal Awal"
                                                    value="{{ request('start_date') }}">
                                                <div class="dropdown-divider"></div>
                                                <label for="endDate">Tanggal Akhir</label>
                                                <input type="date" class="form-control js-flatpickr" id="endDate"
                                                    name="end_date" placeholder="Tanggal Akhir"
                                                    value="{{ request('end_date') }}">
                                                <div class="mt-2 text-end">
                                                    <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                                                    <a href="/register_pasien" class="btn btn-secondary btn-sm">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered border-dark mb-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">No. Antrian</th>
                                    <th class="text-white">Estimasi</th>
                                    <th class="text-white">No. Rkm Medis</th>
                                    <th class="text-white">Tgl. Registrasi</th>
                                    <th class="text-white">Nama Pasien</th>
                                    <th class="text-white">Jenis Kelamin</th>
                                    <th class="text-white">Dokter</th>
                                    {{-- <th class="text-white">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($register as $item)
                                    <tr>
                                        <td>{{ $item->no_antrian }}</td>
                                        <td>
                                            @php
                                                $antrian = DB::table('antrian')
                                                    ->where('tanggal', \Carbon\Carbon::now()->toDateString())
                                                    ->where('no_antrian', $item->no_antrian)
                                                    ->first();
                                            @endphp
                                            {{ $antrian->estimasi ?? '-' }}
                                        </td>
                                        <td>{{ $item->no_rkm_medis }}</td>
                                        <td>{{ $item->tanggal_regis . ' - ' . $item->jam_regis }}</td>
                                        <td>{{ $item->pasien->nama_pasien }}</td>
                                        <td>{{ $item->pasien->jenis_kelamin }}</td>
                                        <td>{{ $item->dokter->nama_dokter }}</td>
                                        {{-- <td>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $register->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
