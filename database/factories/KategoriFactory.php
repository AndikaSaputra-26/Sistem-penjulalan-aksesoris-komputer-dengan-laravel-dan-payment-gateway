<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;
    public function definition()
    {
        return [
            'nama_kategori' => $this->faker->name
        ];
    }
}
