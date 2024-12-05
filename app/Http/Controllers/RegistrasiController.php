<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Register;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index(Request $request)
    {
        $tglNow = Carbon::now()->toDateString();

        $query = Register::with('pasien');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_rkm_medis', 'like', '%' . $request->search . '%')
                    ->orWhereHas('pasien', function ($pasienQuery) use ($request) {
                        $pasienQuery->where('nama_pasien', 'like', '%' . $request->search . '%')
                            ->orWhere('nik', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $startDate = $request->filled('start_date') ? $request->start_date : $tglNow;
        $endDate = $request->filled('end_date') ? $request->end_date : $tglNow;

        $query->whereBetween('tanggal_regis', [$startDate, $endDate]);

        $register = $query->paginate(10);

        return view('registrasi.index', [
            'register' => $register,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('query');

        $registers = Register::with(['pasien'])
            ->whereHas('pasien', function ($query) use ($keyword) {
                $query->where('nama_pasien', 'like', "%$keyword%")
                    ->orWhere('no_rkm_medis', 'like', "%$keyword%");
            })
            ->get();

        return response()->json($registers);
    }

    public function downloadPdf($startDate, $endDate)
    {
        $startDate = $startDate ?? Carbon::now()->toDateString();
        $endDate = $endDate ?? Carbon::now()->toDateString();

        $query = Register::with('pasien');

        $query->whereBetween('tanggal_regis', [$startDate, $endDate]);

        $registers = $query->paginate(10);

        // Render view untuk PDF
        $pdf = PDF::loadView('pdf.register', compact('registers'));

        // Unduh file PDF
        return $pdf->download('data_register.pdf');
    }
}
