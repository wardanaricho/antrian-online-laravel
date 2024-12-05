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
        $tglNow = Carbon::now()->toDateString();
        $jamNow = Carbon::now();
        $clinicOpenTime = Carbon::createFromFormat('Y-m-d H:i', $tglNow . ' 15.45');
        // dd($clinicOpenTime);
        $maxAntrianPerHari = 20; // Batas maksimal antrian per hari

        // Hitung jumlah antrian pada hari ini
        $countAntrianToday = Antrian::where('tanggal', $tglNow)->count();

        if ($countAntrianToday >= $maxAntrianPerHari) {
            $tglBesok = Carbon::now()->addDay()->toDateString();
            while (true) {
                $countAntrianBesok = Antrian::where('tanggal', $tglBesok)->count();
                if ($countAntrianBesok < $maxAntrianPerHari) {
                    break;
                }
                $tglBesok = Carbon::createFromFormat('Y-m-d', $tglBesok)->addDay()->toDateString();
            }

            return view('antrian-depan.konfirmasi-antrian', [
                'no_rkm_medis' => $request->no_rkm_medis,
                'id_dokter' => $request->id_dokter,
                'tglBesok' => $tglBesok,
            ]);
        }

        $no_antrian = $countAntrianToday + 1;

        // Tentukan waktu estimasi berdasarkan jam pengambilan
        $startEstimationTime = $jamNow->greaterThanOrEqualTo($clinicOpenTime) ? $jamNow : $clinicOpenTime;
        $estimasiJamAntrian = $startEstimationTime->copy()->addMinutes(10 * ($no_antrian - 1));

        $data = [
            'tanggal' => $tglNow,
            'jam' => $jamNow->toTimeString(),
            'no_antrian' => $no_antrian,
            'status_antrian' => '1',
            'no_rkm_medis' => $request->no_rkm_medis,
            'dokter_id' => $request->id_dokter,
            'estimasi' => $estimasiJamAntrian,
        ];

        $register = [
            'no_antrian' => $data['no_antrian'],
            'no_rkm_medis' => $request->no_rkm_medis,
            'tanggal_regis' => $tglNow,
            'jam_regis' => $jamNow->toTimeString(),
            'keluhan_awal' => '-',
            'dokter_id' => $request->id_dokter,
        ];

        try {
            Antrian::create($data);
            Register::create($register);

            return redirect()->to('/result-antrian/' . $tglNow . '/' . $request->no_rkm_medis . '/' . $data['no_antrian']);
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function ambilAntrianBesok(Request $request)
    {
        $tglTarget = $request->tanggal;
        $jamNow = Carbon::now();
        $clinicOpenTime = Carbon::createFromFormat('Y-m-d H:i', $tglTarget . ' 15.45');
        $maxAntrianPerHari = 20;

        while (true) {
            $countAntrian = Antrian::where('tanggal', $tglTarget)->count();
            if ($countAntrian < $maxAntrianPerHari) {
                break;
            }
            $tglTarget = Carbon::createFromFormat('Y-m-d', $tglTarget)->addDay()->toDateString();
            $clinicOpenTime = Carbon::createFromFormat('Y-m-d H:i', $tglTarget . ' 15.45');
        }

        $no_antrian = $countAntrian + 1;
        $startEstimationTime = $jamNow->greaterThanOrEqualTo($clinicOpenTime) ? $jamNow : $clinicOpenTime;
        $estimasiJamAntrian = $startEstimationTime->copy()->addMinutes(10 * ($no_antrian - 1));

        $data = [
            'tanggal' => $tglTarget,
            'jam' => $jamNow->toTimeString(),
            'no_antrian' => $no_antrian,
            'status_antrian' => '1',
            'no_rkm_medis' => $request->no_rkm_medis,
            'dokter_id' => $request->id_dokter,
            'estimasi' => $estimasiJamAntrian,
        ];

        $register = [
            'no_antrian' => $data['no_antrian'],
            'no_rkm_medis' => $request->no_rkm_medis,
            'tanggal_regis' => $tglTarget,
            'jam_regis' => $jamNow->toTimeString(),
            'keluhan_awal' => '-',
            'dokter_id' => $request->id_dokter,
        ];

        try {
            Antrian::create($data);
            Register::create($register);

            return redirect()->to('/result-antrian/' . $tglTarget . '/' . $request->no_rkm_medis . '/' . $data['no_antrian']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
