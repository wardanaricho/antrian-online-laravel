<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-logo {
            width: 100px;
            height: auto;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #555;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #444;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .table td {
            vertical-align: top;
        }

        .table-striped tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .fs-5 {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-text">
            <h1>Rumah Sunat Amanah</h1>
            <h2>Data Rekam Medis Pasien</h2>
            <p>Alamat: Ringin Sari, Pandangan, Kec. Kayen Kidul Kab. Kediri, Jawa Timur 64183</p>
            <p>Telp: 082185313737 | Email: rumahsunatmoderenamanah@gmail.com</p>
        </div>
    </div>

    <hr>

    <h4 style="text-align: center; margin-top: 30px;">DATA DIRI PASIEN</h4>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <tr>
                <th>Nomor Rekam Medis</th>
                <td><strong class="fs-5">{{ $pasien->no_rkm_medis }}</strong></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $pasien->nama_pasien }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $pasien->email }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $pasien->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $pasien->tempat_lahir }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $pasien->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Tanggal/Jam Daftar</th>
                <td>{{ $pasien->tanggal_daftar . '/' . $pasien->jam_daftar }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $pasien->agama }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $pasien->pekerjaan }}</td>
            </tr>
            <tr>
                <th>Nomor Tlp</th>
                <td>{{ $pasien->nomor_tlp }}</td>
            </tr>
            <tr>
                <th>Status Pernikahan</th>
                <td>{{ $pasien->status_pernikahan }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $pasien->alamat }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
