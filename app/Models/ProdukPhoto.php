<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPhoto extends Model
{
    use HasFactory;
    protected $table = 'produk_photo';
    protected $fillable = ['produk_id', 'photo'];


    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
