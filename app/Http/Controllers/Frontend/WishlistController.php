<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = \Session::get('id-customer');
        $data = DB::table('wishlist')
            ->join('produk', 'produk.id', '=', 'wishlist.produk_id')
            ->select('wishlist.*', 'produk.nama', 'produk.kode_produk', 'produk.harga', 'produk.slug')
            ->where('wishlist.customer_id', '=', $customer_id)
            ->get();
        return view('frontend.wishlist', [
            'data' => $data
        ]);
    }

    public function store($id)
    {
        if (Session::get('login-customer')) {
            $customer_id = \Session::get('id-customer');
            $wishlist = Wishlist::where('customer_id', $customer_id)
                ->where('produk_id', $id)->first();

            if ($wishlist) {
                Alert::toast('Produk sudah ada dalam wishlist', 'info');
                return redirect()->back();
            } else {
                $data = Wishlist::create([
                    'produk_id'   => $id,
                    'customer_id'   => $customer_id
                ]);
                if ($data) {
                    Alert::toast('Berhasil menambahakn ke wishlist', 'success');
                    return redirect()->back();
                } else {
                    Alert::toast('Gagal menambahakn ke wishlist', 'error');
                    return redirect()->back();
                }
            }
        } else {
            Alert::error('Failed', 'Silahkan login terlebih dahulu');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {

        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();
        if ($wishlist) {
            Alert::toast('Data berhasil dihapus dari wishlist', 'success');
            return redirect()->route('wishlist.index');
        } else {
            Alert::toast('Data gagal dihapus dari wishlist', 'error');
            return redirect()->route('wishlist.index');
        }
    }
}
