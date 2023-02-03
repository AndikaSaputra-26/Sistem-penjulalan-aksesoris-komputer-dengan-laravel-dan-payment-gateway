<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaksi;
use PDF; //library pdf
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:transaksi_show')->only('index');
        $this->middleware('permission:transaksi_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaksi::with('customer:id,nama,telpon', 'customer_alamat:id,alamat_lengkap');
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->customer->nama;
                })
                ->addColumn('customer_alamat', function ($row) {
                    return $row->customer_alamat->alamat_lengkap;
                })
                ->addColumn('telpon', function ($row) {
                    return $row->customer->telpon;
                })
                ->addColumn('action', 'transaksi._action')
                ->toJson();
        }

        return view('transaksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(transaksi $transaksi)
    {
        // return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        DB::table('transaksi')
            ->where('id', $request->update_id_transaksi)
            ->update(['no_resi' => $request->update_resi]);
        Alert::toast('No Resi berhasil di input', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi = Transaksi::findOrFail($transaksi->id);
        $transaksi->delete();
        if ($transaksi) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('transaksi.index');
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->route('transaksi.index');
        }
    }

    public function laporan_transaksi(Request $request)
    {

        $customer = $request->customer;
        $dari = $request->dari;
        $ke = $request->ke;

        if ($customer == 'semua') {
            $transaksi = DB::table('transaksi')
                ->join('customer', 'customer.id', '=', 'transaksi.customer_id')
                ->join('customer_alamat', 'customer_alamat.id', '=', 'transaksi.customer_alamat_id')
                ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
                ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
                ->select('transaksi.*', 'customer.nama as nama_customer', 'customer.email as email_customer', 'customer.telpon as telpon_customer', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota', 'customer_alamat.alamat_lengkap')
                ->whereDate('transaksi.tanggal_pembelian', '>=', $dari)
                ->whereDate('transaksi.tanggal_pembelian', '<=', $ke)
                ->get();

            $totalTransaksi = DB::table('transaksi')
                ->join('customer', 'customer.id', '=', 'transaksi.customer_id')
                ->join('customer_alamat', 'customer_alamat.id', '=', 'transaksi.customer_alamat_id')
                ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
                ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
                ->select('transaksi.*', 'customer.nama as nama_customer', 'customer.email as email_customer', 'customer.telpon as telpon_customer', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota', 'customer_alamat.alamat_lengkap')
                ->whereDate('transaksi.tanggal_pembelian', '>=', $dari)
                ->whereDate('transaksi.tanggal_pembelian', '<=', $ke)
                ->sum('transaksi.grand_total');
        } else {
            $transaksi = DB::table('transaksi')
                ->join('customer', 'customer.id', '=', 'transaksi.customer_id')
                ->join('customer_alamat', 'customer_alamat.id', '=', 'transaksi.customer_alamat_id')
                ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
                ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
                ->select('transaksi.*', 'customer.nama as nama_customer', 'customer.email as email_customer', 'customer.telpon as telpon_customer', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota', 'customer_alamat.alamat_lengkap')
                ->whereDate('transaksi.tanggal_pembelian', '>=', $dari)
                ->whereDate('transaksi.tanggal_pembelian', '<=', $ke)
                ->where('transaksi.customer_id', $customer)
                ->get();

            $totalTransaksi = DB::table('transaksi')
                ->join('customer', 'customer.id', '=', 'transaksi.customer_id')
                ->join('customer_alamat', 'customer_alamat.id', '=', 'transaksi.customer_alamat_id')
                ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
                ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
                ->select('transaksi.*', 'customer.nama as nama_customer', 'customer.email as email_customer', 'customer.telpon as telpon_customer', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota', 'customer_alamat.alamat_lengkap')
                ->whereDate('transaksi.tanggal_pembelian', '>=', $dari)
                ->whereDate('transaksi.tanggal_pembelian', '<=', $ke)
                ->where('transaksi.customer_id', $customer)
                ->sum('transaksi.grand_total');
        }
        // dd($transaksi);

        $toko = DB::table('setting_toko')
            ->first();

        $data = PDF::loadview('transaksi.laporan_transaksi', [
            'data' => $transaksi,
            'toko' => $toko,
            'totalTransaksi' => $totalTransaksi
        ]);
        return $data->download('Laporan_Transaksi.pdf');
        // return view('transaksi.laporan_transaksi', [
        //     'data' => $transaksi,
        //     'toko' => $toko,
        //     'totalTransaksi' => $totalTransaksi
        // ]);
    }
}
