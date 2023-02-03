<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'kode_supplier' => 'SUP-001',
            'nama' => 'PT ABC',
            'alamat' => 'Bogor',
            'email' => 'saepulramdan244@gmail.com',
            'telpon' => '083874731480'
        ]);
    }
}
