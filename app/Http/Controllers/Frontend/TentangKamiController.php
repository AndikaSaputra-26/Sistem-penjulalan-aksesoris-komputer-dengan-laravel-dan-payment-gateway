<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SettingToko;
use Illuminate\Http\Request;

class TentangKamiController extends Controller
{
   public function index()
   {
    $setting_toko = SettingToko::all()->first();
      return view('frontend.tentang-kami',['setting_toko' => $setting_toko]);
   }
}
