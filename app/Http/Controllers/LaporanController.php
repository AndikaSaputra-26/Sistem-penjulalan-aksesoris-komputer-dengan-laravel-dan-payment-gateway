<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan_pembelian(){
        return view('laporan.laporan_pembelian');
    }

    public function laporan_penjualan(){
        return view('laporan.laporan_penjualan');
    }
}
