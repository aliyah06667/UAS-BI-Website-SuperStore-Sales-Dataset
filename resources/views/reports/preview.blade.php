<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Dokumen Laporan Penjualan — SerbaSerbi.</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-plum: #5D3340;
            --text-dark: #222;
            --text-muted: #666;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background-color: #525659; padding: 40px 20px; display: flex; justify-content: center; }

        /* Floating Action Bar */
        .action-bar {
            position: fixed; top: 0; left: 0; right: 0; height: 60px;
            background: #323639; display: flex; align-items: center;
            justify-content: space-between; padding: 0 30px; z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3); color: #fff;
        }
        .doc-title { font-size: 0.9rem; font-weight: 500; color: #e8eaed; }
        .btn-print {
            background: var(--primary-plum); color: white; border: none;
            padding: 8px 20px; border-radius: 6px; font-size: 0.85rem;
            font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;
            transition: background 0.2s; text-decoration: none;
        }
        .btn-print:hover { background: #7A4055; }
        .btn-back { color: #ccc; text-decoration: none; font-size: 0.85rem; }
        .btn-back:hover { color: #fff; }

        /* Kertas Dokumen A4 Landscape */
        .document-page {
            background: white; width: 297mm; min-height: 210mm;
            padding: 25mm 20mm; margin-top: 50px; box-shadow: 0 0 20px rgba(0,0,0,0.4);
            position: relative; overflow: hidden;
        }

        /* Kop Surat Resmi */
        .kop-surat { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px double var(--primary-plum); padding-bottom: 15px; margin-bottom: 30px; }
        .company-details h1 { font-size: 1.8rem; font-weight: 800; color: var(--primary-plum); letter-spacing: 1px; }
        .company-details p { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
        .report-meta { text-align: right; font-size: 0.8rem; color: var(--text-dark); line-height: 1.5; }

        .doc-heading { text-align: center; margin-bottom: 25px; }
        .doc-heading h2 { font-size: 1.3rem; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.5px; }
        .doc-heading p { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }

        /* Tabel Data Percetakan */
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f4f5f7; color: var(--primary-plum); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 10px; border: 1px solid #dcdcdc; text-align: left; }
        td { padding: 9px 10px; border: 1px solid #e2e2e2; font-size: 0.78rem; color: #333; vertical-align: middle; }
        tr:nth-child(even) { background-color: #fbfbfc; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Box Total Ringkasan Bawah */
        .summary-wrapper { display: flex; justify-content: flex-end; gap: 20px; margin-bottom: 50px; }
        .summary-box { background: #fdf8f9; border: 1.5px solid #f9dce7; border-radius: 8px; padding: 15px 20px; min-width: 280px; text-align: right; }
        .summary-item { display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; }
        .summary-item.grand-total { font-size: 0.95rem; font-weight: 700; color: var(--primary-plum); border-top: 1px dashed #f9dce7; padding-top: 6px; margin-top: 6px; }

        /* Area Tanda Tangan */
        .signature-area { display: flex; justify-content: flex-end; padding-right: 40px; }
        .signature-box { text-align: center; font-size: 0.82rem; color: var(--text-dark); line-height: 1.2; }
        .signature-space { height: 75px; }

        /* CSS KHUSUS SAAT TOMBOL CETAK DIKLIK (PRINT MODE) */
        @media print {
            body { background: white; padding: 0; }
            .action-bar { display: none; } /* Sembunyikan topbar navigasi */
            .document-page { margin-top: 0; box-shadow: none; padding: 0; width: 100%; }
        }
    </style>
</head>
<body>

    <!-- BAR AKSI ATAS -->
    <div class="action-bar">
        <a href="{{ route('reports.index') }}" class="btn-back"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
        <div class="doc-title"><i class="fas fa-file-invoice me-2"></i> Pratinjau_Laporan_Penjualan_{{ date('Ymd') }}.html</div>
        <!-- MEMICU WINDOW PRINT BAWAAN BROWSER -->
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- HALAMAN KERTAS DOKUMEN -->
    <div class="document-page">
        
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="company-details">
                <h1>SerbaSerbi.</h1>
                <p>Gedung Pusat Niaga Data Warehouse, Lantai 4 // Cloud Distribution System</p>
                <p>Email: admin@serbaserbi.co.id — Telp: (021) 8892-1271</p>
            </div>
            <div class="report-meta">
                <p><strong>Tanggal Cetak:</strong> {{ date('d M Y, H:i') }} WITA</p>
                <p><strong>Status Dokumen:</strong> Validated (Original)</p>
                @if($selectedCategory) <p><strong>Filter Kategori:</strong> {{ $selectedCategory }}</p> @endif
            </div>
        </div>

        <!-- JUDUL LAPORAN -->
        <div class="doc-heading">
            <h2>Laporan Analisis Data Penjualan Ritel</h2>
            <p>Periode Data Riwayat Transaksi Penjualan Berdasarkan Aturan Skema Bintang Terintegrasi</p>
        </div>

        <!-- DATA TABEL -->
        <table>
            <thead>
                <tr>
                    <th width="4%" class="text-center">No</th>
                    <th width="9%">Tanggal</th>
                    <th width="12%">Order ID</th>
                    <th width="14%">Customer Name</th>
                    <th width="10%">Wilayah/Market</th>
                    <th>Nama Item Produk</th>
                    <th width="5%" class="text-center">Qty</th>
                    <th width="12%" class="text-right">Sales Amount</th>
                    <th width="12%" class="text-right">Net Profit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $r)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($r['order_date'])) }}</td>
                        <td><strong>{{ $r['order_id'] }}</strong></td>
                        <td>{{ $r['customer_name'] }}</td>
                        <td>{{ $r['city'] }}</td>
                        <td>{{ $r['product_name'] }}</td>
                        <td class="text-center">{{ $r['quantity'] }}</td>
                        <td class="text-right">Rp {{ number_format($r['sales_amount'], 0, ',', '.') }}</td>
                        <td class="text-right" style="color: #2dce89; font-weight: 500;">Rp {{ number_format($r['profit'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTAL DAN TANDA TANGAN -->
        <div class="summary-wrapper">
            <div class="summary-box">
                <div class="summary-item">
                    <span>Total Volume Item:</span>
                    <strong>{{ array_sum(array_column($reports, 'quantity')) }} Pcs</strong>
                </div>
                <div class="summary-item">
                    <span>Akumulasi Laba Bersih:</span>
                    <strong style="color: #2dce89;">Rp {{ number_format($totalProfit, 0, ',', '.') }}</strong>
                </div>
                <div class="summary-item grand-total">
                    <span>Total Pendapatan:</span>
                    <span>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- ATAS NAMA/TANDA TANGAN -->
        <div class="signature-area">
            <div class="signature-box">
                <p>Samarinda, {{ date('d F Y') }}</p>
                <p style="margin-top: 5px; font-weight: 600;">Sistem Informasi Eksekutif,</p>
                <div class="signature-space"></div>
                <p style="text-decoration: underline; font-weight: 700;">SerbaSerbi. Auto-Report</p>
                <p style="font-size: 0.7rem; color: var(--text-muted)">ID Otentikasi: SYS-{{ rand(1000,9999) }}</p>
            </div>
        </div>

    </div>

</body>
</html>