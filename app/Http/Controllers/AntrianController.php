<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AntrianController extends Controller
{
    public function ambil_antrian_rm()
    {
        return view('antrian-depan.ambil-per-rm');
    }

    public function ambil_antrian_nik()
    {
        return view('antrian-depan.ambil-per-nik');
    }

    public function cek_antrian_rm(Request $request)
    {
        $pasien = Pasien::where('no_rkm_medis', $request->no_rkm_medis)->first();
        $dokter = Dokter::where('id', $request->id_dokter)->first();
        if ($pasien) {
            return view('antrian-depan.verifikasi-antrian-pasien', [
                'pasien' => $pasien,
                'dokter' => $dokter
            ]);
        } else {
            return redirect()->to('/')->with('antrian', 'Nomor Rekam Medis Anda Tidak TERDAFTAR, Silahkan ulangi lagi atau daftar pasien');
        }
    }

    public function cek_antrian_nik(Request $request)
    {
        $pasien = Pasien::where('nik', $request->nik)->first();
        $dokter = Dokter::where('id', $request->id_dokter)->first();
        if ($pasien) {
            return view('antrian-depan.verifikasi-antrian-pasien', [
                'pasien' => $pasien,
                'dokter' => $dokter
            ]);
        } else {
            return redirect()->to('/antrian-nik')->with('antrian', 'NIK Anda Tidak TERDAFTAR, Silahkan ulangi lagi atau daftar pasien');
        }
    }

    public function ambil_antrian(Request $request)
    {
        // Mendapatkan tanggal saat ini dalam format Y-m-d
        $tglNow = Carbon::now()->toDateString();

        // Mendapatkan waktu sekarang
        $jamNow = Carbon::now();

        // Mendefinisikan waktu buka klinik pada pukul 15:00 pada hari ini
        $clinicOpenTime = Carbon::createFromFormat('Y-m-d H:i', $tglNow . ' 15:00');

        // Batas maksimal antrean per hari
        $maxAntrianPerHari = 20;

        // Menghitung jumlah antrean yang ada pada hari ini
        $countAntrianToday = Antrian::where('tanggal', $tglNow)->count();

        // Jika jumlah antrean hari ini telah mencapai batas maksimal
        if ($countAntrianToday >= $maxAntrianPerHari) {
            // Cari tanggal besok
            $tglBesok = Carbon::now()->addDay()->toDateString();

            // Loop mencari hari berikutnya dengan antrean yang belum penuh
            while (true) {
                // Menghitung jumlah antrean untuk tanggal besok
                $countAntrianBesok = Antrian::where('tanggal', $tglBesok)->count();
                if ($countAntrianBesok < $maxAntrianPerHari) {
                    // Berhenti jika tanggal ditemukan
                    break;
                }
                // Tambahkan satu hari lagi
                $tglBesok = Carbon::createFromFormat('Y-m-d', $tglBesok)->addDay()->toDateString();
            }

            // Menampilkan konfirmasi tanggal untuk antrian baru
            return view('antrian-depan.konfirmasi-antrian', [
                'no_rkm_medis' => $request->no_rkm_medis,
                'id_dokter' => $request->id_dokter,
                'tglBesok' => $tglBesok,
            ]);
        }

        // Menentukan nomor antrean berikutnya untuk hari ini
        $no_antrian = $countAntrianToday + 1;

        // Mengambil antrean terakhir untuk menentukan waktu estimasi
        $prevAntrian = Antrian::where('tanggal', $tglNow)
            ->orderBy('no_antrian', 'desc')
            ->first();

        if ($prevAntrian) {
            // Menghitung waktu estimasi berdasarkan antrean terakhir
            $lastEstimasiTime = Carbon::parse($prevAntrian->estimasi);

            // Menentukan waktu mulai estimasi untuk antrean berikutnya
            $startEstimationTime = $lastEstimasiTime->greaterThanOrEqualTo($jamNow)
                ? $lastEstimasiTime->addMinutes(10)
                : $clinicOpenTime;
        } else {
            // Jika belum ada antrean, gunakan waktu buka klinik
            $startEstimationTime = $jamNow->greaterThanOrEqualTo($clinicOpenTime) ? $jamNow : $clinicOpenTime;
        }

        // Salin waktu estimasi
        $estimasiJamAntrian = $startEstimationTime->copy();

        // Data untuk tabel antrean
        $data = [
            'tanggal' => $tglNow,
            'jam' => $jamNow->toTimeString(),
            'no_antrian' => $no_antrian,
            'status_antrian' => '1', // Status default untuk antrean baru
            'no_rkm_medis' => $request->no_rkm_medis,
            'dokter_id' => $request->id_dokter,
            'estimasi' => $estimasiJamAntrian,
        ];

        // Data untuk tabel registrasi
        $register = [
            'no_antrian' => $data['no_antrian'],
            'no_rkm_medis' => $request->no_rkm_medis,
            'tanggal_regis' => $tglNow,
            'jam_regis' => $jamNow->toTimeString(),
            'keluhan_awal' => '-', // Keluhan default
            'dokter_id' => $request->id_dokter,
        ];

        try {
            // Simpan data antrean dan registrasi ke database
            Antrian::create($data);
            Register::create($register);

            // Redirect ke halaman hasil antrean
            return redirect()->to('/result-antrian/' . $tglNow . '/' . $request->no_rkm_medis . '/' . $data['no_antrian']);
        } catch (\Exception $e) {
            // Menampilkan error jika terjadi kesalahan
            return 'Error: ' . $e->getMessage();
        }
    }



    public function ambil_antrian_besok(Request $request)
    {
        // Mendapatkan tanggal besok
        $tglBesok = Carbon::now()->addDay()->toDateString();

        // Batas maksimal antrean per hari
        $maxAntrianPerHari = 20;

        // Menghitung jumlah antrean untuk tanggal besok
        $countAntrianBesok = Antrian::where('tanggal', $tglBesok)->count();

        // Jika jumlah antrean besok telah mencapai batas maksimal
        if ($countAntrianBesok >= $maxAntrianPerHari) {
            // Loop untuk mencari hari berikutnya yang belum penuh
            while (true) {
                $tglBesok = Carbon::createFromFormat('Y-m-d', $tglBesok)->addDay()->toDateString();
                $countAntrianBesok = Antrian::where('tanggal', $tglBesok)->count();
                if ($countAntrianBesok < $maxAntrianPerHari) {
                    break;
                }
            }
        }

        // Menentukan nomor antrean berikutnya untuk besok
        $no_antrian = $countAntrianBesok + 1;

        // Mengambil antrean terakhir untuk menentukan waktu estimasi
        $prevAntrian = Antrian::where('tanggal', $tglBesok)
            ->orderBy('no_antrian', 'desc')
            ->first();

        // Menentukan waktu estimasi awal
        $clinicOpenTime = Carbon::createFromFormat('Y-m-d H:i', $tglBesok . ' 15:00');
        if ($prevAntrian) {
            $lastEstimasiTime = Carbon::parse($prevAntrian->estimasi);
            $startEstimationTime = $lastEstimasiTime->addMinutes(10);
        } else {
            $startEstimationTime = $clinicOpenTime;
        }

        // Salin waktu estimasi
        $estimasiJamAntrian = $startEstimationTime->copy();

        // Data untuk tabel antrean
        $data = [
            'tanggal' => $tglBesok,
            'jam' => Carbon::now()->toTimeString(),
            'no_antrian' => $no_antrian,
            'status_antrian' => '1', // Status default untuk antrean baru
            'no_rkm_medis' => $request->no_rkm_medis,
            'dokter_id' => $request->id_dokter,
            'estimasi' => $estimasiJamAntrian,
        ];

        // Data untuk tabel registrasi
        $register = [
            'no_antrian' => $data['no_antrian'],
            'no_rkm_medis' => $request->no_rkm_medis,
            'tanggal_regis' => $tglBesok,
            'jam_regis' => Carbon::now()->toTimeString(),
            'keluhan_awal' => '-', // Keluhan default
            'dokter_id' => $request->id_dokter,
        ];

        try {
            // Simpan data antrean dan registrasi ke database
            Antrian::create($data);
            Register::create($register);

            // Redirect ke halaman hasil antrean
            return redirect()->to('/result-antrian/' . $tglBesok . '/' . $request->no_rkm_medis . '/' . $data['no_antrian']);
        } catch (\Exception $e) {
            // Menampilkan error jika terjadi kesalahan
            return 'Error: ' . $e->getMessage();
        }
    }



    public function result_antrian($tgl, $no_rkm_medis, $no_antrian)
    {
        $antrian = Antrian::where('tanggal', $tgl)->where('no_rkm_medis', $no_rkm_medis)->where('no_antrian', $no_antrian)->first();

        $register = Register::with(['pasien', 'dokter'])->where('tanggal_regis', $tgl)->where('no_rkm_medis', $no_rkm_medis)->where('no_antrian', $no_antrian)->first();

        // dd($register->dokter->nama_dokter);

        // dd($antrian);
        return view('antrian-depan.result-antrian', [
            'antrian' => $antrian,
            'register' => $register
        ]);
    }

    public function cetak_antrian($tgl, $no_rkm_medis, $no_antrian)
    {
        $antrian = Antrian::where('tanggal', $tgl)->where('no_rkm_medis', $no_rkm_medis)->where('no_antrian', $no_antrian)->first();

        $register = Register::with(['pasien', 'dokter'])->where('tanggal_regis', $tgl)->where('no_rkm_medis', $no_rkm_medis)->where('no_antrian', $no_antrian)->first();

        // dd($register->dokter->nama_dokter);

        return view('antrian-depan.cetak-antrian', [
            'antrian' => $antrian,
            'register' => $register
        ]);
    }

    public function index()
    {
        $tglNow = Carbon::now()->toDateString();
        $antrian_sekarang = Antrian::where('status_antrian', '2')->where('tanggal', $tglNow)->first();
        $total_antrian = Antrian::where('tanggal', $tglNow)->count();
        // dd($total_antrian);

        if ($antrian_sekarang) {
            $antrian = Antrian::with(["pasien", "dokter"])->where('tanggal', Carbon::now()->toDateString())->where('no_antrian', $antrian_sekarang->no_antrian)->first();
        } else {
            $antrian = null;
        }

        return view('antrian-belakang.antrian', [
            'antrian_sekarang' => $antrian_sekarang,
            'total_antrian' => $total_antrian,
            'antrian' => $antrian
        ]);
    }

    public function next_antrian()
    {
        $tglNow = Carbon::now()->toDateString();
        $no_antrian_sekarang = Antrian::where('tanggal', $tglNow)->where('status_antrian', '1')->orderBy('tanggal')->orderBy('jam')->first();
        if ($no_antrian_sekarang && $no_antrian_sekarang->no_antrian != 1) {
            $no_antrian_sebelumnya = Antrian::where('tanggal', $tglNow)->where('status_antrian', '2')->orderBy('tanggal')->orderBy('jam')->first();

            $id_prev = $no_antrian_sebelumnya->id;
            Antrian::where('id', $id_prev)->update([
                'status_antrian' => '3'
            ]);
        }

        if ($no_antrian_sekarang != null) {
            $id = $no_antrian_sekarang->id;
            Antrian::where('id', $id)->update([
                'status_antrian' => '2'
            ]);

            return back();
        } else {
            return back();
        }
    }

    public function display()
    {
        return view('antrian.display');
    }

    public function getAntrianData()
    {
        $tglNow = Carbon::now()->toDateString();
        $antrian = Antrian::where('status_antrian', '2')
            ->where('tanggal', $tglNow)
            ->first();

        return response()->json(['no_antrian' => $antrian ? $antrian->no_antrian : null]);
    }
}
