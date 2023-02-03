<?php

namespace App\Http\Controllers;

use App\Models\CaraBelanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CaraBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $query = CaraBelanja::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'cara-belanja._action')
                ->toJson();
        }
        return view('cara-belanja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cara-belanja.add');
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
                'title' => 'required|string|max:100',
                'deskripsi' => 'required|string',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $caraBelanja = CaraBelanja::create([
            'title'   => $request->title,
            'deskripsi'   => $request->deskripsi,
        ]);
        if ($caraBelanja) {
            Alert::toast('Data berhasil ditambahkan', 'success');
            return redirect()->route('cara-belanja.index');
        } else {
            Alert::toast('Data gagal ditambahkan', 'error');
            return redirect()->route('cara-belanja.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaraBelanja  $caraBelanja
     * @return \Illuminate\Http\Response
     */
    public function show(CaraBelanja $caraBelanja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaraBelanja  $caraBelanja
     * @return \Illuminate\Http\Response
     */
    public function edit(CaraBelanja $caraBelanja)
    {
        return view('cara-belanja.edit', compact('caraBelanja'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaraBelanja  $caraBelanja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaraBelanja $caraBelanja)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:100',
                'deskripsi' => 'required|string',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $caraBelanja = CaraBelanja::findOrFail($caraBelanja->id);
            $caraBelanja->update([
                'title'   => $request->title,
                'deskripsi'   => $request->deskripsi,
            ]);
            if ($caraBelanja) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('cara-belanja.index');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('cara-belanja.index');
        }finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from stor.
     *
     * @param  \App\Models\CaraBelanja  $caraBelanja
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaraBelanja $caraBelanja)
    {
        $caraBelanja = CaraBelanja::findOrFail($caraBelanja->id);
        $caraBelanja->delete();
        if ($caraBelanja) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('cara-belanja.index');
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->route('cara-belanja.index');
        }

    }
}
