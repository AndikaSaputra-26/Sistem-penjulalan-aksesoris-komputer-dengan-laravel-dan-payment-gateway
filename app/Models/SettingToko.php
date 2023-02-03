<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingToko extends Model
{
    use HasFactory;
    protected $table = 'setting_toko';
    protected $fillable = ['nama_toko', 'logo', 'telpon', 'email', 'alamat', 'deskripsi'];
}
