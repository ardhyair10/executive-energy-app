<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Tarif
        Schema::create('tarif', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->string('daya');
            $table->decimal('tarifperkwh', 10, 2);
            $table->timestamps();
        });

        // 2. Tabel Users (Gabungan Admin & Pelanggan untuk Login Breeze)
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Ini jadi id_user / id_pelanggan
            $table->string('name'); // Nama Admin / Nama Pelanggan
            $table->string('email')->unique(); // Username/Email login
            $table->string('password');
            $table->enum('role', ['admin', 'pelanggan'])->default('pelanggan');
            
            // Kolom Khusus Pelanggan (Nullable karena Admin gak punya ini)
            $table->string('nomor_kwh')->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('id_tarif')->nullable();
            $table->foreign('id_tarif')->references('id_tarif')->on('tarif');
            
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. Tabel Penggunaan
        Schema::create('penggunaan', function (Blueprint $table) {
            $table->id('id_penggunaan');
            $table->unsignedBigInteger('id_pelanggan'); // Relasi ke users.id
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->foreign('id_pelanggan')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. Tabel Tagihan
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->unsignedBigInteger('id_penggunaan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('jumlah_meter');
            $table->string('status')->default('Belum Bayar');
            $table->foreign('id_penggunaan')->references('id_penggunaan')->on('penggunaan')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        
        // 5. Trigger Otomatis
        DB::unprepared('
            CREATE TRIGGER after_penggunaan_insert
            AFTER INSERT ON penggunaan
            FOR EACH ROW
            BEGIN
                INSERT INTO tagihan 
                (id_penggunaan, id_pelanggan, bulan, tahun, jumlah_meter, status, created_at, updated_at)
                VALUES 
                (NEW.id_penggunaan, NEW.id_pelanggan, NEW.bulan, NEW.tahun, 
                (NEW.meter_akhir - NEW.meter_awal), "Belum Bayar", NOW(), NOW());
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_penggunaan_insert');
        Schema::dropIfExists('tagihan');
        Schema::dropIfExists('penggunaan');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tarif');
    }
};