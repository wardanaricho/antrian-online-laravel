<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        header,
        footer {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .antrian-box {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .antrian-number {
            font-size: 120px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Rumah Sunat Amanah</h1>
        <h2>Data Rekam Medis Pasien</h2>
        <p>Alamat: Ringin Sari, Pandangan, Kec. Kayen Kidul Kab. Kediri, Jawa Timur 64183</p>
        <p>Telp: 082185313737 | Email: rumahsunatmoderenamanah@gmail.com</p>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="antrian-box">
            <h1>Status Antrian</h1>
            <div id="no-antrian" class="antrian-number">-</div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Rumah Sunat Amanah. All Rights Reserved.</p>
    </footer>

    <script>
        function fetchAntrian() {
            $.ajax({
                url: "{{ route('antrian.data') }}",
                method: "GET",
                success: function(response) {
                    $('#no-antrian').text(response.no_antrian || '-');
                },
                error: function() {
                    $('#no-antrian').text('Error');
                }
            });
        }

        // Fetch data every 2 seconds
        setInterval(fetchAntrian, 2000);

        // Fetch data immediately on page load
        fetchAntrian();
    </script>
</body>

</html>
