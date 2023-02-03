<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pembelian::create([
            'kode_pembelian' => 'P001',
            'supplier_id' => 1,
            'tanggal' => date('y-m-d'),
            'grand_total' => 1000000,
            'diskon' => 0,
            'total' => 1000000,
            'catatan' => 'Catatan',
            'status_bayar' => 'Belum Bayar',
        ]);
    }
}
