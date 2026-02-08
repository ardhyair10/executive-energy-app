<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Tarif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index() {
        $user = Auth::user();
        
        // Ambil semua tagihan user ini
        $tagihan = Tagihan::where('id_pelanggan', $user->id)
                          ->with('penggunaan')
                          ->orderBy('id_tagihan', 'desc')
                          ->get();

        // 1. Hitung Statistik buat Kartu Atas
        $total_kwh = $tagihan->sum('jumlah_meter'); 
        $tagihan_pending = $tagihan->where('status', 'Belum Bayar')->count(); 
        
        // 2. Siapkan Data buat Grafik (Chart.js)
        $grafik_data = Tagihan::where('id_pelanggan', $user->id)
                              ->orderBy('created_at', 'asc')
                              ->limit(6)
                              ->get();
                              
        $chart_bulan = $grafik_data->pluck('bulan')->toArray(); 
        $chart_kwh = $grafik_data->pluck('jumlah_meter')->toArray();

        // Kirim SEMUA variabel ini ke View
        return view('dashboard_pelanggan', compact(
            'tagihan', 'total_kwh', 'tagihan_pending', 'chart_bulan', 'chart_kwh'
        ));
    }

    public function bayarTagihanAuto($id) {
        return DB::transaction(function() use ($id) {
            $user = Auth::user();
            $tagihan = Tagihan::findOrFail($id);
            
            if ($tagihan->status == 'Lunas') {
                return back()->with('error', 'Tagihan sudah lunas!');
            }

            $tarif = Tarif::find($user->id_tarif) ?? Tarif::first();
            $biaya_admin = 2500;
            $total_tagihan = ($tagihan->jumlah_meter * $tarif->tarifperkwh) + $biaya_admin;

            if ($user->saldo < $total_tagihan) {
                return back()->with('error', 'Saldo tidak cukup! Total: Rp ' . number_format($total_tagihan));
            }

            $user->decrement('saldo', $total_tagihan);
            $tagihan->update(['status' => 'Lunas']);

            Pembayaran::create([
                'id_tagihan' => $tagihan->id_tagihan,
                'id_pelanggan' => $user->id,
                'tanggal_pembayaran' => now(),
                'bulan_bayar' => $tagihan->bulan,
                'biaya_admin' => $biaya_admin,
                'total_bayar' => $total_tagihan,
                'id_user' => $user->id,
            ]);

            return back()->with('success', 'Pembayaran Berhasil! Saldo terpotong otomatis.');
        });
    }
}