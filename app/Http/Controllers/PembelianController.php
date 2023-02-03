<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF; //library pdf

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pembelian_show')->only('index');
        $this->middleware('permission:pembelian_create')->only('create', 'store');
        $this->middleware('permission:pembelian_update')->only('edit', 'update');
        $this->middleware('permission:pembelian_delete')->only('delete');
    }


    public function index()
    {
        if (request()->ajax()) {
            $query = Pembelian::with('supplier:id,nama');
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('supplier', function ($row) {
                    return $row->supplier->nama;
                })
                ->addColumn('action', 'pembelian._action')
                ->toJson();
        }

        return view('pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Supplier::all();
        $produk = Produk::all();
        return view('pembelian.add', [
            'supplier' => $supplier,
            'produk' => $produk
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $pembelian = Pembelian::create([
                'supplier_id' => $request->supplier,
                'kode_pembelian' => $request->kode,
                'tanggal' => $request->tanggal,
                'grand_total' => $request->grand_total,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'catatan' => $request->catatan,
                'status_bayar' => 'Belum Bayar',
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailPurch[] = new PembelianDetail([
                    'produk_id' => $prd,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'sub_total' => $request->subtotal[$i],
                ]);
            }

            $pembelian->detail_pembelian()->saveMany($detailPurch);
        });
        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        $purchase = DB::table('pembelian')
            ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
            ->select('pembelian.*', 'pembelian.id as pembelian_id', 'supplier.*')
            ->where('pembelian.id', '=', $pembelian->id)
            ->first();
        $detail_purchase = DB::table('pembelian_detail')
            ->join('produk', 'produk.id', '=', 'pembelian_detail.produk_id')
            ->join('units', 'units.id', '=', 'produk.unit_id')
            ->select('pembelian_detail.*', 'produk.nama as nama_produk', 'produk.qty as stok', 'produk.id as produk_id', 'units.nama_unit')
            ->where('pembelian_detail.pembelian_id', '=', $pembelian->id)
            ->get();
        $supplier = Supplier::all();
        $produk = Produk::all();
        return view('pembelian.edit', compact('produk', 'supplier', 'purchase', 'detail_purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        // hapus detail pembelian lama
        $pembelian->detail_pembelian()->delete();
        // update data pembelian
        $pembelian->update([
            'supplier_id' => $request->supplier,
            'kode_pembelian' => $request->kode,
            'tanggal' => $request->tanggal,
            'grand_total' => $request->grand_total,
            'total' => $request->total,
            'diskon' => $request->diskon,
            'catatan' => $request->catatan,
            'status_bayar' => 'Belum Bayar',
        ]);

        foreach ($request->produk as $i => $prd) {
            $detailPurch[] = new PembelianDetail([
                'produk_id' => $prd,
                'harga' => $request->harga[$i],
                'qty' => $request->qty[$i],
                'sub_total' => $request->subtotal[$i],
            ]);
        }
        // insert batch
        $pembelian->detail_pembelian()->saveMany($detailPurch);
        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        $pembelian = Pembelian::findOrFail($pembelian->id);
        $pembelian->delete();
        if ($pembelian) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('pembelian.index');
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->route('pembelian.index');
        }
    }

    public function update_pembayaran($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update([
            'status_bayar'   => 'Sudah Bayar',
        ]);

        if ($pembelian) {
            $detailItem = DB::table('pembelian_detail')
                ->where('pembelian_id', '=', $id)
                ->get();
            foreach ($detailItem as $row) {
                $product = Produk::find($row->produk_id);
                $product->increment('qty', $row->qty);
            }
            Alert::toast('Pembayaran berhasil divalidasi', 'success');
            return redirect()->route('pembelian.index');
        } else {
            Alert::toast('Pembayaran gagal divalidasi', 'error');
            return redirect()->route('pembelian.index');
        }
    }

    public function laporan_pembelian(Request $request)
    {

        $supplier = $request->supplier;
        $dari = $request->dari;
        $ke = $request->ke;

        if ($supplier == 'semua') {
            $pembelian = DB::table('pembelian')
                ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                ->select('pembelian.*', 'supplier.*')
                ->whereDate('pembelian.tanggal', '>=', $dari)
                ->whereDate('pembelian.tanggal', '<=', $ke)
                ->get();

            $totalPembelian = DB::table('pembelian')
                ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                ->whereDate('pembelian.tanggal', '>=', $dari)
                ->whereDate('pembelian.tanggal', '<=', $ke)
                ->sum('pembelian.grand_total');
        } else {
            $pembelian = DB::table('pembelian')
                ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                ->select('pembelian.*', 'supplier.*')
                ->whereDate('pembelian.tanggal', '>=', $dari)
                ->whereDate('pembelian.tanggal', '<=', $ke)
                ->where('pembelian.supplier_id', $supplier)
                ->get();

            $totalPembelian = DB::table('pembelian')
                ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                ->whereDate('pembelian.tanggal', '>=', $dari)
                ->whereDate('pembelian.tanggal', '<=', $ke)
                ->where('pembelian.supplier_id', $supplier)
                ->sum('pembelian.grand_total');
        }
        $toko = DB::table('setting_toko')
            ->first();

        $data = PDF::loadview('pembelian.laporan_pembelian', [
            'data' => $pembelian,
            'toko' => $toko,
            'totalPembelian' => $totalPembelian
        ]);
        return $data->download('Laporan_pembelian.pdf');
        // return view('pembelian.laporan_pembelian', [
        //     'data' => $pembelian,
        //     'toko' => $toko,
        //     'totalPembelian' => $totalPembelian
        // ]);
    }
}
