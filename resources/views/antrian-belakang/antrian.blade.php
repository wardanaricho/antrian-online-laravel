@extends('layouts.layout')
@section('title', 'Pemanggilan Antrian')
@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="position-relative">
                    <input type="text" class="form-control shadow-sm rounded-pill" placeholder="Cari pasien..."
                        name="query" id="query" autocomplete="off"
                        style="padding-left: 15px; padding-right: 15px; font-size: 14px;" autofocus>
                    <div id="hasil_cari" class="dropdown-menu w-100 mt-1 shadow-sm rounded"
                        style="display: none; max-height: 200px; overflow-y: auto; background: #fff; border: 1px solid #ddd;">
                    </div>
                </div>
            </div>




        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Menu Antrian</h4>
                    <input type="hidden" id="nomor_antrian_sekarang" value="{{ $antrian_sekarang['no_antrian'] ?? 0 }}">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h1 class="text-dark fs-xl" style="font-size: 9rem;">
                                    {{ $antrian_sekarang['no_antrian'] ?? '0' }}
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <center>
                                    <table>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary btn-lg">
                                                    <i class="fas fa-fast-backward me-1"></i> Prev
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-lg" id="playSoundBtn">
                                                    <i class="fas fa-bullhorn me-1"></i> Panggil
                                                </button>
                                            </td>
                                            <td>
                                                <form action="/next_antrian" method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary btn-lg">
                                                        <i class="fas fa-fast-forward me-1"></i> Next
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <center>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $antrian->pasien?->nama_pasien }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ $antrian->pasien?->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ $antrian->pasien?->jenis_kelamin }}</td>
                            </tr>
                        </table> --}}
                            @if ($antrian)
                                <table>
                                    {{-- <tr>
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
                                                {!! QrCode::size(300)->generate(
                                                    $antrian->pasien?->no_rkm_medis .
                                                        ' - ' .
                                                        $antrian->pasien?->nama_pasien .
                                                        ' - dengan nomor antrian : ' .
                                                        $antrian->no_antrian .
                                                        ' - TELAH TERVERIFIKASI MENGAMBIL ANTRIAN SECARA ONLINE PADA TANGGAL& JAM : ' .
                                                        $antrian->tanggal .
                                                        '/' .
                                                        $antrian->jam,
                                                ) !!}
                                            </center>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>Nomor Antrian</td>
                                        <td>: {{ $antrian->no_antrian }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pasien</td>
                                        <td>: {{ $antrian->pasien?->nama_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dokter</td>
                                        <td>: {{ $antrian->dokter?->nama_dokter }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estimasi</td>
                                        <td>: {{ $antrian->estimasi }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="2">
                                            <hr>
                                            <center>
                                                Terima Kasih Telah Mempercayai Kami
                                                <br>
                                                <strong><?= $antrian->tanggal ?></strong>
                                            </center>
                                        </td>
                                    </tr> --}}
                                </table>
                            @endif
                        </div>
                    </div>
                </center>
            </div>
        </div>
        {{-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Scan</h4>
                </div>
                <div class="card-body">
                    <div id="scanner-container" class="w-100"></div>
                    <div class="mt-3">
                        <textarea type="text" id="result" class="form-control" placeholder="Hasil Scan QR Code" rows="10" readonly></textarea>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Scan</h4>
                </div>
                <div class="card-body">
                    <div id="scanner-container" class="w-100"></div>
                    <div class="mt-3">
                        <textarea type="text" id="result" class="form-control" placeholder="Hasil Scan QR Code" rows="5" readonly></textarea>
                    </div>
                    <div class="mt-3">
                        <button id="start-scan" class="btn btn-primary">Mulai Scan</button>
                        <button id="stop-scan" class="btn btn-danger" disabled>Berhenti Scan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#playSoundBtn").click(function() {
                let nomorAntrian = $('#nomor_antrian_sekarang').val();
                let nomor = parseInt(nomorAntrian); // Konversi input ke tipe integer
                // let soundPath = '/suara/';

                // let suaraBell = '/suara/notification.wav';
                // let suaraAntrian = '/suara/antrian.wav';

                // let bell = new Audio(suaraBell);
                // let panggil = new Audio(suaraAntrian);

                // let suaraBelas = '/suara/belas.wav';
                // let audioBelas = new Audio(suaraBelas);

                // let suaraPuluh = '/suara/puluh.wav';
                // let audioPuluh = new Audio(suaraPuluh);

                // let suaraRatus = '/suara/ratus.wav';
                // let audioRatus = new Audio(suaraRatus);


                let soundPath = "{{ asset('/suara') }}" + "/";

                let suaraBell = "{{ asset('/suara/notification.wav') }}";
                let suaraAntrian = "{{ asset('/suara/antrian.wav') }}";

                let bell = new Audio(suaraBell);
                let panggil = new Audio(suaraAntrian);

                let suaraBelas = "{{ asset('/suara/belas.wav') }}";
                let audioBelas = new Audio(suaraBelas);

                let suaraPuluh = "{{ asset('/suara/puluh.wav') }}";
                let audioPuluh = new Audio(suaraPuluh);

                let suaraRatus = "{{ asset('/suara/ratus.wav') }}";

                // alert(soundPath);
                if (nomor >= 1 && nomor <= 11) {
                    // Angka 1-11
                    soundPath += nomor + '.wav';
                    // Membuat objek Audio
                    let antrian = new Audio(soundPath);

                    // Memainkan suara saat file audio selesai dimuat
                    bell.oncanplaythrough = function() {
                        bell.play();

                        setTimeout(function() {
                            panggil.play();
                            setTimeout(function() {
                                antrian.play();
                            }, panggil.duration * 1000);
                        }, bell.duration * 1000);

                    };

                } else if (nomor >= 12 && nomor <= 19) {
                    // Angka belasan
                    let belas = nomor - 10;
                    soundPath += belas + '.wav';

                    let antrian = new Audio(soundPath);

                    bell.oncanplaythrough = function() {
                        bell.play();

                        setTimeout(function() {
                            panggil.play();

                            setTimeout(function() {
                                antrian.play();

                                setTimeout(function() {
                                    audioBelas.play();
                                }, antrian.duration * 1000);

                            }, panggil.duration * 1000);

                        }, bell.duration * 1000);

                    };

                } else if (nomor >= 20 && nomor <= 99) {
                    // Angka puluhan
                    let puluhan = Math.floor(nomor / 10);
                    let satuan = nomor % 10;

                    if (satuan === 0) {

                        soundPath += puluhan + '.wav';
                        let antrian = new Audio(soundPath);

                        // alert(antrian);

                        bell.oncanplaythrough = function() {
                            bell.play();

                            setTimeout(function() {
                                panggil.play();

                                setTimeout(function() {
                                    antrian.play();

                                    setTimeout(function() {
                                        audioPuluh.play();



                                    }, antrian.duration * 1000);



                                }, panggil.duration * 1000);


                            }, bell.duration * 1000);

                        };

                    } else {

                        soundPathPuluhan = soundPath + puluhan + '.wav';
                        soundPathSatuan = soundPath + satuan + '.wav';

                        let antrianPuluhan = new Audio(soundPathPuluhan);
                        let antrianSatuan = new Audio(soundPathSatuan);


                        bell.oncanplaythrough = function() {
                            bell.play();

                            setTimeout(function() {
                                panggil.play();

                                setTimeout(function() {
                                    antrianPuluhan.play();


                                    setTimeout(function() {
                                        audioPuluh.play();

                                        setTimeout(function() {
                                            antrianSatuan.play();


                                        }, audioPuluh.duration * 1000);


                                    }, antrianPuluhan.duration * 1000);

                                }, panggil.duration * 1000);

                            }, bell.duration * 1000);

                        };


                    }

                } else if (nomor >= 100 && nomor <= 999) {
                    let ratusan = Math.floor(nomor / 100);
                    let sisa = nomor % 100;
                    let puluhan = Math.floor(sisa / 10);
                    let satuan = sisa % 10;

                    let seratus = '/suara/seratus.wav';
                    let soundSeratus = new Audio(seratus);

                    if (ratusan == 1 && sisa == 0) {
                        bell.oncanplaythrough = function() {
                            bell.play();

                            setTimeout(function() {
                                panggil.play();
                                setTimeout(function() {
                                    soundSeratus.play();
                                }, panggil.duration * 1000);
                            }, bell.duration * 1000);

                        };

                    } else if (ratusan == 1 && sisa > 0 && sisa <= 11) {
                        soundPath += sisa + '.wav';
                        ratusDigitSatu = new Audio(soundPath);

                        bell.oncanplaythrough = function() {
                            bell.play();

                            setTimeout(function() {
                                panggil.play();
                                setTimeout(function() {
                                    soundSeratus.play();
                                    setTimeout(function() {
                                        ratusDigitSatu.play();
                                    }, soundSeratus.duration * 1000);
                                }, panggil.duration * 1000);
                            }, bell.duration * 1000);
                        };

                    } else if (ratusan == 1 && sisa >= 12 && sisa <= 99) {
                        if (sisa >= 12 && sisa <= 19) {
                            let belasan = sisa - 10;
                            soundPath += belasan + '.wav';
                            let antrianBelasan = new Audio(soundPath);
                            bell.oncanplaythrough = function() {
                                bell.play();
                                setTimeout(function() {
                                    panggil.play();
                                    setTimeout(function() {
                                        soundSeratus.play();
                                        setTimeout(function() {
                                            antrianBelasan.play();
                                            setTimeout(function() {
                                                    audioBelas.play();
                                                }, antrianBelasan.duration *
                                                1000);
                                        }, soundSeratus.duration * 1000);
                                    }, panggil.duration * 1000);
                                }, bell.duration * 1000);
                            };

                        } else if (sisa >= 20 && sisa <= 99) {

                            if (satuan == 0) {
                                soundPath += puluhan + '.wav';
                                audioPuluhan = new Audio(soundPath);
                                bell.oncanplaythrough = function() {
                                    bell.play();
                                    setTimeout(function() {
                                        panggil.play();
                                        setTimeout(function() {
                                            soundSeratus.play();

                                            setTimeout(function() {
                                                audioPuluhan.play();

                                                setTimeout(function() {
                                                        audioPuluh.play();



                                                    }, audioPuluhan
                                                    .duration * 1000);

                                            }, soundSeratus.duration * 1000);


                                        }, panggil.duration * 1000);
                                    }, bell.duration * 1000);
                                };
                            } else {
                                soundPath += puluhan + '.wav';
                                audioPuluhan = new Audio(soundPath);

                                soundSatuan = '/suara/' + satuan + '.wav';
                                audioSatuan = new Audio(soundSatuan);

                                bell.oncanplaythrough = function() {
                                    bell.play();
                                    setTimeout(function() {
                                        panggil.play();
                                        setTimeout(function() {
                                            soundSeratus.play();

                                            setTimeout(function() {
                                                audioPuluhan.play();

                                                setTimeout(function() {
                                                        audioPuluh.play();

                                                        setTimeout(
                                                            function() {
                                                                audioSatuan
                                                                    .play();

                                                            },
                                                            audioPuluh
                                                            .duration *
                                                            1000);

                                                    }, audioPuluhan
                                                    .duration * 1000);

                                            }, soundSeratus.duration * 1000);


                                        }, panggil.duration * 1000);
                                    }, bell.duration * 1000);
                                };
                            }

                        }

                    } else if (ratusan > 1 && sisa == 0) {
                        let puluhan = Math.floor(sisa / 10);
                        let satuan = sisa % 10;

                        soundPath += ratusan + '.wav';
                        audioRatusan = new Audio(soundPath);

                        bell.oncanplaythrough = function() {
                            bell.play();
                            setTimeout(function() {
                                panggil.play();
                                setTimeout(function() {
                                    audioRatusan.play();
                                    setTimeout(function() {
                                        audioRatus.play();
                                    }, audioRatusan.duration * 1000);
                                }, panggil.duration * 1000);
                            }, bell.duration * 1000);
                        };
                    } else if (ratusan >= 1 && sisa > 0 && sisa <= 11) {
                        let puluhan = Math.floor(sisa / 10);
                        let satuan = sisa % 10;
                        // alert(sisa);
                        audioSisa = new Audio(soundPath + sisa + '.wav');
                        soundPath += ratusan + '.wav';
                        audioRatusan = new Audio(soundPath);

                        bell.oncanplaythrough = function() {
                            bell.play();

                            setTimeout(function() {
                                panggil.play();
                                setTimeout(function() {
                                    audioRatusan.play();
                                    setTimeout(function() {
                                        audioRatus.play();
                                        setTimeout(function() {
                                            audioSisa.play();
                                        }, audioRatus.duration * 1000);
                                    }, audioRatusan.duration * 1000);
                                }, panggil.duration * 1000);
                            }, bell.duration * 1000);

                        };
                    } else if (ratusan >= 1 && sisa >= 12 && sisa <= 99) {
                        if (sisa >= 12 && sisa <= 19) {
                            let belasan = sisa - 10;
                            let audioRatusan = new Audio(soundPath + ratusan + '.wav');

                            soundPath += belasan + '.wav';
                            let antrianBelasan = new Audio(soundPath);

                            bell.oncanplaythrough = function() {
                                bell.play();
                                setTimeout(function() {
                                    panggil.play();
                                    setTimeout(function() {
                                        audioRatusan.play();
                                        setTimeout(function() {
                                            audioRatus.play();
                                            setTimeout(function() {
                                                    antrianBelasan.play();
                                                    setTimeout(function() {
                                                            audioBelas
                                                                .play();
                                                        },
                                                        antrianBelasan
                                                        .duration * 1000
                                                    );
                                                }, audioRatus.duration *
                                                1000);
                                        }, audioRatusan.duration * 1000);
                                    }, panggil.duration * 1000);
                                }, bell.duration * 1000);
                            };

                        } else if (sisa >= 20 && sisa <= 99) {
                            let audioRatusan = new Audio(soundPath + ratusan + '.wav');

                            if (satuan == 0) {
                                soundPath += puluhan + '.wav';
                                audioPuluhan = new Audio(soundPath);
                                bell.oncanplaythrough = function() {
                                    bell.play();
                                    setTimeout(function() {
                                        panggil.play();
                                        setTimeout(function() {
                                            audioRatusan.play();

                                            setTimeout(function() {
                                                audioRatus.play();
                                                setTimeout(function() {
                                                        audioPuluhan.play();
                                                        setTimeout(
                                                            function() {
                                                                audioPuluh
                                                                    .play();
                                                            },
                                                            audioPuluhan
                                                            .duration *
                                                            1000);
                                                    }, audioRatus.duration *
                                                    1000);
                                            }, audioRatusan.duration * 1000);


                                        }, panggil.duration * 1000);
                                    }, bell.duration * 1000);
                                };
                            } else {
                                soundPath += puluhan + '.wav';
                                audioPuluhan = new Audio(soundPath);

                                soundSatuan = '/suara/' + satuan + '.wav';
                                audioSatuan = new Audio(soundSatuan);

                                bell.oncanplaythrough = function() {
                                    bell.play();
                                    setTimeout(function() {
                                        panggil.play();
                                        setTimeout(function() {
                                            audioRatusan.play();
                                            setTimeout(function() {
                                                audioRatus.play();
                                                setTimeout(function() {
                                                        audioPuluhan.play();
                                                        setTimeout(
                                                            function() {
                                                                audioPuluh
                                                                    .play();
                                                                setTimeout
                                                                    (function() {
                                                                            audioSatuan
                                                                                .play();
                                                                        },
                                                                        audioPuluh
                                                                        .duration *
                                                                        1000
                                                                    );
                                                            },
                                                            audioPuluhan
                                                            .duration *
                                                            1000);
                                                    }, audioRatus.duration *
                                                    1000);
                                            }, audioRatusan.duration * 1000);
                                        }, panggil.duration * 1000);
                                    }, bell.duration * 1000);
                                };
                            }

                        }
                    }
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#query').on('keyup', function() {
                let query = $(this).val();
                if (query.length > 2) { // Minimum 3 karakter
                    $.ajax({
                        url: '/cari_register_pasien',
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(data) {
                            console.log(data);
                            let hasil = '';
                            if (data.length > 0) {
                                data.forEach(function(item) {
                                    hasil += `
                                    <div class="dropdown-item" style="padding: 10px; border-bottom: 1px solid #ddd; cursor: pointer;">
                                        <strong>${item.pasien.nama_pasien}</strong> (${item.no_rkm_medis})<br>
                                        <small>${item.pasien.tempat_lahir}, ${item.pasien.tanggal_lahir} - ${item.pasien.jenis_kelamin}</small>

                                        <h3>No. Antrian = ${item.no_antrian}</h3>

                                        <strong> Sudah Mengambil Antrian</strong>
                                    </div>
                                `;
                                });
                            } else {
                                hasil =
                                    '<div class="dropdown-item text-muted">Tidak ada data ditemukan</div>';
                            }
                            $('#hasil_cari').html(hasil).show();
                        },
                        error: function() {
                            $('#hasil_cari').html(
                                '<div class="dropdown-item text-danger">Terjadi kesalahan</div>'
                            ).show();
                        }
                    });
                } else {
                    $('#hasil_cari').hide();
                }
            });

            $(document).on('click', '.dropdown-item', function() {
                $('#query').val($(this).find('strong').text());
                $('#hasil_cari').hide();
            });
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            const scannerContainer = $("#scanner-container"); // Area scanner
            const resultInput = $("#result"); // Input hasil

            const html5QrCode = new Html5Qrcode("scanner-container");

            // Dapatkan daftar kamera
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id; // Pilih kamera pertama

                    // Mulai scanner
                    html5QrCode.start(
                        cameraId, {
                            fps: 10, // Frame per detik
                            qrbox: {
                                width: 250,
                                height: 250
                            } // Area scan
                        },
                        function(decodedText, decodedResult) {
                            // Ketika QR code terdeteksi
                            resultInput.val(decodedText); // Tampilkan hasil di input
                            console.log("Hasil QR:", decodedText);

                            // Berhenti scan setelah sukses
                            html5QrCode.stop().then(() => {
                                console.log("Scanner stopped.");
                            }).catch(err => {
                                console.error("Error stopping scanner:", err);
                            });
                        },
                        function(errorMessage) {
                            // Log error QR scan
                            console.warn("Error scanning QR:", errorMessage);
                        }
                    ).catch(err => {
                        console.error("Error starting QR scanner:", err);
                    });
                }
            }).catch(err => {
                console.error("Error getting cameras:", err);
            });

            // Opsional: Tambahkan tombol reset
            $("#reset-scanner").on("click", function() {
                resultInput.val(""); // Kosongkan input
                html5QrCode.start(); // Mulai ulang scanner
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            const scannerContainer = $("#scanner-container"); // Area scanner
            const resultInput = $("#result"); // Input hasil

            const html5QrCode = new Html5Qrcode("scanner-container");

            // Dapatkan daftar kamera
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id; // Pilih kamera pertama

                    // Mulai scanner
                    html5QrCode.start(
                        cameraId, {
                            fps: 10, // Frame per detik
                            qrbox: {
                                width: 250,
                                height: 250
                            } // Area scan
                        },
                        function(decodedText, decodedResult) {
                            // Ketika QR code terdeteksi
                            resultInput.val(decodedText); // Tampilkan hasil di input
                            console.log("Hasil QR:", decodedText);

                            // Jangan berhenti scan setelah sukses
                            // Anda bisa memproses hasil QR seperti mengirim ke server atau lainnya

                        },
                        function(errorMessage) {
                            // Log error QR scan
                            console.warn("Error scanning QR:", errorMessage);
                        }
                    ).catch(err => {
                        console.error("Error starting QR scanner:", err);
                    });
                }
            }).catch(err => {
                console.error("Error getting cameras:", err);
            });

            // Opsional: Tambahkan tombol reset
            $("#reset-scanner").on("click", function() {
                resultInput.val(""); // Kosongkan input
                html5QrCode.start(); // Mulai ulang scanner
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            const scannerContainer = $("#scanner-container"); // Area scanner
            const resultInput = $("#result"); // Input hasil
            const startButton = $("#start-scan"); // Tombol mulai scan
            const stopButton = $("#stop-scan"); // Tombol berhenti scan

            let html5QrCode = null; // Scanner instance

            startButton.on("click", function() {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("scanner-container");
                }

                // Dapatkan daftar kamera
                Html5Qrcode.getCameras().then(cameras => {
                    if (cameras && cameras.length) {
                        const cameraId = cameras[0].id; // Pilih kamera pertama

                        // Mulai scanner
                        html5QrCode.start(
                            cameraId, {
                                fps: 10, // Frame per detik
                                qrbox: {
                                    width: 250,
                                    height: 250
                                } // Area scan
                            },
                            function(decodedText, decodedResult) {
                                // Ketika QR code terdeteksi
                                resultInput.val(decodedText); // Tampilkan hasil di input
                                console.log("Hasil QR:", decodedText);

                                // Hentikan scanner setelah sukses
                                stopScanning();
                            },
                            function(errorMessage) {
                                // Log error QR scan
                                console.warn("Error scanning QR:", errorMessage);
                            }
                        ).catch(err => {
                            console.error("Error starting QR scanner:", err);
                        });

                        startButton.prop("disabled", true);
                        stopButton.prop("disabled", false);
                    }
                }).catch(err => {
                    console.error("Error getting cameras:", err);
                });
            });

            stopButton.on("click", function() {
                stopScanning();
            });

            function stopScanning() {
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        console.log("Scanner stopped");
                        startButton.prop("disabled", false);
                        stopButton.prop("disabled", true);
                    }).catch(err => {
                        console.error("Error stopping QR scanner:", err);
                    });
                }
            }
        });
    </script>
@endpush
