<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAlamat extends Model
{
    use HasFactory;
    protected $table = 'customer_alamat';
    protected $fillable = ['provinsi_id', 'kota_id','alamat_lengkap','customer_id'];
}
