<?php

namespace Database\Seeders;

use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach ($daftarProvinsi as $provinceRow) {
            Provinsi::create([
                'provinsi_id' => $provinceRow['province_id'],
                'nama'        => $provinceRow['province'],
            ]);
            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
            foreach ($daftarKota as $cityRow) {
                KotaKabupaten::create([
                    'provinsi_id'   => $provinceRow['province_id'],
                    'kota_kabupaten_id'       => $cityRow['city_id'],
                    'nama'          => $cityRow['city_name'],
                ]);
            }
        }

    }
}
