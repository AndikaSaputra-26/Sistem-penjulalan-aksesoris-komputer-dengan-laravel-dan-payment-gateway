<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class MailController extends Controller
{

    public function index(Request $request)
    {
        // dd($request->email);
        // Alert::success('Success', 'Link reset password berhasil di kirim');
        $user = DB::table('customer')->where('email', '=', $request->email)
            ->first();

        //Check if the user exists
        if ($user == null) {
            Alert::error('Failed', 'Email tidak terfdatar');
            return redirect()->back();
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();
        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            Alert::success('Success', 'Link reset password berhasil dikirim');
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Link reset password gagal dikirim');
            return redirect()->back();
        }
    }

    private function sendResetEmail($email, $token)
    {
        $user = DB::table('customer')->where('email', $email)->select('nama', 'email')->first();
        $link = url('/') . '/password/reset/' . $token . '/' . urlencode($user->email);

        try {
            $details = [
                'title' => 'Mail from IP-Komputer',
                'body' => 'Klik link untuk reset password : ' . $link
            ];

            Mail::to($email)->send(new \App\Mail\MyTestMail($details));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function hal_reset($token, $email)
    {
        return view('frontend.reset', [
            'token' => $token,
            'email' => $email,

        ]);
    }

    public function update_password_customer(Request $request)
    {

        $customer = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

        if($customer){
            DB::table('customer')
            ->where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);
            DB::table('password_resets')->where('email', '=', $request->email )->delete();
            Alert::success('Success', 'Password berhasil di update');
            return redirect()->route('dashboard');
        }

    }
}
