<?php

namespace Database\Seeders;

use App\Models\SettingToko;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingToko::create([
            'nama_toko' => 'IP Komputer',
            'logo' => '',
            'telpon' => '087703597106',
            'email' => 'ipkomputer01@gmail.com',
            'alamat' => 'Jl. pandhawa gang nakula no.02 karangmloko, RT.01/RW.17, Tegal Weru, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta ',
            'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
        ]);
    }
}
