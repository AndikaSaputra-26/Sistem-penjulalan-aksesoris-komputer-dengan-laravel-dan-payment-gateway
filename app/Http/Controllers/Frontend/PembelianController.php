<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use PDF; //library pdf
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PembelianController extends Controller
{
    public function index()
    {
        return view('frontend.pembelian');
    }

    public function export($id)
    {
        $transaksi = DB::table('transaksi')
            ->join('customer', 'customer.id', '=', 'transaksi.customer_id')
            ->join('customer_alamat', 'customer_alamat.id', '=', 'transaksi.customer_alamat_id')
            ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
            ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
            ->select('transaksi.*', 'customer.nama as nama_customer','customer.email as email_customer','customer.telpon as telpon_customer', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota', 'customer_alamat.alamat_lengkap')
            ->where('transaksi.id', $id)->first();
        $toko = DB::table('setting_toko')
                ->first();
        $detail = DB::table('transaksi_detail')
        ->join('produk', 'produk.id', '=', 'transaksi_detail.produk_id')
        ->select('transaksi_detail.*', 'produk.kode_produk' ,'produk.nama as nama_produk')
        ->where('transaksi_detail.transaksi_id', $id)->get();

        $data = PDF::loadview('frontend.invoice', [
            'data' => $transaksi,
            'toko' => $toko,
            'detailItem' =>$detail
        ]);
        return $data->download('invoice-'.$transaksi->invoice.'.pdf');
        // return view('Frontend.invoice', [
        //     'data' => $transaksi,
        //     'toko' => $toko,
        //     'detailItem' =>$detail
        // ]);
    }

    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin,
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();
        return response()->json($cost);
    }
}
