<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = ['invoice', 'customer_id', 'customer_alamat_id', 'tanggal_pembelian', 'sub_total', 'ongkir','diskon', 'grand_total','status','status_bayar','jasa_kirim','berat_total'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customer_alamat()
    {
        return $this->belongsTo(CustomerAlamat::class);
    }

    public const CREATED ="created";
    public const CONFIRMED ="confirmed";
    public const DELIVERED ="delivered";
    public const COMPLETED ="completed";
    public const CANCELLED ="cancelled";
    public const PAID ="paid";
    public const UNPAID ="unpaid";


    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}


