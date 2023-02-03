<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerAlamat;

class SettingAkunController extends Controller
{
    public function index()
    {
        $custommer = Customer::findOrFail(Session::get('id-customer'));
        return view('frontend.setting-akun', [
            'customer' => $custommer
        ]);
    }

    public function daftarAlamat()
    {
        $customer_id =Session::get('id-customer');
        $alamat = DB::table('customer_alamat')
            ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
            ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
            ->select('customer_alamat.*', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota')
            ->where('customer_alamat.customer_id', '=', $customer_id)
            ->get();
        $provinsi = Provinsi::pluck('nama', 'provinsi_id');
        return view('frontend.daftar-alamat', [
            'provinsi' => $provinsi,
            'customer_id' => $customer_id,
            'alamat' => $alamat
        ]);
    }

    public function store_alamat(Request $request)
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

    public function update_alamat(Request $request, $id)
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

    public function destroy_alamat($id)
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

    public function getAlamat($id){
        $alamat = DB::table('customer_alamat')
        ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
        ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
        ->select('customer_alamat.*', 'provinsis.nama as nama_provinsi','provinsis.id as provinsi_id', 'kota_kabupatens.nama as nama_kota','kota_kabupatens.kota_kabupaten_id as kota_id')
        ->where('customer_alamat.id', '=', $id)
        ->first();
        echo json_encode($alamat);

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(

            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|string|max:100',
                'telpon' => 'required|string',
                'email' => 'required|string',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $customer = Customer::findOrFail($id);
            if ($request->password == "" || $request->password == null) {
                $customer->update([
                    'nama' => $request->nama,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'telpon' => $request->telpon,
                    'email' => $request->email,
                ]);
            } else {
                $customer->update([
                    'password'   => Hash::make($request->password),
                    'nama' => $request->nama,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'telpon' => $request->telpon,
                    'email' => $request->email,
                ]);
            }


            if ($customer) {
                Alert::success('Success', 'Data berhasil diupdate');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Failed', 'Data gagal diupdate');
            return redirect()->back();
        } finally {
            DB::commit();
        }
    }
}
