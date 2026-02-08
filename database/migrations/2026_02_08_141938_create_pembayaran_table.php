<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_tagihan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->dateTime('tanggal_pembayaran');
            $table->string('bulan_bayar');
            $table->decimal('biaya_admin', 10, 2);
            $table->decimal('total_bayar', 15, 2);
            $table->unsignedBigInteger('id_user'); // ID User yang melakukan pembayaran (Admin/Pelanggan)
            $table->timestamps();

            // Relasi (Optional tapi bagus buat integritas data)
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
