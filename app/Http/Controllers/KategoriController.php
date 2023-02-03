<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kategori_show')->only('index');
        $this->middleware('permission:kategori_create')->only('create', 'store');
        $this->middleware('permission:kategori_update')->only('edit', 'update');
        $this->middleware('permission:kategori_delete')->only('delete');
    }

    public function index()
    {
        if (request()->ajax()) {
            $query = Kategori::query();
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'kategori._action')
                ->toJson();
        }
        return view('kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.add');
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
                'nama_kategori' => "required|string|max:100|unique:kategori,nama_kategori",
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $kategori = Kategori::create([
            'nama_kategori'   => $request->nama_kategori
        ]);
        if ($kategori) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('kategori.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('kategori.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kategori' => "required|string|max:50|unique:kategori,nama_kategori," . $kategori->id,
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $kategori = kategori::findOrFail($kategori->id);
            $kategori->update([
                'nama_kategori'   => $request->nama_kategori
            ]);
            if ($kategori) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('kategori.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('kategori.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $kategori = Kategori::findOrFail($kategori->id);
        try{
            $kategori->delete();
            if ($kategori) {
                Alert::toast('Data berhasil dihapus', 'success');
                return redirect()->route('kategori.index');
            } else {
                Alert::toast('Data gagal dihapus', 'error');
                return redirect()->route('kategori.index');
            }
        }catch(Exception $e){
            Alert::toast('Data gagal dihapus, sudah berelasi', 'error');
            return redirect()->back();
        }
    }
}
