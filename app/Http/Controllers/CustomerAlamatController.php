<?php

namespace App\Http\Controllers;

use App\Models\CustomerAlamat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerAlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $alamat = CustomerAlamat::create([
            'customer_id'   => $request->customer_id,
            'provinsi_id'   => $request->provinsi_id,
            'kota_id'   => $request->kota_id,
            'alamat_lengkap'   => $request->alamat_lengkap
        ]);
        if ($alamat) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerAlamat  $customerAlamat
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerAlamat $customerAlamat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerAlamat  $customerAlamat
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerAlamat $customerAlamat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerAlamat  $customerAlamat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $alamat = CustomerAlamat::findOrFail($id);
        $alamat->update([
            'customer_id'     => $request->customer_id,
            'provinsi_id'     => $request->provinsi_id,
            'kota_id'   => $request->kota_id,
            'alamat_lengkap'   => $request->alamat_lengkap
        ]);
        if ($alamat) {
            $params = array("success" => true);
        } else {
            $params = array("success" => false);
        }
        echo json_encode($params);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerAlamat  $customerAlamat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerAlamat = CustomerAlamat::findOrFail($id);
        $customerAlamat->delete();
        if ($customerAlamat) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->back();
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->back();
        }
    }
}
