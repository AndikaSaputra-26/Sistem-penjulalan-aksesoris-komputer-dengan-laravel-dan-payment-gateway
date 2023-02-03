<?php

namespace Database\Seeders;

use App\Models\Pesan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pesan::create([
            'nama' => 'Ramdan',
            'judul' => "Tanya Sesuatu",
            'telpon' => '083874731480',
            'email' => 'saepulramdan244@gmail.com',
            'deskripsi' => 'Tanya',
            'is_read' => 0
        ]);
    }
}
