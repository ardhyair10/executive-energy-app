<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['id_penggunaan', 'id_pelanggan', 'bulan', 'tahun', 'jumlah_meter', 'status'];

    // Relasi ke User (Pelanggan)
    public function pelanggan()
    {
        // Pastikan ini ke User::class, bukan Pelanggan::class
        return $this->belongsTo(User::class, 'id_pelanggan');
    }
    
    // Relasi ke Penggunaan
    public function penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'id_penggunaan');
    }
}