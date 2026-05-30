<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan — SerbaSerbi.</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #5D3340; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #5D3340; font-size: 22px; }
        .header p { margin: 5px 0 0 0; color: #777; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        th { background-color: #5D3340; color: white; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 7px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-box { background-color: #f9f9f9; padding: 12px; border: 1px solid #ddd; font-size: 13px; text-align: right; font-weight: bold; color: #5D3340; }
        .text-profit { color: #2dce89; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SerbaSerbi. Dashboard</h2>
        <p>Laporan Resmi Analisis Transaksi Penjualan Ritel // Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="8%">Tanggal</th>
                <th width="12%">Order ID</th>
                <th width="15%">Customer</th>
                <th width="10%">Wilayah</th>
                <th>Nama Produk</th>
                <th width="5%">Qty</th>
                <th width="12%">Sales</th>
                <th width="12%">Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $r)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($r['order_date'])) }}</td>
                    <td><strong>{{ $r['order_id'] }}</strong></td>
                    <td>{{ $r['customer_name'] }}</td>
                    <td>{{ $r['city'] }}</td>
                    <td>{{ $r['product_name'] }}</td>
                    <td class="text-center">{{ $r['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($r['sales_amount'], 0, ',', '.') }}</td>
                    <td class="text-right text-profit">Rp {{ number_format($r['profit'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        TOTAL PENDAPATAN (REVENUE): Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>

</body>
</html>