<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:unit_show')->only('index');
        $this->middleware('permission:unit_create')->only('create', 'store');
        $this->middleware('permission:unit_update')->only('edit', 'update');
        $this->middleware('permission:unit_delete')->only('delete');
    }
    public function index()
    {
        if (request()->ajax()) {
            $query = DB::table('units');
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'unit._action')
                ->toJson();
        }
        return view('unit.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.add');
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
                'nama_unit' => "required|string|max:50|unique:units,nama_unit",
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $unit = Unit::create([
            'nama_unit'   => $request->nama_unit
        ]);
        if ($unit) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('unit.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('unit.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_unit' => "required|string|max:50|unique:units,nama_unit," . $unit->id,
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $unit = Unit::findOrFail($unit->id);
            $unit->update([
                'nama_unit'   => $request->nama_unit
            ]);
            if ($unit) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('unit.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('unit.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit = Unit::findOrFail($unit->id);
        try{
            $unit->delete();
            if ($unit) {
                Alert::toast('Data berhasil dihapus', 'success');
                return redirect()->route('unit.index');
            } else {
                Alert::toast('Data gagal dihapus', 'error');
                return redirect()->route('unit.index');
            }
        }catch(Exception $e){
            Alert::toast('Data gagal dihapus, sudah berelasi', 'error');
            return redirect()->back();
        }
    }
}
