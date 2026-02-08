<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tarif;
use App\Models\Penggunaan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan Foreign Key Check biar bisa truncate (bersih-bersih)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Bersihkan tabel sebelum isi ulang
        DB::table('tagihan')->truncate();
        DB::table('penggunaan')->truncate();
        DB::table('users')->truncate();
        DB::table('tarif')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ---------------------------------------------------
        // 2. Insert Data TARIF
        // ---------------------------------------------------
        $tarif1 = Tarif::create(['daya' => '900 VA',  'tarifperkwh' => 1352]);
        $tarif2 = Tarif::create(['daya' => '1300 VA', 'tarifperkwh' => 1444]);
        $tarif3 = Tarif::create(['daya' => '2200 VA', 'tarifperkwh' => 1444]);
        
        $this->command->info('✅ Data Tarif berhasil dibuat!');

        // ---------------------------------------------------
        // 3. Insert User ADMIN
        // ---------------------------------------------------
        User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@pascabayar.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        $this->command->info('✅ Akun Admin berhasil dibuat! (admin@pascabayar.com / admin123)');

        // ---------------------------------------------------
        // 4. Insert User PELANGGAN
        // ---------------------------------------------------
        $pelanggan1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('budi123'),
            'role' => 'pelanggan',
            'nomor_kwh' => '1122334401',
            'alamat' => 'Jl. Mawar No. 10, Jakarta Selatan',
            'id_tarif' => $tarif1->id_tarif, // Pakai Daya 900 VA
        ]);

        $pelanggan2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('siti123'),
            'role' => 'pelanggan',
            'nomor_kwh' => '5566778802',
            'alamat' => 'Jl. Melati No. 5, Bandung',
            'id_tarif' => $tarif2->id_tarif, // Pakai Daya 1300 VA
        ]);

        $this->command->info('✅ Akun Pelanggan berhasil dibuat! (budi@gmail.com / budi123)');

        // ---------------------------------------------------
        // 5. Insert Data PENGGUNAAN (Trigger Test)
        // ---------------------------------------------------
        // Kita input penggunaan, nanti Trigger Database OTOMATIS bikin tagihannya.
        
        // Tagihan Budi Bulan Januari
        Penggunaan::create([
            'id_pelanggan' => $pelanggan1->id,
            'bulan' => 'Januari',
            'tahun' => '2024',
            'meter_awal' => 1000,
            'meter_akhir' => 1150, // Pakai 150 kWh
        ]);

        // Tagihan Budi Bulan Februari
        Penggunaan::create([
            'id_pelanggan' => $pelanggan1->id,
            'bulan' => 'Februari',
            'tahun' => '2024',
            'meter_awal' => 1150,
            'meter_akhir' => 1300, // Pakai 150 kWh lagi
        ]);

        // Tagihan Siti Bulan Januari
        Penggunaan::create([
            'id_pelanggan' => $pelanggan2->id,
            'bulan' => 'Januari',
            'tahun' => '2024',
            'meter_awal' => 5000,
            'meter_akhir' => 5250, // Pakai 250 kWh
        ]);

        $this->command->info('✅ Data Penggunaan berhasil diinput (Trigger Tagihan otomatis jalan!)');
    }
}