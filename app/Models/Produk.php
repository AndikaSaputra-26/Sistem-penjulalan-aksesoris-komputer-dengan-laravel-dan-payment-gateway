<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'kode_produk',
        'kategori_id',
        'unit_id',
        'nama',
        'slug',
        'berat',
        'qty',
        'deskripsi',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function produk_photo()
    {
        return $this->hasMany(ProdukPhoto::class);
    }
}
