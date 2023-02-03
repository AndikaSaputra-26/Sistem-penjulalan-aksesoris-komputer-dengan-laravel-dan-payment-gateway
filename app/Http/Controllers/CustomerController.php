<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAlamat;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:customer_show')->only('index');
        $this->middleware('permission:customer_create')->only('create', 'store');
        $this->middleware('permission:customer_update')->only('edit', 'update');
        $this->middleware('permission:customer_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Customer::query();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'customer._action')
                ->toJson();
        }
        return view('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.add');
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
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|string|max:100',
                'telpon' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $customer = Customer::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telpon' => $request->telpon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if ($customer) {
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('customer.index');
        } else {
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('customer.index');
        }
    }

    public function address($id)
    {
        $alamat = DB::table('customer_alamat')
            ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
            ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
            ->select('customer_alamat.*', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota')
            ->where('customer_alamat.customer_id', '=', $id)
            ->get();
        $provinsi = Provinsi::pluck('nama', 'provinsi_id');
        return view('customer.address', [
            'provinsi' => $provinsi,
            'customer_id' => $id,
            'alamat' => $alamat
        ]);
    }

    public function getCities($id)
    {
        $kotaKabupaten = DB::table('kota_kabupatens')
            ->where('provinsi_id', '=', $id)
            ->get();
        $output = '';
        $output .= '<select class="form-control kota-asal" id="kota_id" name="kota_id"><option value="">-- Pilih --</option>';
        foreach ($kotaKabupaten as $row) {
            $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
        }
        $output .= '</select>';
        echo $output;
    }


    public function getDetailItem($id)
    {
        $data = DB::table('transaksi_detail')
        ->join('produk', 'produk.id', '=', 'transaksi_detail.produk_id')
        ->select('transaksi_detail.*', 'produk.kode_produk','produk.nama')
            ->where('transaksi_id', '=', $id)
            ->get();
        $output = '';
        $output .= '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($data as $row) {
            // $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
            $output .= '<tr>
            <td>'.$row->kode_produk.'</td>
            <td>'.$row->nama.'</td>
            <td>'.$row->qty.'</td>
            <td>'.$row->harga.'</td>
            <td>'.$row->sub_total.'</td>
        </tr>';
        }
        $output .= '</tbody>
        </table>';
        echo $output;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($request->all());
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
            $customer = Customer::findOrFail($customer->id);

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
                    'nama' => $request->nama,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'telpon' => $request->telpon,
                    'email' => $request->email,
                    'password'   => bcrypt($request->password),
                ]);
            }



            if ($customer) {
                Alert::toast('Data berhasil diupdate', 'success');
                return redirect()->route('customer.index');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('customer.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        try{
            $customer->delete();
            if ($customer) {
                Alert::toast('Data berhasil dihapus', 'success');
                return redirect()->route('customer.index');
            } else {
                Alert::toast('Data gagal dihapus', 'error');
                return redirect()->route('customer.index');
            }
        }catch(Exception $e){
            Alert::toast('Data gagal dihapus, sudah berelasi', 'error');
            return redirect()->back();
        }
    }
}
