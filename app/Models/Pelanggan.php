<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    // Kasih tahu Laravel nama tabelnya 'pelanggan' (bukan pelanggans)
    protected $table = 'pelanggan'; 
    
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['username', 'password', 'nomor_kwh', 'nama_pelanggan', 'alamat', 'id_tarif'];
}