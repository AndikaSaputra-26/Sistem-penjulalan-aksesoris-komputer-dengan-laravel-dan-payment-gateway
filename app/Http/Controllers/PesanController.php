<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:pesan_show')->only('index');
        $this->middleware('permission:pesan_create')->only('create', 'store');
        $this->middleware('permission:pesan_update')->only('edit', 'update');
        $this->middleware('permission:pesan_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Pesan::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('is_read', function ($row) {
                    if ($row->is_read == 0) {
                        // $status = '<span class="badge badge-success">Terbaca</span>';
                        $status = 'Belum Terbaca';
                    } else {
                        // $status = '<span class="badge badge-danger">Belum Terbaca</span>';
                        $status = 'Terbaca';
                    }
                    return $status;
                })
                ->addColumn('action', 'pesan._action')
                ->toJson();
        }
        return view('pesan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pesan.add');
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
                'nama' => 'required|string|max:100',
                'judul' => 'required|string|max:100',
                'telpon' => 'required|string',
                'deskripsi' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $pesan = Pesan::create([
            'nama'   => $request->nama,
            'judul'   => $request->judul,
            'telpon'   => $request->telpon,
            'deskripsi'   => $request->deskripsi,
        ]);
        if ($pesan) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('pesan.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('pesan.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function show(Pesan $pesan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesan $pesan)
    {
        return view('pesan.edit', compact('pesan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesan $pesan)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'judul' => 'required|string|max:100',
                'telpon' => 'required|string',
                'deskripsi' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $pesan = Pesan::findOrFail($pesan->id);
            $pesan->update([
                'nama'   => $request->nama,
                'judul'   => $request->judul,
                'telpon'   => $request->telpon,
                'deskripsi'   => $request->deskripsi,
            ]);
            if ($pesan) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('pesan.index');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('pesan.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesan $pesan)
    {
        $pesan = Pesan::findOrFail($pesan->id);
        $pesan->delete();
        if ($pesan) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('pesan.index');
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->route('pesan.index');
        }
    }

    public function updateStatus($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->is_read = 1;
        $pesan->save();
        if ($pesan) {
            Alert::toast('Status terbaca berhasil diupdate', 'success');
            return redirect()->route('pesan.index');
        } else {
            Alert::toast('Status terbaca gagal diupdate', 'error');
            return redirect()->route('pesan.index');
        }
    }
}
