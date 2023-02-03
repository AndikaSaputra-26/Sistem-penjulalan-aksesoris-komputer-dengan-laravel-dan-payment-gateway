<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class CartController extends Controller
{
    public function cartList()
    {
        if (Session::get('login-customer')) {
            $cartItems = \Cart::getContent();
            // dd($cartItems);
            $provinsi = Provinsi::pluck('nama', 'provinsi_id');
            $customer_id = Session::get('id-customer');
            $alamat = DB::table('customer_alamat')
                ->join('provinsis', 'provinsis.id', '=', 'customer_alamat.provinsi_id')
                ->join('kota_kabupatens', 'kota_kabupatens.id', '=', 'customer_alamat.kota_id')
                ->select('customer_alamat.*', 'provinsis.nama as nama_provinsi', 'kota_kabupatens.nama as nama_kota')
                ->where('customer_alamat.customer_id', '=', $customer_id)
                ->get();

            return view('frontend.cart', [
                'cartItems' => $cartItems,
                'provinsi' => $provinsi,
                'alamat' => $alamat
            ]);
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }

    public function addToCart(Request $request)
    {
        if (Session::get('login-customer')) {
            \Cart::add([
                'id' => $request->id,
                'name' => $request->nama,
                'price' => $request->harga,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'image' => $request->photo,
                )
            ]);
            return redirect()->route('cart.list');
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }

    public function updateCart(Request $request)
    {
        // dd($request->all());
        if (Session::get('login-customer')) {
            \Cart::update(
                $request->id,
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->quantity
                    ],
                ]
            );
            return redirect()->route('cart.list');
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }

    public function removeCart(Request $request)
    {
        if (Session::get('login-customer')) {
            \Cart::remove($request->id);
            return redirect()->route('cart.list');
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }

    public function clearAllCart()
    {
        if (Session::get('login-customer')) {
            \Cart::clear();
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }


    public function doCheckout(Request $request)
    {
        if (\Cart::isEmpty()) {
            Alert::error('Failed', 'Cart belanja masih kosong');
            return redirect()->route('dashboard');
        }



        DB::transaction(function () use ($request) {
            $table = "transaksi";
            $primary = "invoice";
            $prefix = "INV-";
            $date = date('dmy');
            $q = DB::table($table)->select(DB::raw('MAX(RIGHT(' . $primary . ',5)) as kd_max'));
            $prx = $prefix . $date;
            if ($q->count() > 0) {
                foreach ($q->get() as $k) {
                    $tmp = ((int)$k->kd_max) + 1;
                    $kd = $prx.'-'. sprintf("%06s", $tmp);
                }
            } else {
                $kd = $prx . '-' . "000001";
            }

            $orderParam = [
                'invoice' => $kd,
                'customer_id' => $request->customer_id_pesan,
                'customer_alamat_id' => $request->alamat_customer,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'sub_total' => $request->sub_total,
                'ongkir' => $request->ongkir,
                'diskon' => 0,
                'grand_total' => $request->grand_total,
                'catatan' => $request->catatan,
                'status' => Transaksi::CREATED,
                'status_bayar' => Transaksi::UNPAID,
                'jasa_kirim' => $request->jasa_kirim,
                'berat_total' => $request->berat_total,

            ];

            $penjualan = Transaksi::create($orderParam);


            $cartItems = \Cart::getContent();
            if ($penjualan) {
                foreach ($cartItems as $data) {
                    $detailItem = [
                        'transaksi_id' => $penjualan->id,
                        'produk_id' => $data->id,
                        'harga' => $data->price,
                        'qty' => $data->quantity,
                        'sub_total' => $data->price * $data->quantity,
                    ];
                    // tambah detail
                    $detailPenjualan = TransaksiDetail::create($detailItem);
                }
                \Cart::clear();
            }
            // dd($cartItems);

            $this->initPaymentGateway();
            $dataCustomer = Customer::findOrFail($penjualan->customer_id);
            $customer = [
                'first_name' => $dataCustomer->nama,
                'email' => $dataCustomer->email,
                'phone' => $dataCustomer->telpon,
            ];
            $param = [
                'enable_payments' => \App\Models\Payment::PAYMENT_CHANNELS,
                'transaction_details' => [
                    'order_id' => $penjualan->invoice,
                    'gross_amount' => $penjualan->grand_total
                ],
                'customer_details' => $customer,
                'expiry' => [
                    'start_time' => date('Y-m-d H:i:s T'),
                    'unit' => \App\Models\Payment::EXPIRY_UNIT,
                    'duration' => \App\Models\Payment::EXPIRY_DURATION,
                ]
            ];
            $snap = \Midtrans\Snap::createTransaction($param);
            // dd($snap);

            if ($snap->token) {
                $penjualan->payment_token = $snap->token;
                $penjualan->payment_url = $snap->redirect_url;
                $penjualan->save();
            }

            echo $snap->redirect_url;
        });
    }

    private function _generatePaymentToken($penjualan)
    {
        $this->initPaymentGateway();
        $dataCustomer = Customer::findOrFail($penjualan->customer_id);
        $customer = [
            'first_name' => $dataCustomer->nama,
            'email' => $dataCustomer->email,
            'phone' => $dataCustomer->telpon,
        ];
        $param = [
            'enable_payments' => \App\Models\Payment::PAYMENT_CHANNELS,
            'transaction_details' => [
                'order_id' => $penjualan->invoice,
                'gross_amount' => $penjualan->grand_total
            ],
            'customer_details' => $customer,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
                'unit' => \App\Models\Payment::EXPIRY_UNIT,
                'duration' => \App\Models\Payment::EXPIRY_DURATION,
            ]
        ];
        $snap = \Midtrans\Snap::createTransaction($param);
        if ($snap->token) {
            $penjualan->payment_token = $snap->token;
            $penjualan->payment_url = $snap->redirect_url;
            $penjualan->save();
        }
    }
}
