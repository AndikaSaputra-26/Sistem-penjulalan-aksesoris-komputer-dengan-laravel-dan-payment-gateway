<?php

namespace Database\Seeders;

use App\Models\CustomerAlamat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerAlamat::create([
            'customer_id' =>1,
            'provinsi_id' =>9,
            'kota_id' => 70,
            'alamat_lengkap' => 'Perumahan sai residance'
        ]);
    }
}
