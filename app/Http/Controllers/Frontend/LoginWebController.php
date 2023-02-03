<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LoginWebController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'telpon' => 'required|string',
                'email' => "required|email|unique:customer,email",
                'password' => 'required|string',
                'captcha' => 'required|captcha',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $customer = Customer::create([
            'nama' => $request->nama,
            'telpon' => $request->telpon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if ($customer) {
            Alert::success('Success', 'Registrasi Berhasil, Silahkan Login');
            return redirect()->route('dashboard');
        } else {
            Alert::error('Failed', 'Registrasi Gagal, Silahkan Coba Lagi');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => "required|email",
                'password' => 'required|string',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $email = $request->email;
        $password = $request->password;
        $data = Customer::where('email', $email)->first();
        if ($data) {
            if (Hash::check($password, $data->password)) {
                Session::put('id-customer', $data->id);
                Session::put('name-customer', $data->nama);
                Session::put('email-customer', $data->email);
                Session::put('login-customer', TRUE);
                Alert::success('Success', 'Login Berhasil');
                return redirect()->route('dashboard');
            } else {
                Alert::error('Failed', 'Email atau Password anda salah!');
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        } else {
            Alert::error('Failed', 'Email atau Password anda salah!');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function logout(Request $request)
    {
        \Cart::clear();
        $request->session()->forget('id-customer');
        $request->session()->forget('name-customer');
        $request->session()->forget('email-customer');
        $request->session()->forget('login-customer');
        Alert::success('Success', 'Anda telah logout');
        return redirect()->route('dashboard');
    }
}
