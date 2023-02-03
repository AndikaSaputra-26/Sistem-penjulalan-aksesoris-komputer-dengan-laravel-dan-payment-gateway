<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KontakController extends Controller
{
    public function index(Request $request)
    {
        $setting_toko = \App\Models\SettingToko::first();
        return view('frontend.kontak',[
            'setting_toko' => $setting_toko
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'judul' => 'required|string|max:100',
                'email' => 'required|string',
                'deskripsi' => 'required|string',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $pesan = Pesan::create([
            'nama'   => $request->nama,
            'judul'   => $request->judul,
            'email'   => $request->email,
            'deskripsi'   => $request->deskripsi,
        ]);
        if ($pesan) {
            return redirect()->route('kontak')->with('success', 'Terima kasih telah menghubungi kami. Kami akan segera menghubungi anda.');
        }
    }
}
