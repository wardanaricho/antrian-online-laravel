<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Data Pasien</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No RKm</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>Dokter</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registers as $index => $register)
                <tr>
                    <td>{{ $register->no_antrian }}</td>
                    <td>{{ $register->no_rkm_medis }}</td>
                    <td>{{ $register->pasien?->nama_pasien }}</td>
                    <td>{{ $register->pasien?->alamat }}</td>
                    <td>{{ $register->dokter?->nama_dokter }}</td>
                    <td>{{ $register->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
