<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaraBelanjController extends Controller
{
    public function index()
    {
        $caraBelanja = \App\Models\CaraBelanja::all();
        return view('frontend.cara-belanja', [
            'model' => $caraBelanja
        ]);
    }
}
