<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query();

        // Filter berdasarkan rentang tanggal jika ada
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal_penjualan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $penjualans = $query->orderBy('tanggal_penjualan', 'desc')->get();

        // Hitung total penjualan
        $totalPenjualan = $penjualans->sum(function ($penjualan) {
            return $penjualan->jumlah * $penjualan->harga;
        });

        // Data untuk grafik - tren penjualan berdasarkan tanggal
        $chartData = $penjualans->groupBy('tanggal_penjualan')->map(function ($items) {
            return $items->sum(function ($item) {
                return $item->jumlah * $item->harga;
            });
        })->sortKeys();

        $chartLabels = $chartData->keys()->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d M Y');
        })->values()->toArray();

        $chartValues = $chartData->values()->toArray();

        return view('dashboard', compact('penjualans', 'totalPenjualan', 'chartLabels', 'chartValues'));
    }
}

