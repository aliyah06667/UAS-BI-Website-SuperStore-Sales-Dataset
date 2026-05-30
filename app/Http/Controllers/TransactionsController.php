<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransactionsController extends Controller
{
    /**
     * Menampilkan riwayat unggah berkas CSV
     */
    public function index()
    {
        if (!Schema::hasTable('csv_imports')) {
            $csvLogs = collect([]);
        } else {
            $csvLogs = DB::table('csv_imports')
                ->select('id', 'file_name', 'row_count', 'file_size', 'status', 'created_at')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('transactions.index', compact('csvLogs'));
    }

    /**
     * Menangani unggahan berkas CSV baru & Memproses ke Database
     */
    public function import(Request $request)
    {
        // Validasi: Wajib diisi, tipe harus csv/txt, dan ukuran MAKSIMAL 1MB (1024 KB)
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:1024',
        ]);

        $file = $request->file('csv_file');
        $originalName = $file->getClientOriginalName();
        
        // Menghitung ukuran file untuk dicatat ke log riwayat
        $sizeBytes = $file->getSize();
        $fileSizeFormatted = $sizeBytes >= 1048576 
            ? number_format($sizeBytes / 1048576, 2) . ' MB' 
            : number_format($sizeBytes / 1024, 0) . ' KB';

        DB::beginTransaction();

        try {
            $filePath = $file->getRealPath();
            $fileHandle = fopen($filePath, 'r');

            if ($fileHandle === false) {
                throw new \RuntimeException('Gagal membuka file CSV untuk dibaca.');
            }

            $header = fgetcsv($fileHandle, 1000, ',');
            $rowCount = 0;

            while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
                if (empty(array_filter($row, fn($value) => $value !== null && trim((string) $value) !== ''))) {
                    continue;
                }

                if (count($row) < 12) {
                    throw new \UnexpectedValueException('Format CSV tidak valid. Pastikan ada 12 kolom yang dibutuhkan.');
                }

                DB::table('fact_sales')->insert([
                    'order_id'       => $row[0],
                    'customer_id'    => $row[1],
                    'product_id'     => $row[2],
                    'location_id'    => $row[3],
                    'time_id'        => $row[4],
                    'sales'          => $row[5],
                    'quantity'       => $row[6],
                    'discount'       => $row[7],
                    'profit'         => $row[8],
                    'shipping_cost'  => $row[9],
                    'cluster'        => $row[10],
                    'cluster_label'  => $row[11],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                $rowCount++;
            }

            if (Schema::hasTable('csv_imports')) {
                DB::table('csv_imports')->insert([
                    'file_name'  => $originalName,
                    'row_count'  => $rowCount,
                    'file_size'  => $fileSizeFormatted,
                    'status'     => 'sukses',
                    'created_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Berkas CSV berhasil diproses, data gudang penjualan diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            if (Schema::hasTable('csv_imports')) {
                DB::table('csv_imports')->insert([
                    'file_name'  => $originalName,
                    'row_count'  => 0,
                    'file_size'  => $fileSizeFormatted,
                    'status'     => 'gagal',
                    'created_at' => now(),
                ]);
            }

            return redirect()->route('transactions.index')->with('error', 'Terjadi kesalahan saat membaca file: ' . $e->getMessage());
        } finally {
            if (!empty($fileHandle) && is_resource($fileHandle)) {
                fclose($fileHandle);
            }
        }
    }
}