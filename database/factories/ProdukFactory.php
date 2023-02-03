<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kode_produk' => ucfirst($this->faker->word()),
            'nama' => $this->faker->name,
            'kategori_id' => 1,
            'unit_id' => 1,
            'slug' => ucfirst($this->faker->word()),
            'berat' => 1000,
            'deskripsi' => ucfirst($this->faker->word()),
            'harga' => $this->faker->numerify(),
            'qty' => $this->faker->numerify(),
        ];
    }
}
