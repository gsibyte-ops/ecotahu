<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckEcotahuStatus extends Command
{
    /**
     * Nama dan argumen perintah yang dipanggil di terminal.
     */
    protected $signature = 'ecotahu:operasional {jam?}';

    /**
     * Deskripsi perintah saat dilihat melalui 'php artisan list'.
     */
    protected $description = 'Mengecek status operasional Pabrik Tahu dan Layanan Pick-up EcoTahu';

    /**
     * Logika utama yang dijalankan oleh perintah.
     */
    public function handle()
    {
        // 1. Meminta input nama Admin/Petugas
        $namaPetugas = $this->ask('Masukkan nama Admin/Petugas: ');
        
        // 2. Mengambil argumen jam, jika tidak diisi maka default ke jam 9 pagi
        $jam = $this->argument('jam') ?? 9;
        
        $this->info("=== SISTEM MONITORING OPERASIONAL ECOTAHU ===");
        
        // 3. Pengecekan status pabrik (Buka dari jam 07:00 sampai 17:00)
        if ($jam >= 7 && $jam <= 17) {
            // Menampilkan status BUKA
            $this->info("Halo {$namaPetugas}, Status Pabrik & Layanan Pick-up pada jam {$jam}:00 WIB adalah: BUKA");
            $this->comment("Silakan pantau pesanan dan limbah yang masuk di dashboard.");
        } else {
            // Menampilkan status TUTUP
            $this->error("Halo {$namaPetugas}, Status Pabrik & Layanan Pick-up pada jam {$jam}:00 WIB adalah: TUTUP");
            $this->warn("Akses transaksi dan pick-up dinonaktifkan sementara hingga besok pagi.");
        }
    }
}