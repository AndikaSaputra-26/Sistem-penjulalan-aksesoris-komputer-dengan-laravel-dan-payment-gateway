<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class SupplierController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:supplier_show')->only('index');
        $this->middleware('permission:supplier_create')->only('create', 'store');
        $this->middleware('permission:supplier_update')->only('edit', 'update');
        $this->middleware('permission:supplier_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Supplier::query();
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'supplier._action')
                ->toJson();
        }
        return view('supplier.index');
    }
        //

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_supplier' => "required|string|max:100|unique:supplier,kode_supplier",
                'nama' => "required|string|max:100",
                'alamat' => "required|string",
                'telpon' => "required|string",
                'email' => "required|string",
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $supplier = Supplier::create([
            'kode_supplier'   => $request->kode_supplier,
            'nama'            => $request->nama,
            'alamat'          => $request->alamat,
            'telpon'          => $request->telpon,
            'email'           => $request->email,
        ]);
        if ($supplier) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('supplier.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('supplier.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_supplier' => "required|string|max:100|unique:supplier,kode_supplier,$supplier->id",
                'nama' => "required|string|max:100",
                'alamat' => "required|string",
                'telpon' => "required|string",
                'email' => "required|string",
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($supplier->id);
            $supplier->update([
                'kode_supplier'   => $request->kode_supplier,
                'nama'   => $request->nama,
                'alamat'          => $request->alamat,
                'telpon'          => $request->telpon,
                'email'           => $request->email,
            ]);
            if ($supplier) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('supplier.index');
            }

        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('supplier.index');
        }finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
       $supplier = Supplier::findOrFail($supplier->id);
        try{
            $supplier->delete();
            if ($supplier) {
                Alert::toast('Data berhasil dihapus', 'success');
                return redirect()->route('supplier.index');
            }else{
                Alert::toast('Data gagal dihapus', 'error');
                return redirect()->route('supplier.index');
            }
        }catch(Exception $e){
            Alert::toast('Data gagal dihapus, sudah berelasi', 'error');
            return redirect()->back();
        }
    }
}
