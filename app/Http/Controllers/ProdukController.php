<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;


class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:produk_show')->only('index');
        $this->middleware('permission:produk_create')->only('create', 'store');
        $this->middleware('permission:produk_update')->only('edit', 'update');
        $this->middleware('permission:produk_delete')->only('delete');
    }
    public function index()
    {
        if (request()->ajax()) {
            $query = Produk::with('kategori:id,nama_kategori', 'unit:id,nama_unit');
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->kategori->nama_kategori;
                })
                ->addColumn('unit', function ($row) {
                    return $row->unit->nama_unit;
                })
                ->addColumn('action', 'produk._action')
                ->toJson();
        }
        return view('produk.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        $unit = Unit::all();
        return view('produk.add', [
            'kategori_id' => $kategori,
            'unit_id' => $unit
        ]);
    }

    public function getItem(int $produk_id)
    {
        abort_if(!request()->ajax(), 403);
        $produk = DB::table('produk')
            ->join('units', 'units.id', '=', 'produk.unit_id')
            ->select('produk.*', 'units.*')
            ->where('produk.id', '=', $produk_id)
            ->get();
        return response()->json(['data' => $produk ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'kode_produk' => "required|string|unique:produk,kode_produk",
                'nama' => "required|string|unique:produk,nama",
                'deskripsi' => "required|string",
                'harga' => "required|string",
                'kategori_id' => 'required|exists:kategori,id',
                'unit_id' => 'required|exists:units,id',
                'photo' => "required",
                'berat' => "required"
            ],
            [],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $slug = Str::slug($request->nama, '-');
        $produk = Produk::create([
            'kode_produk'   => $request->kode_produk,
            'nama'   => $request->nama,
            'slug'   => $slug,
            'deskripsi'   => $request->deskripsi,
            'harga'   => $request->harga,
            'kategori_id'   => $request->kategori_id,
            'unit_id'   => $request->unit_id,
            'berat'   => $request->berat,
            'qty'   => 0
        ]);
        // upload photo
        if ($produk) {
            $insertedId = $produk->id;
            $files = $request->file('photo');
            if ($request->hasFile('photo')) {
                foreach ($files as $file) {
                    $name = $file->hashName();
                    $file->storeAs('public/produk', $name);
                    DB::table('produk_photo')->insert([
                        'produk_id' => $insertedId,
                        'photo' => $name,
                    ]);
                }
            }
        }

        if ($produk) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('produk.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('produk.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $photo = DB::table('produk_photo')
            ->where('produk_id', '=', $produk->id)
            ->get();
        $kategori = Kategori::all();
        $unit = Unit::all();
        return view('produk.edit', [
            'produk' => $produk,
            'photo' => $photo,
            'unit_id' => $unit,
            'kategori_id' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_produk' => "required|string|unique:produk,kode_produk," . $produk->id,
                'nama' => "required|string|unique:produk,nama," . $produk->id,
                'deskripsi' => "required|string",
                'harga' => "required|string",
                'kategori_id' => 'required|exists:kategori,id',
                'unit_id' => 'required|exists:units,id',
                'berat' => 'required',
            ],
            [],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }




        DB::beginTransaction();
        try {

            // hapus photo produk dan unlink photo
            if ($request->id_asal == null) {
                $tidak_terhapus = [];
            } else {
                $tidak_terhapus = $request->id_asal;
            }
            $unlink_db_gambar = DB::table('produk_photo')
                ->where('produk_id', '=', $produk->id)
                ->whereNotIn('id', $tidak_terhapus)
                ->get();
            foreach ($unlink_db_gambar as $row) {
                DB::table('produk_photo')->where('id', $row->id)->delete();
                Storage::disk('local')->delete('public/produk/' . $row->photo);
            }


            $produk = produk::findOrFail($produk->id);

            $slug = Str::slug($request->nama, '-');
            $produk->update([
                'kode_produk'   => $request->kode_produk,
                'nama'   => $request->nama,
                'slug'   => $slug,
                'deskripsi'   => $request->deskripsi,
                'harga'   => $request->harga,
                'berat'   => $request->berat,
                'kategori_id'   => $request->kategori_id,
                'unit_id'   => $request->unit_id,
            ]);

            if ($produk) {
                $insertedId = $produk->id;
                $files = $request->file('photo');
                if ($request->hasFile('photo')) {
                    foreach ($files as $file) {
                        $name = $file->hashName();
                        $file->storeAs('public/produk', $name);
                        DB::table('produk_photo')->insert([
                            'produk_id' => $insertedId,
                            'photo' => $name,
                        ]);
                    }
                }
            }

            if ($produk) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('produk.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('produk.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk = Produk::findOrFail($produk->id);
        try{ 
             $produk_photo = DB::table('produk_photo')
                ->where('produk_id', '=', $produk->id)
                ->get();
    
            foreach ($produk_photo as $row) {
                Storage::disk('local')->delete('public/produk/' . $row->photo);
            }
            
            $produk->delete();
            if ($produk) {
                Alert::toast('Data berhasil dihapus', 'success');
                return redirect()->route('produk.index');
            } else {
                Alert::toast('Data gagal dihapus', 'error');
                return redirect()->route('produk.index');
            }
        }catch(Exception $e){
            Alert::toast('Data gagal dihapus, sudah berelasi', 'error');
            return redirect()->back();
        }
            
            
       
        
        
    }

    public function GetGambarProduk($id)
    {

        $data = DB::table('produk_photo')
            ->where('produk_id', '=', $id)
            ->get();
        $output = '';
        $output .= '<div class="carousel-inner">';
        $no = 1;
        foreach ($data as $row) {
            $output .= ' <div class="carousel-item ' . $this->active($no) . '"><img class="img-size"
            src="' . Storage::url('public/produk/' . $row->photo) . '" />
            </div>
          ';
            $no++;
        }
        $output .= '</div>';
        echo $output;
    }
    public function active($no)
    {
        if ($no == 1) {
            return "active";
        }
    }
}
