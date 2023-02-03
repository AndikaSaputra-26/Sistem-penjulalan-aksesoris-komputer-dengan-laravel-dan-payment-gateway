<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'nama' => 'Ramdan',
            'tanggal_lahir' => date('d-m-y'),
            'jenis_kelamin' => 'Laki Laki',
            'email' => 'saepulramdan244@gmail.com',
            'telpon' => '083874731480',
            'password' => bcrypt('customer')
        ]);
    }
}
