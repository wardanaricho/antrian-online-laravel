<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    private function get_no_rkm_medis()
    {
        $last_no_rm = Pasien::orderByDesc('created_at')->pluck('no_rkm_medis')->first();

        if ($last_no_rm == null) {
            $no_rkm_medis = '000001';
        } else {
            $last_no_rm = substr($last_no_rm, 0, 6);
            $no_rkm_medis = sprintf('%06s', ($last_no_rm + 1));
        }

        return $no_rkm_medis;
    }

    public function daftar_pasien_online()
    {
        return view('antrian-depan.daftar-pasien');
    }

    public function simpan_pasien_online(Request $request)
    {
        $data = [
            'no_rkm_medis' => $this->get_no_rkm_medis(),
            'nik' => $request->nik,
            'nama_pasien' => $request->nama_pasien,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_daftar' => Carbon::now()->toDateString(),
            'jam_daftar' => Carbon::now()->toTimeString(),
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'nomor_tlp' => $request->nomor_tlp,
            'status_pernikahan' => $request->status,
            'alamat' => $request->alamat,
        ];

        // dd($data);
        Pasien::create($data);

        return redirect()->to('/result-pasien-online' . '/' . $data['no_rkm_medis']);
    }

    public function result_pasien_online($no_rkm_medis)
    {
        return view('antrian-depan.result-daftar-pasien', [
            'pasien' => Pasien::where('no_rkm_medis', $no_rkm_medis)->first()
        ]);
    }

    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_rkm_medis', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pasien', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_daftar', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $pasien = $query->orderBy('tanggal_daftar', 'desc')->orderBy('jam_daftar', 'desc')->paginate(10);

        return view('pasien.index', [
            'pasien' => $pasien
        ]);
    }

    public function download_pasien_online($no_rkm_medis)
    {
        $pasien = Pasien::where('no_rkm_medis', $no_rkm_medis)->first();

        // dd($pasien);
        $pdf = Pdf::loadView('pdf.hasil', ['pasien' => $pasien]);
        // return $pdf->download('invoice.pdf');
        return $pdf->download('berkas_ralan_' . $no_rkm_medis . '.pdf');
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function simpan_pasien(Request $request)
    {
        $data = [
            'no_rkm_medis' => $this->get_no_rkm_medis(),
            'nik' => $request->nik,
            'nama_pasien' => $request->nama_pasien,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_daftar' => Carbon::now()->toDateString(),
            'jam_daftar' => Carbon::now()->toTimeString(),
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'nomor_tlp' => $request->nomor_tlp,
            'status_pernikahan' => $request->status,
            'alamat' => $request->alamat,
        ];

        Pasien::create($data);

        return redirect()->to('/pasien');
    }

    public function edit($no_rkm_medis)
    {
        $pasien = Pasien::where('no_rkm_medis', $no_rkm_medis)->first();
        // dd($pasien);
        return view('pasien.edit', [
            'pasien' => $pasien
        ]);
    }

    public function update($no_rkm_medis, Request $request)
    {
        $data = [
            'nik' => $request->nik,
            'nama_pasien' => $request->nama_pasien,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'nomor_tlp' => $request->nomor_tlp,
            'status_pernikahan' => $request->status,
            'alamat' => $request->alamat,
        ];

        Pasien::where('no_rkm_medis', $no_rkm_medis)->update($data);

        return redirect()->to('/pasien');
    }

    public function destroy($no_rkm_medis)
    {
        Pasien::where('no_rkm_medis', $no_rkm_medis)->delete();
        return back();
    }

    public function downloadPdf()
    {
        // Ambil data pasien dari database
        $pasiens = Pasien::all();

        // Render view untuk PDF
        $pdf = PDF::loadView('pdf.pasien', compact('pasiens'));

        // Unduh file PDF
        return $pdf->download('data_pasien.pdf');
    }
}
