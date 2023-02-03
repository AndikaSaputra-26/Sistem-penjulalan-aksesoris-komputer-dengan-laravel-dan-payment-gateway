<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $fillable = [
        'kode_pembelian',
        'supplier_id',
        'tanggal',
        'grand_total',
        'total',
        'status_bayar',
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_pembelian()
    {
        return $this->hasMany(PembelianDetail::class);
    }

}
