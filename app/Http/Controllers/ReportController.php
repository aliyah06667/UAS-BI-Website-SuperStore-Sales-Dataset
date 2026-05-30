<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Laporan (RINGAN & CEPAT)
     */
    public function index(Request $request)
    {
        // 1. Ambil input filter & search
        $keyword = $request->input('search', '');
        $selectedCategory = $request->input('category', '');

        // 2. Ambil list kategori unik (Gunakan cache atau optimasi pencarian ringan)
        $categories = DB::table('dim_product')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->map(function ($item) {
                return ['category' => $item->category];
            })->toArray();

        // 3. Query Utama Multi-Join (Belum dieksekusi ke DB, jadi masih ringan)
        $query = DB::table('fact_sales')
            ->join('dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
            ->join('dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
            ->join('dim_customer', 'fact_sales.customer_id', '=', 'dim_customer.customer_id')
            ->join('dim_location', 'fact_sales.location_id', '=', 'dim_location.location_id');

        // 4. Filter Pencarian Fleksibel
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('fact_sales.order_id', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_customer.customer_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_product.product_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_location.market', 'LIKE', '%' . $keyword . '%');
            });
        }

        // 5. Filter Kategori Produk
        if (!empty($selectedCategory)) {
            $query->where('dim_product.category', $selectedCategory);
        }

        // --- TRICK AGAR PEMROSESAN DATABASE SUPER CEPAT ---
        // Kita hitung total statistik aggregate secara langsung di Database, 
        // bukan menarik datanya dulu ke Laravel. Ini memotong beban loading hingga 95%.
        $totalRevenue = (clone $query)->sum('fact_sales.sales');

$totalOrders = (clone $query)
    ->distinct('fact_sales.order_id')
    ->count('fact_sales.order_id');

$totalQuantity = (clone $query)
    ->sum('fact_sales.quantity');

        // 6. Eksekusi query dengan PAGINATE (Hanya mengambil 10 data untuk halaman aktif)
        $salesPaginated = $query->select(
                'fact_sales.order_id',
                'dim_time.order_date',
                'dim_customer.customer_name',
                'dim_location.market as city',
                'dim_product.product_id',
                'dim_product.product_name',
                'dim_product.category',
                'fact_sales.sales as sales_amount',
                'fact_sales.quantity',
                'fact_sales.discount',
                'fact_sales.profit'
            )
            ->orderBy('dim_time.order_date', 'desc')
            ->paginate(10); // Menampilkan 10 data per halaman

        // Konversi item halaman aktif ke array untuk struktur Blade kamu
        $reports = collect($salesPaginated->items())->map(function($item) {
            return (array) $item;
        })->toArray();

        return view('reports.index', compact(
            'reports',
            'salesPaginated', // Variabel ini wajib dikirim untuk merender tombol Next/Prev halaman
            'categories',
            'totalRevenue',
            'totalOrders',
            'totalQuantity',
            'keyword',
            'selectedCategory'
        ));
    }

    /**
     * Menampilkan Halaman Pratinjau Sebelum Cetak (Dibatasi 100 Data Terbaru)
     */
    public function previewReport(Request $request)
    {
        $keyword = $request->input('search', '');
        $selectedCategory = $request->input('category', '');

        $query = DB::table('fact_sales')
            ->join('dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
            ->join('dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
            ->join('dim_customer', 'fact_sales.customer_id', '=', 'dim_customer.customer_id')
            ->join('dim_location', 'fact_sales.location_id', '=', 'dim_location.location_id')
            ->select(
                'fact_sales.order_id',
                'dim_time.order_date',
                'dim_customer.customer_name',
                'dim_location.market as city',
                'dim_product.product_name',
                'dim_product.category',
                'fact_sales.sales as sales_amount',
                'fact_sales.quantity',
                'fact_sales.profit'
            );

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('fact_sales.order_id', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_customer.customer_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_product.product_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('dim_location.market', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($selectedCategory)) {
            $query->where('dim_product.category', $selectedCategory);
        }

        // Tetap di-limit 100 agar lembar kertas pratinjau tidak jebol ribuan halaman
        $reports = $query->orderBy('dim_time.order_date', 'desc')
            ->limit(100)
            ->get()
            ->map(function($item) {
                return (array) $item;
            })->toArray();

        $totalRevenue = array_sum(array_column($reports, 'sales_amount'));
        $totalProfit = array_sum(array_column($reports, 'profit'));

        return view('reports.preview', compact('reports', 'totalRevenue', 'totalProfit', 'keyword', 'selectedCategory'));
    }
}