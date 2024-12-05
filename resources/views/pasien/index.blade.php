@extends('layouts.layout')
@section('title', 'Pasien')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Pasien</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="/pasien" method="GET">
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
                                <a href="/pasien-create" class="btn btn-warning mb-1">Tambah Pasien</a>
                                <a href="{{ route('pasien.pdf') }}" class="btn btn-primary mb-1">Download PDF</a>

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
                                                    <a href="/pasien" class="btn btn-secondary btn-sm">Reset</a>
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
                                    <th class="text-white">No. RM</th>
                                    <th class="text-white">Nama Pasien</th>
                                    <th class="text-white">NIK</th>
                                    <th class="text-white">TTL</th>
                                    <th class="text-white">Agama</th>
                                    <th class="text-white">No. Tlp</th>
                                    <th class="text-white">E-Mail</th>
                                    <th class="text-white">Tanggal Daftar</th>
                                    <th class="text-white">Alamat</th>
                                    <th class="text-white">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien as $item)
                                    <tr>
                                        <td>{{ $item->no_rkm_medis }}</td>
                                        <td>{{ $item->nama_pasien }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->tempat_lahir . ', ' . $item->tanggal_lahir }}</td>
                                        <td>{{ $item->agama }}</td>
                                        <td>{{ $item->nomor_tlp }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->tanggal_daftar }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>
                                            <a href="/pasien-edit/{{ $item->no_rkm_medis }}"
                                                class="btn btn-sm btn-warning mb-2">Edit</a>
                                            <form action="/hapus-pasien/{{ $item->no_rkm_medis }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="confirm('apakah anda yakin?')"
                                                    class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $pasien->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
