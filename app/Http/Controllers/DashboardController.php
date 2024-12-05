<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pasien = Pasien::count();
        $antrian_hari_ini = Antrian::where('tanggal', Carbon::now()->toDateString())->count();
        $antrian_selesai = Antrian::where('tanggal', Carbon::now()->toDateString())->where('status_antrian', '3')->count();
        $sisa_antrian = Antrian::where('tanggal', Carbon::now()->toDateString())->where('status_antrian', '1')->count();

        return view('dashboard.dashboard', compact([
            'pasien',
            'antrian_hari_ini',
            'antrian_selesai',
            'sisa_antrian'

        ]));
    }
}
