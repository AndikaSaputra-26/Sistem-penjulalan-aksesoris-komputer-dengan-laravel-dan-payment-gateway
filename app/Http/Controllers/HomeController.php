<?php

namespace App\Http\Controllers;

use App\Charts\PembelianChart;
use App\Charts\PenjualanChart;
use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jml_produk = DB::table("produk")
            ->count();
        $jml_kategori = DB::table("kategori")
            ->count();
        $jml_user = DB::table("users")
            ->count();
        $jml_role = DB::table("roles")
            ->count();
        $penjualan = Transaksi::where('status_bayar', 'paid')
            ->sum('grand_total');

        $pembelian = Pembelian::where('status_bayar', 'Sudah Bayar')->sum('grand_total');
        // data cart pembelian
        $dataCartPembelian = Pembelian::Where('status_bayar','Sudah Bayar')
        ->selectRaw("SUM(grand_total) as grand_total")
        ->selectRaw("tanggal")
        ->groupBy('tanggal')
        ->skip(0)
        ->take(10)
        ->get();
        $tanggalPembelian =[];
        $uangPembelian =[];

        foreach($dataCartPembelian as $data){
            array_push($tanggalPembelian, $data->tanggal);
            array_push($uangPembelian, $data->grand_total);
        }


        // data cart penjualan
        $dataCartPenjualan = Transaksi::Where('status_bayar','paid')
        ->selectRaw("SUM(grand_total) as grand_total")
        ->selectRaw("tanggal_pembelian")
        ->groupBy('tanggal_pembelian')
        ->skip(0)
        ->take(10)
        ->get();

        $tanggalPenjualan =[];
        $uangPenjualan =[];

        foreach($dataCartPenjualan as $data){
            array_push($tanggalPenjualan, $data->tanggal_pembelian);
            array_push($uangPenjualan, $data->grand_total);
        }



        $pembelianChart = new PembelianChart;
        $pembelianChart->labels($tanggalPembelian);
        $pembelianChart->dataset('Pembelian 10 Hari Terakhir', 'line', $uangPembelian);

        $penjualanChart = new PenjualanChart;
        $penjualanChart->labels($tanggalPenjualan);
        $penjualanChart->dataset('Penjualan 10 Hari Terakhir', 'line', $uangPenjualan);

        return view('home.index', [
            'jml_produk' => $jml_produk,
            'jml_kategori' => $jml_kategori,
            'jml_user' => $jml_user,
            'jml_role' => $jml_role,
            'penjualan' => $penjualan,
            'pembelian' => $pembelian,
            'pembelianChart' => $pembelianChart,
            'penjualanChart' => $penjualanChart,
        ]);
    }
}
