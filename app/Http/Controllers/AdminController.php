<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;      // Pakai User, bukan Pelanggan
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pembayaran; // Tambahin ini di atas
use Illuminate\Support\Facades\Auth; // Tambahin ini di atas
class AdminController extends Controller
{
    // Menampilkan Dashboard Admin
    public function index() {
        // Ambil data user yang role-nya 'pelanggan' dari tabel users
        $pelanggan = User::where('role', 'pelanggan')->get(); 
        
        // Ambil tagihan beserta relasi ke pelanggannya
        $tagihan = Tagihan::with('pelanggan')->orderBy('id_tagihan', 'desc')->get(); 
        
        return view('dashboard', compact('pelanggan', 'tagihan'));
    }

    // Proses Simpan Penggunaan
    public function storePenggunaan(Request $request) {
        $request->validate([
            'id_pelanggan' => 'required',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal',
        ]);

        Penggunaan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'meter_awal' => $request->meter_awal,
            'meter_akhir' => $request->meter_akhir,
        ]);

        return redirect()->back()->with('success', 'Data tersimpan & Tagihan otomatis dibuat!');
    }
    public function bayarTagihan($id) {
    // 1. Cari Tagihannya
    $tagihan = Tagihan::findOrFail($id);

    // 2. Cek kalau udah lunas, jangan dibayar lagi
    if ($tagihan->status == 'Lunas') {
        return back()->with('error', 'Tagihan ini sudah lunas, Bro!');
    }

    // 3. Update Status di Tabel Tagihan
    $tagihan->update(['status' => 'Lunas']);

    // 4. Catat di Tabel Pembayaran (Bukti Transaksi)
    Pembayaran::create([
        'id_tagihan' => $tagihan->id_tagihan,
        'id_pelanggan' => $tagihan->id_pelanggan,
        'tanggal_pembayaran' => now(),
        'bulan_bayar' => $tagihan->bulan,
        'biaya_admin' => 2500, // Biaya admin ceritanya 2500
        'total_bayar' => ($tagihan->jumlah_meter * 1500) + 2500, // Asumsi tarif flat 1500/kwh biar simpel hitungnya
        'id_user' => Auth::id(), // Admin yang memproses
    ]);

    return back()->with('success', 'Pembayaran Berhasil! Status berubah jadi Lunas.');
}
}