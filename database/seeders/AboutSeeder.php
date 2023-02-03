<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'deskripsi' => 'Evdigi.id mengembangkan aplikasi dengan penuh dedikasi. Kami selalu siap memberikan solusi untuk permasalahan dan memenuhi kebutuhan Anda. Kami menawarkan solusi bagi anda yang ingin membangun software aplikasi berbasis web untuk kebutuhan bisnis, perkantoran, institusi, organisasi dan pemerintahan. Kami juga menyediakan paket website yang sudah jadi sesuai kebutuhan Anda dengan harga terjangkau.',
            'logo' => '',
            'nama_author' => 'Muhammad Saeful Ramdan',
            'photo_author' => '',
            'link_github' => 'https://github.com/msramdan',
            'quotes_author' => 'Orang-orang yang berhenti belajar akan menjadi pemilik masa lalu. Orang-orang yang masih terus belajar, akan menjadi pemilik masa depan',
        ]);
    }
}
