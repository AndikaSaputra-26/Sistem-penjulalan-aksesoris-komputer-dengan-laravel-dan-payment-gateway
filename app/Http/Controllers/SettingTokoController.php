<?php

namespace App\Http\Controllers;

use App\Models\SettingToko;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingTokoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:toko_show')->only('index');
        $this->middleware('permission:toko_update')->only('update');
    }

    public function index()
    {
        $setting_toko = SettingToko::all()->first();
        return view('setting-toko.index', ['setting_toko' => $setting_toko]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nama_toko' => 'required|string',
                'alamat' => 'required|string',
                'telpon' => 'required|string',
                'email' => 'required|string',
                // 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();

        try {
            $setting_toko = SettingToko::findOrFail($id);
            if ($request->file('logo') == "") {
                $setting_toko->update([
                    'nama_toko' => $request->nama_toko,
                    'alamat' => $request->alamat,
                    'telpon' => $request->telpon,
                    'email' => $request->email,
                    'deskripsi' => $request->deskripsi,
                ]);
            } else {
                //hapus old logo
                Storage::disk('local')->delete('public/logo/' . $setting_toko->logo);
                //upload new logo
                $logo = $request->file('logo');
                $logo->storeAs('public/logo', $logo->hashName());
                $setting_toko->update([
                    'logo'     => $logo->hashName(),
                    'nama_toko' => $request->nama_toko,
                    'alamat' => $request->alamat,
                    'telpon' => $request->telpon,
                    'email' => $request->email,
                    'deskripsi' => $request->deskripsi,
                ]);
            }
            if ($setting_toko) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('setting-toko.index');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('setting-toko.index');
        } finally {
            DB::commit();
        }
    }
}
