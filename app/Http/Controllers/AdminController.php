<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Pembayaran;
use App\Models\Tarif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Dashboard Admin
    public function index()
    {
        // Ambil Data Statistik
        $total_pelanggan = User::where('role', 'pelanggan')->count();
        $tagihan_belum_bayar = Tagihan::where('status', 'Belum Bayar')->count();
        
        // Ambil Data untuk Dropdown Input Meteran
        $pelanggan = User::where('role', 'pelanggan')->get();

        // Ambil Data Tabel Tagihan (Live Data)
        $tagihan = Tagihan::with('pelanggan')
                          ->orderBy('id_tagihan', 'desc')
                          ->get();

        return view('dashboard', compact('total_pelanggan', 'tagihan_belum_bayar', 'pelanggan', 'tagihan'));
    }

    // 2. Simpan Meteran (Trigger Tagihan Otomatis)
    public function storePenggunaan(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal', // Meter akhir wajib lebih besar
        ]);

        // Cek apakah sudah ada tagihan di bulan ini?
        $cek = Penggunaan::where('id_pelanggan', $request->id_pelanggan)
                         ->where('bulan', $request->bulan)
                         ->where('tahun', $request->tahun)
                         ->first();

        if ($cek) {
            return back()->with('error', 'Tagihan untuk periode ini sudah ada!');
        }

        // Simpan ke database (Trigger MySQL akan otomatis bikin Tagihan)
        Penggunaan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'meter_awal' => $request->meter_awal,
            'meter_akhir' => $request->meter_akhir,
        ]);

        return back()->with('success', 'Meteran berhasil dicatat! Tagihan otomatis terbuat.');
    }

    // 3. Konfirmasi Pembayaran Manual (Tunai di Admin)
    public function bayarTagihan($id)
    {
        return DB::transaction(function() use ($id) {
            $tagihan = Tagihan::findOrFail($id);
            $user = User::findOrFail($tagihan->id_pelanggan); // Ambil data pelanggan pemilik tagihan
            $admin = Auth::user(); // Admin yang sedang login

            // Ambil Tarif
            $tarif = Tarif::first(); 
            $biaya_admin = 2500;
            $total_bayar = ($tagihan->jumlah_meter * $tarif->tarifperkwh) + $biaya_admin;

            // 1. Update Status Tagihan
            $tagihan->update(['status' => 'Lunas']);

            // 2. Catat ke Tabel Pembayaran
            Pembayaran::create([
                'id_tagihan' => $tagihan->id_tagihan,
                'id_pelanggan' => $user->id,
                'tanggal_pembayaran' => now(),
                'bulan_bayar' => $tagihan->bulan,
                'biaya_admin' => $biaya_admin,
                'total_bayar' => $total_bayar,
                'id_user' => $admin->id, // Yang memproses adalah Admin
            ]);

            return back()->with('success', 'Pembayaran Berhasil Dikonfirmasi (Tunai).');
        });
    }

    // --- FITUR LAPORAN (REPORTING) ---

    // 4. Halaman Filter Laporan
    public function laporan(Request $request)
    {
        // Konversi input ke Integer
        $bulan_angka = (int) $request->input('bulan', date('m')); 
        $tahun = (int) $request->input('tahun', date('Y'));

        // Ambil Data Pembayaran
        $laporan = \App\Models\Pembayaran::with(['pelanggan', 'tagihan'])
            ->whereMonth('tanggal_pembayaran', $bulan_angka)
            ->whereYear('tanggal_pembayaran', $tahun)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        // Format bulan jadi 2 digit buat View
        $bulan = sprintf('%02d', $bulan_angka);

        // Langsung return View (JANGAN PAKE DD LAGI)
        return view('admin.laporan', compact('laporan', 'bulan', 'tahun'));
    }

    // 5. Halaman Cetak PDF (Kertas Putih)
    public function cetakLaporan($bulan, $tahun)
    {
        // Pastikan konversi ke int juga disini
        $laporan = Pembayaran::with(['pelanggan', 'tagihan'])
            ->whereMonth('tanggal_pembayaran', (int)$bulan)
            ->whereYear('tanggal_pembayaran', (int)$tahun)
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        return view('admin.cetak_laporan', compact('laporan', 'bulan', 'tahun'));
    }
}