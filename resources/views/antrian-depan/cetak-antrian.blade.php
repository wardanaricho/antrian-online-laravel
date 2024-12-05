<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <style>
        table {
            /* text-align: center; */
            border-collapse: collapse;
        }

        table tr td {
            /* border: 1px solid black; */
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="2">
                <center>
                    RUMAH SUNAT AMANAH
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <center>
                    Jl. Dummy Kec.Dummy Kab.Dummy 63345
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
                <center>
                    {!! QrCode::size(80)->generate(
                        'Nama pasien : ' . $register->pasien->nama_pasien . ', Nomor antrian : ' . $antrian->no_antrian,
                    ) !!}
                </center>
            </td>
        </tr>
        <tr>
            <td>Nomor Antrian</td>
            <td>: {{ $antrian->no_antrian }}</td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: {{ $register->pasien->nama_pasien }}</td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>: {{ $register->dokter->nama_dokter }}</td>
        </tr>
        <tr>
            <td>Estimasi</td>
            <td>: {{ $antrian->estimasi }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
                <center>
                    Terima Kasih Telah Mempercayai Kami
                    <br>
                    <strong><?= $antrian->tanggal ?></strong>
                </center>
            </td>
        </tr>
    </table>
    <script>
        window.print();

        window.onafterprint = function() {
            history.back();
        }
    </script>

</body>

</html>
