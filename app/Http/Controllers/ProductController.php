<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DimProduct;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        // 1. Ambil input
        $keyword = $request->input('search', '');
        $selectedCategory = $request->input('category', '');

        // 2. Ambil kategori unik (Optimasi: Langsung ambil array pluck)
        $categories = DB::table('dim_product')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category', 'asc')
            ->pluck('category');

        // 3. Query dasar
        // TAMBAHKAN orderBy agar pagination memiliki struktur index yang tetap
        $query = DB::table('dim_product')
            ->select('product_id', 'product_name', 'category', 'sub_category')
            ->orderBy('product_id', 'asc'); // Wajib ada pengurutan

        // 4. Logika Pencarian
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('product_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('category', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('sub_category', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('product_id', 'LIKE', '%' . $keyword . '%');
            });
        }

        // 5. Logika Filter
        if (!empty($selectedCategory)) {
            $query->where('category', $selectedCategory);
        }

        // 6. EKSEKUSI PAGINATION
        // Menggunakan method paginate() langsung. appends() sebaiknya di Blade 
        // atau jika di sini, pastikan tipenya tetap LengthAwarePaginator.
        $products = $query->paginate(10);
        
        // Memasukkan parameter pencarian ke link pagination agar tidak hilang saat klik Page 2
        $products->appends([
            'search' => $keyword,
            'category' => $selectedCategory
        ]);

        // 7. Hitung statistik
        $totalProducts = DB::table('dim_product')->count();
        
        $totalSubCategory = DB::table('dim_product')
            ->distinct('sub_category') // Pastikan distinct kolom spesifik
            ->whereNotNull('sub_category')
            ->count('sub_category');

        // 8. Kirim ke Blade
        return view('products.index', compact(
    'products', 
    'totalProducts', 
    'categories', 
    'totalSubCategory', 
    'keyword', 
    'selectedCategory'
));
    }
}