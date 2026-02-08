<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_tagihan', 'id_pelanggan', 'tanggal_pembayaran', 
        'bulan_bayar', 'biaya_admin', 'total_bayar', 'id_user'
    ];
}