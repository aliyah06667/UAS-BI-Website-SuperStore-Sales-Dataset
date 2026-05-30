<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARD
        |--------------------------------------------------------------------------
        | Menghitung akumulasi data untuk widget atas dashboard
        */
        $totalSales = (float) DB::table('fact_sales')->sum('sales');

        $totalOrders = DB::table('fact_sales')
            ->distinct()
            ->count('order_id');

        $totalCustomers = DB::table('dim_customer')
            ->distinct()
            ->count('customer_id');

        $totalProfit = (float) DB::table('fact_sales')->sum('profit');

        $totalQuantity = (int) DB::table('fact_sales')->sum('quantity');

        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE CHART (LINE CHART)
        |--------------------------------------------------------------------------
        | FIX: Memastikan hasil SUM di-cast menjadi float/angka agar Chart.js 
        | dapat merender grafik garis performa secara presisi.
        */
        $monthlyPerformance = DB::table('fact_sales')
            ->join('dim_time', 'fact_sales.time_id', '=', 'dim_time.time_id')
            ->select(
                DB::raw('MONTH(dim_time.order_date) as month_number'),
                DB::raw('SUM(fact_sales.sales) as total_sales'),
                DB::raw('SUM(fact_sales.profit) as total_profit')
            )
            ->groupBy(DB::raw('MONTH(dim_time.order_date)'))
            ->orderBy(DB::raw('MONTH(dim_time.order_date)'))
            ->get();

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        // Format label bulan (Jan, Feb, dst.)
        $chartLabels = $monthlyPerformance->map(function ($item) use ($monthNames) {
            return $monthNames[(int)$item->month_number] ?? $item->month_number;
        })->values()->toArray();

        // FIX: Pastikan data sales dan profit bulanan berupa array angka murni (float)
        $salesData = $monthlyPerformance->map(function ($item) {
            return (float) $item->total_sales;
        })->values()->toArray();

        $profitData = $monthlyPerformance->map(function ($item) {
            return (float) $item->total_profit;
        })->values()->toArray();

        /*
        |--------------------------------------------------------------------------
        | CATEGORY CHART (DONUT)
        |--------------------------------------------------------------------------
        */
        $categorySales = DB::table('fact_sales')
            ->join('dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
            ->select(
                'dim_product.category',
                DB::raw('SUM(fact_sales.sales) as total_sales')
            )
            ->groupBy('dim_product.category')
            ->get();

        $categoryLabels = $categorySales->pluck('category')->values()->toArray();
        $categoryData   = $categorySales->map(function ($item) {
            return (float) $item->total_sales;
        })->values()->toArray();

        /*
        |--------------------------------------------------------------------------
        | CLUSTER STATISTICS (OVERVIEW CARD)
        |--------------------------------------------------------------------------
        | FIX: Mengamankan inisialisasi awal array $clusterStats untuk index 0, 1, 2
        | agar mencegah error / data kosong jika query mengembalikan index yang melompat.
        */
        $clusterStatsRaw = DB::table('fact_sales')
            ->select(
                'cluster',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(sales) as avg_sales'),
                DB::raw('AVG(profit) as avg_profit')
            )
            ->whereNotNull('cluster')
            ->groupBy('cluster')
            ->orderBy('cluster', 'asc')
            ->get();

        // Inisialisasi awal dengan nilai fallback default
        $clusterStats = [
            0 => ['count' => 0, 'avg_sales' => 0.0, 'avg_profit' => 0.0],
            1 => ['count' => 0, 'avg_sales' => 0.0, 'avg_profit' => 0.0],
            2 => ['count' => 0, 'avg_sales' => 0.0, 'avg_profit' => 0.0],
        ];

        // Timpa nilai default menggunakan data asli dari database
        foreach ($clusterStatsRaw as $stats) {
            $clusterId = (int)$stats->cluster;
            $clusterStats[$clusterId] = [
                'count'      => (int) $stats->count,
                'avg_sales'  => (float) $stats->avg_sales,
                'avg_profit' => (float) $stats->avg_profit,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SCATTER DATA (K-MEANS)
        |--------------------------------------------------------------------------
        | FIX: Mengamankan struktur properti koordinat X dan Y langsung dari array 
        | awal sebelum dikonversi ke JSON.
        */
        $scatterData = DB::table('fact_sales')
            ->select('sales', 'profit', 'cluster')
            ->whereNotNull('cluster')
            ->limit(300)
            ->get()
            ->map(function ($item) {
                return [
                    'sales'   => (float) $item->sales,
                    'profit'  => (float) $item->profit,
                    'cluster' => (int) $item->cluster,
                ];
            })->values()->toArray();

        /*
        |--------------------------------------------------------------------------
        | RECENT TRANSACTIONS
        |--------------------------------------------------------------------------
        */
        $recentOrders = DB::table('fact_sales')
            ->join('dim_customer', 'fact_sales.customer_id', '=', 'dim_customer.customer_id')
            ->join('dim_product', 'fact_sales.product_id', '=', 'dim_product.product_id')
            ->join('dim_location', 'fact_sales.location_id', '=', 'dim_location.location_id')
            ->select(
                'fact_sales.order_id',
                'dim_customer.customer_name',
                'dim_product.product_name',
                'dim_location.country',
                'dim_location.market',
                'fact_sales.sales',
                'fact_sales.profit',
                'fact_sales.cluster'
            )
            ->orderBy('fact_sales.order_id', 'desc')
            ->limit(10)
            ->get();

        // Oper semua variabel ke view dashboard
        return view('dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'totalCustomers',
            'totalProfit',
            'totalQuantity',
            'chartLabels',
            'salesData',
            'profitData',
            'categoryLabels',
            'categoryData',
            'clusterStats',
            'scatterData',
            'recentOrders'
        ));
    }
}