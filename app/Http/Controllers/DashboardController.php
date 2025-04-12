<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $main = 'Home Dashboard';
        $sub = 'Dashboard';

        $totalSales = Penjualan::count(); // Total number of sales
        $totalRevenue = Penjualan::sum('TotalHarga'); // Total revenue
        $topSellingProducts = DetailPenjualan::join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
            ->select('produks.NamaProduk', DB::raw('SUM(detail_penjualans.JumlahProduk) as total_sold'))
            ->groupBy('produks.NamaProduk')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get(); // Top 5 selling products
        $lowStockProducts = Produk::where('Stok', '<=', 10)->get(); // Products with low stock
    
        return view('admin.dashboard', compact('totalSales', 'totalRevenue', 'topSellingProducts', 'lowStockProducts'));
    }

    public function getTopSellingProducts()
{
    $topSellingProducts = DetailPenjualan::join('produks', 'detail_penjualans.ProdukId', '=', 'produks.id')
        ->select('produks.NamaProduk', DB::raw('SUM(detail_penjualans.JumlahProduk) as total_sold'))
        ->groupBy('produks.NamaProduk')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

    return response()->json($topSellingProducts);
}


public function getLowStockProducts()
{
    $lowStockProducts = Produk::where('Stok', '<=', 10)->get();

    return response()->json($lowStockProducts);
}

public function getMonthlyRevenue()
{
    $monthlyRevenue = Penjualan::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(TotalHarga) as revenue'))
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->get();

    return response()->json($monthlyRevenue);
}
       
    }
