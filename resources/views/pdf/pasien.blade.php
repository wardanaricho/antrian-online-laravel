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
                <th>Nama Pasien</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $index => $pasien)
                <tr>
                    <td>{{ $pasien->no_rkm_medis }}</td>
                    <td>{{ $pasien->nama_pasien }}</td>
                    <td>{{ $pasien->tanggal_lahir }}</td>
                    <td>{{ $pasien->alamat }}</td>
                    <td>{{ $pasien->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
