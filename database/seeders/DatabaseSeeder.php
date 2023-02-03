<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            RoleSeeder::class,
            AboutSeeder::class,
            UnitSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            SettingTokoSeeder::class,
            SupplierSeeder::class,
            LocationsSeeder::class,
            CustomerSeeder::class,
            PembelianSeeder::class,
            CustomerAlamatSeeder::class,
            PesanSeeder::class,
        ]);
    }
}
