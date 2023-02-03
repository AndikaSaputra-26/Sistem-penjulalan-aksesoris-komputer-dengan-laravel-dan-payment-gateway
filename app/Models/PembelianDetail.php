<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detail';
    protected $fillable = [
        'purchase_id',
        'produk_id',
        'harga',
        'qty',
        'sub_total'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}
