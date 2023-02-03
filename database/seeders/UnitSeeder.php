<?php

namespace Database\Seeders;

use App\Models\Unit;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'nama_unit' => 'PCS'
        ]);
        Unit::create([
            'nama_unit' => 'Roll'
        ]);
        Unit::create([
            'nama_unit' => 'Meter'
        ]);
    }
}
