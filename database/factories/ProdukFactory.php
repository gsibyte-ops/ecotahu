<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Bikin kode unik format THU- diikuti 3 angka random
            'kode_produk' => 'THU-' . fake()->unique()->randomNumber(3, true),
            
            // Bikin nama produk unik, dijamin cuma huruf & spasi (aman dari regex)
            'nama_produk' => 'Tahu ' . ucfirst(fake()->unique()->word()), 
            
            // Harga random antara 5.000 sampai 50.000
            'harga' => fake()->numberBetween(5000, 50000),
            
            // Foto dikosongin dulu karena field ini nullable
            'foto' => null, 
        ];
    }
}