<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    
    // Pastikan semua kolom ini ada di $fillable
    protected $fillable = [
        'id_tagihan',
        'id_pelanggan',
        'tanggal_pembayaran',
        'bulan_bayar',
        'biaya_admin',
        'total_bayar',
        'id_user',
    ];

    // Relasi ke User (Pelanggan)
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }

    // Relasi ke Admin yang memproses (Optional)
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}