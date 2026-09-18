<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk; // Pastikan Model Produk di-import

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Contoh insert 1 data fix/statis (Opsional, buat testing awal)
        Produk::create([
            'kode_produk' => 'THU-001',
            'nama_produk' => 'Tahu Putih Lembang',
            'harga' => 15000,
            'foto' => null
        ]);

        // 2. Generate 10 data dummy secara otomatis pakai Factory
        // Karena di Model Produk udah pakai HasFactory, ini bisa langsung jalan
        Produk::factory(10)->create(); 
    }
}