@extends('layouts.app')

@section('content')

@push('styles')
<style>
:root{
    --primary-plum:#5D3340;
    --plum-mid:#7A4055;
    --accent-pink:#FF5CA8;
    --soft-pink:#F9DCE7;
    --bg-base:#FFF9FB;
    --text-dark:#3A2030;
    --text-muted:#A08090;
    --shadow-card:0 6px 18px rgba(93,51,64,.06);

    /* Cluster Colors */
    --cluster-0:#5D3340;
    --cluster-0-bg:rgba(93,51,64,.12);
    --cluster-0-label:#5D3340;
    --cluster-1:#FF5CA8;
    --cluster-1-bg:rgba(255,92,168,.12);
    --cluster-1-label:#c0347a;
    --cluster-2:#2A7D6F;
    --cluster-2-bg:rgba(42,125,111,.12);
    --cluster-2-label:#1d5c51;
}

body{
    background:var(--bg-base);
    font-family:'Poppins',sans-serif;
    color:var(--text-dark);
}

.dashboard-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 0 16px;
}

/* HERO */
.hero-card{
    background: linear-gradient(135deg,#4A2030 0%,#5D3340 40%,#9B4070 75%,#FF5CA8 100%);
    border-radius:36px;
    padding:60px;
    position:relative;
    overflow:hidden;
    box-shadow: 0 10px 30px rgba(93,51,64,.12);
}
.hero-card::before{
    content:'';position:absolute;width:350px;height:350px;
    background:rgba(255,255,255,.08);border-radius:50%;
    top:-120px;right:-80px;filter:blur(10px);
}
.hero-card::after{
    content:'';position:absolute;width:260px;height:260px;
    background:rgba(255,92,168,.25);border-radius:50%;
    bottom:-120px;left:-50px;filter:blur(12px);
}
.hero-content{position:relative;z-index:2;}
.hero-greeting{color:rgba(255,255,255,.7);font-size:13px;letter-spacing:3px;margin-bottom:12px;font-weight:600;}
.hero-title{font-family:'EB Garamond',serif;font-size:64px;color:white;line-height:1;margin-bottom:18px;}
.hero-sub{max-width:600px;color:rgba(255,255,255,.85);line-height:1.8;margin-bottom:30px;font-size:15px;}
.hero-buttons{display:flex;gap:15px;flex-wrap:wrap;}
.hero-btn-primary{padding:15px 28px;border:none;border-radius:999px;background:white;color:var(--primary-plum);font-weight:600;text-decoration:none;transition:.3s;}
.hero-btn-primary:hover{transform:translateY(-3px);box-shadow:0 10px 20px rgba(255,255,255,0.2);}
.hero-btn-secondary{padding:15px 28px;border-radius:999px;border:1px solid rgba(255,255,255,.4);color:white;text-decoration:none;backdrop-filter:blur(12px);background:rgba(255,255,255,.08);transition:.3s;}
.hero-btn-secondary:hover{background:rgba(255,255,255,.2);}

/* STATS GRID */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:22px;
}
.stat-card{background:rgba(255,255,255,.7);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.4);border-radius:28px;padding:28px;box-shadow:var(--shadow-card);transition:.35s;}
.stat-card:hover{transform:translateY(-8px);}
.stat-top{display:flex;justify-content:space-between;margin-bottom:20px;}
.stat-label{font-size:13px;color:var(--text-muted);font-weight:400;}
.stat-icon{width:50px;height:50px;border-radius:16px;background:rgba(255,92,168,.12);display:flex;align-items:center;justify-content:center;color:var(--accent-pink);font-size:20px;}
.stat-value{font-size:27px;font-weight:700;color:var(--primary-plum);margin-bottom:8px;}
.stat-trend{color:#28c76f;font-size:13px;font-weight:600;}

/* CHARTS SECTION */
.charts-row{display:grid;grid-template-columns:2fr 1fr;gap:22px;}
.chart-card{background:white;border-radius:30px;padding:30px;box-shadow:var(--shadow-card);display:flex;flex-direction:column;gap:20px;}
.chart-card h3{font-family:'EB Garamond',serif;font-size:28px;color:var(--primary-plum);margin-bottom:0;}
.chart-container{position:relative;width:100%;min-height:260px;height:320px;}

/* ===================== CLUSTERING SECTION ===================== */
.section-divider{
    display:flex;align-items:center;gap:16px;margin:10px 0 -10px;
}
.section-divider h2{
    font-family:'EB Garamond',serif;font-size:34px;color:var(--primary-plum);white-space:nowrap;
}
.section-divider::after{
    content:'';flex:1;height:2px;
    background:linear-gradient(90deg,rgba(93,51,64,.2),transparent);
    border-radius:999px;
}

/* Cluster Overview Cards */
.cluster-overview{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:22px;
}
.cluster-card{
    border-radius:24px;padding:26px 28px;
    background:white;box-shadow:var(--shadow-card);
    border-top:5px solid transparent;
    transition:.3s;
}
.cluster-card:hover{transform:translateY(-5px);}
.cluster-card.c0{border-color:var(--cluster-0);}
.cluster-card.c1{border-color:var(--cluster-1);}
.cluster-card.c2{border-color:var(--cluster-2);}

.cluster-badge{
    display:inline-flex;align-items:center;gap:8px;
    border-radius:999px;padding:5px 14px;font-size:12px;font-weight:700;
    margin-bottom:16px;letter-spacing:.5px;
}
.cluster-badge.c0{background:var(--cluster-0-bg);color:var(--cluster-0-label);}
.cluster-badge.c1{background:var(--cluster-1-bg);color:var(--cluster-1-label);}
.cluster-badge.c2{background:var(--cluster-2-bg);color:var(--cluster-2-label);}

.cluster-dot{
    width:8px;height:8px;border-radius:50%;display:inline-block;
}
.cluster-dot.c0{background:var(--cluster-0);}
.cluster-dot.c1{background:var(--cluster-1);}
.cluster-dot.c2{background:var(--cluster-2);}

.cluster-name{font-size:18px;font-weight:700;color:var(--primary-plum);margin-bottom:6px;}
.cluster-desc{font-size:13px;color:var(--text-muted);line-height:1.6;margin-bottom:18px;}
.cluster-stats-row{display:flex;gap:20px;flex-wrap:wrap;}
.cluster-stat-item label{display:block;font-size:11px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;}
.cluster-stat-item span{font-size:20px;font-weight:700;color:var(--primary-plum);}

/* Scatter Chart + Summary row */
.cluster-visual-row{
    display:grid;grid-template-columns:3fr 2fr;gap:22px;
}

/* TABLE */
.table-card{background:white;border-radius:30px;padding:30px;box-shadow:var(--shadow-card);}
.table-title{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;}
.table-title h2{font-family:'EB Garamond',serif;font-size:38px;color:var(--primary-plum);margin:0;}
.table-responsive{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;padding-bottom:6px;}
table{width:100%;border-collapse:collapse;min-width:640px;}
thead th{text-align:left;padding:16px;color:var(--text-muted);font-size:13px;border-bottom:1px solid #f3dce5;text-transform:uppercase;letter-spacing:.5px;}
tbody td{padding:18px 16px;border-bottom:1px solid #f8e9ef;font-size:14px;}

.status{padding:7px 15px;border-radius:999px;background:rgba(40,199,111,.12);color:#28c76f;font-size:12px;font-weight:600;}

/* Cluster label pill in table */
.cluster-pill{
    display:inline-flex;align-items:center;gap:6px;
    padding:5px 12px;border-radius:999px;font-size:12px;font-weight:700;
}
.cluster-pill.c0{background:var(--cluster-0-bg);color:var(--cluster-0-label);}
.cluster-pill.c1{background:var(--cluster-1-bg);color:var(--cluster-1-label);}
.cluster-pill.c2{background:var(--cluster-2-bg);color:var(--cluster-2-label);}

/* Legend */
.chart-legend{display:flex;gap:20px;margin-bottom:14px;flex-wrap:wrap;}
.legend-item{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:var(--text-dark);}
.legend-dot{width:12px;height:12px;border-radius:50%;}
.legend-dot.c0{background:var(--cluster-0);}
.legend-dot.c1{background:var(--cluster-1);}
.legend-dot.c2{background:var(--cluster-2);}

/* Insight list */
.insight-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:14px;}
.insight-item{display:flex;gap:14px;align-items:flex-start;padding:14px 16px;border-radius:16px;background:#FFF9FB;border:1px solid #f3dce5;}
.insight-icon{width:36px;height:36px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.insight-icon.c0{background:var(--cluster-0-bg);}
.insight-icon.c1{background:var(--cluster-1-bg);}
.insight-icon.c2{background:var(--cluster-2-bg);}
.insight-text{font-size:13px;color:var(--text-dark);line-height:1.6;}
.insight-text strong{display:block;font-size:12px;color:var(--text-muted);font-weight:600;margin-bottom:2px;}

/* RESPONSIVE */
@media(max-width:1400px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:1200px){
    .charts-row,.cluster-visual-row{grid-template-columns:1fr;}
    .cluster-overview{grid-template-columns:1fr 1fr;}
}
@media(max-width:992px){
    .stats-grid,.cluster-overview{grid-template-columns:1fr;}
    .chart-card{padding:24px;}
}
@media(max-width:768px){
    .hero-card{padding:35px;}
    .hero-title{font-size:46px;}
}
</style>
@endpush

<div class="dashboard-container">

    <div class="hero-card">
        <div class="hero-content">
            <div class="hero-greeting">DASHBOARD ANALYTICS</div>
            <h1 class="hero-title">Welcome Back,<br>Owner Global Superstore.</h1>
            <p class="hero-sub">
                Memantau performa penjualan, profit, kategori produk, dan analisis segmentasi penjualan secara real-time untuk membantu pengambilan keputusan bisnis.
            </p>
            <div class="hero-buttons">
                <a href="#" class="hero-btn-primary">+ Lihat Data Analitik</a>
                <a href="#" class="hero-btn-secondary">Export Laporan</a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top"><div class="stat-label">Total Penjualan</div><div class="stat-icon"><i class="fas fa-wallet"></i></div></div>
            <div class="stat-value">$ {{ number_format($totalSales ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><div class="stat-label">Pesanan</div><div class="stat-icon"><i class="fas fa-box"></i></div></div>
            <div class="stat-value">{{ number_format($totalOrders ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><div class="stat-label">Pelanggan</div><div class="stat-icon"><i class="fas fa-users"></i></div></div>
            <div class="stat-value">{{ number_format($totalCustomers ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><div class="stat-label">Profit</div><div class="stat-icon"><i class="fas fa-chart-line"></i></div></div>
            <div class="stat-value">$ {{ number_format($totalProfit ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Kuantitas Terjual</div>
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            </div>
            <div class="stat-value">
                {{ number_format($totalQuantity ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-card">
            <h3>Tren Performa</h3>
            <div class="chart-container">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <h3>Kontribusi Penjualan per Kategori</h3>
            <p style="font-size:13px;color:var(--text-muted);margin-top:-10px;margin-bottom:18px;">
                Menampilkan persentase kontribusi penjualan dari setiap kategori produk.
            </p>
            <div class="chart-container">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <div class="section-divider">
        <h2><i class="fas fa-chart-bar" style="color: var(--primary-plum); margin-right: 8px;"></i> Analisis Segmentasi Penjualan</h2>
    </div>

    <div class="cluster-overview">
        <div class="cluster-card c0">
            <div class="cluster-badge c0">
                <span class="cluster-dot c0"></span>
                PERFORMA RENDAH
            </div>
            <div class="cluster-name">Segment Low Performance</div>
            <div class="cluster-desc">
                Kelompok transaksi dengan nilai sales dan profit rendah yang memerlukan evaluasi strategi bisnis lebih lanjut.
            </div>
            <div class="cluster-stats-row">
                <div class="cluster-stat-item">
                    <label>Total Produk</label>
                    <span>{{ $clusterStats[0]['count'] ?? 0 }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Penjualan</label>
                    <span>$ {{ number_format($clusterStats[0]['avg_sales'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Profit</label>
                    <span>$ {{ number_format($clusterStats[0]['avg_profit'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="cluster-card c1">
            <div class="cluster-badge c1">
                <span class="cluster-dot c1"></span>
                PERFORMA TINGGI
            </div>
            <div class="cluster-name">High Value Segment</div>
            <div class="cluster-desc">
                Kelompok transaksi dengan kontribusi sales dan profit tertinggi yang menjadi prioritas utama bisnis.
            </div>
            <div class="cluster-stats-row">
                <div class="cluster-stat-item">
                    <label>Total Produk</label>
                    <span>{{ $clusterStats[1]['count'] ?? 0 }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Penjualan</label>
                    <span>$ {{ number_format($clusterStats[1]['avg_sales'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Profit</label>
                    <span>$ {{ number_format($clusterStats[1]['avg_profit'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="cluster-card c2">
            <div class="cluster-badge c2">
                <span class="cluster-dot c2"></span>
                PERFORMA MENENGAH
            </div>
            <div class="cluster-name">Growth Segment</div>
            <div class="cluster-desc">
                Kelompok transaksi dengan performa stabil dan berpotensi meningkat melalui strategi pemasaran tambahan.
            </div>
            <div class="cluster-stats-row">
                <div class="cluster-stat-item">
                    <label>Total Produk</label>
                    <span>{{ $clusterStats[2]['count'] ?? 0 }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Penjualan</label>
                    <span>$ {{ number_format($clusterStats[2]['avg_sales'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="cluster-stat-item">
                    <label>Rata-rata Profit</label>
                    <span>$ {{ number_format($clusterStats[2]['avg_profit'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="cluster-visual-row">
        <div class="chart-card">
            <h3>Distribusi Penjualan & Profit</h3>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-dot c0"></div>
                    Low Performance
                </div>
                <div class="legend-item">
                    <div class="legend-dot c1"></div>
                    High Value Segment
                </div>
                <div class="legend-item">
                    <div class="legend-dot c2"></div>
                    Growth Segment
                </div>
            </div>
            <div class="chart-container">
                <canvas id="scatterChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3>Rekomendasi Bisnis</h3>
            <ul class="insight-list">
                <li class="insight-item">
                    <div class="insight-icon c0"><i class="fas fa-receipt" style="color: var(--cluster-0);"></i></div>
                    <div class="insight-text">
                        <strong>Performa Rendah Produk</strong>
                        Evaluasi strategi promosi, optimasi harga, atau lakukan bundling untuk meningkatkan performa penjualan.
                    </div>
                </li>
                <li class="insight-item">
                    <div class="insight-icon c1"><i class="fas fa-star" style="color: var(--cluster-1);"></i></div>
                    <div class="insight-text">
                        <strong>Performa Unggul Produk</strong>
                        Prioritaskan stok dan tingkatkan exposure produk untuk mempertahankan profitabilitas bisnis.
                    </div>
                </li>
                <li class="insight-item">
                    <div class="insight-icon c2"><i class="fas fa-rocket" style="color: var(--cluster-2);"></i></div>
                    <div class="insight-text">
                        <strong>Potensi Pengembangan Produk</strong>
                        Produk memiliki potensi berkembang melalui strategi upselling, cross-selling, and campaign marketing tambahan.
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    // 1. Inisialisasi Data dari Laravel (Aman Terhadap Objek/Array Koleksi)
    const rawScatterData = {!! json_encode($scatterData ?? []) !!};
    
    // FIX UTAMA: Jika data berbentuk Objek JSON, konversi paksa ke Array agar fungsionalitas .filter() aktif
    const normalizedScatter = Array.isArray(rawScatterData) ? rawScatterData : Object.values(rawScatterData);

    const chartLabelsData = {!! json_encode($chartLabels ?? []) !!};
    const salesDataPoints = {!! json_encode($salesData ?? []) !!};
    const profitDataPoints = {!! json_encode($profitData ?? []) !!};

    /* ---- 2. Render Performance Line Chart ---- */
    const ctxPerf = document.getElementById('performanceChart').getContext('2d');
    const perfGrad = ctxPerf.createLinearGradient(0, 0, 0, 300);
    perfGrad.addColorStop(0, 'rgba(255,92,168,0.3)');
    perfGrad.addColorStop(1, 'rgba(93,51,64,0.0)');

    new Chart(ctxPerf, {
        type: 'line',
        data: {
            labels: chartLabelsData.length ? chartLabelsData : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                {
                    label: 'Monthly Sales',
                    data: salesDataPoints,
                    borderColor: '#FF5CA8',
                    borderWidth: 4,
                    pointBackgroundColor: '#5D3340',
                    fill: true,
                    backgroundColor: perfGrad,
                    tension: 0.35
                },
                {
                    label: 'Monthly Profit',
                    data: profitDataPoints,
                    borderColor: '#2A7D6F',
                    borderWidth: 4,
                    pointBackgroundColor: '#2A7D6F',
                    fill: false,
                    tension: 0.35
                }
            ]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: true, position: 'top' } 
            },
            scales: {
                x: { grid: { display: false } },
                y: { 
                    grid: { color: '#f8e9ef' }, 
                    ticks: { callback: v => '$' + Number(v).toLocaleString() } 
                }
            }
        }
    });

    /* ---- 3. Render Category Donut Chart ---- */
    new Chart(document.getElementById('categoryChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels ?? []) !!},
            datasets: [{
                data: {!! json_encode($categoryData ?? []) !!},
                backgroundColor: ['#5D3340','#8B4D66','#FF5CA8','#D98BB0'],
                borderWidth: 2, borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { family: 'Poppins', size: 11 }, color: '#3A2030', usePointStyle: true, padding: 15 }
                }
            },
            cutout: '70%'
        }
    });

    /* ---- 4. K-Means Scatter Chart ---- */
    const colors = ['#5D3340', '#FF5CA8', '#2A7D6F'];
    
    // FIX SINKRONISASI LEGENDA: Menyelaraskan teks label chart legand dengan nama di komponen HTML atas
    const names  = ['Low Performance', 'High Value Segment', 'Growth Segment'];

    // Lakukan mapping dataset koordinat x dan y berdasarkan cluster 0, 1, dan 2
    const clusterDatasets = [0, 1, 2].map(ci => {
        const filteredPoints = normalizedScatter
            .filter(d => parseInt(d.cluster, 10) === ci)
            .map(d => ({
                x: parseFloat(d.sales) || 0,
                y: parseFloat(d.profit) || 0
            }));

        return {
            label: names[ci],
            data: filteredPoints,
            backgroundColor: colors[ci] + 'CC', // Tambah opasitas warna titik
            borderColor: colors[ci],
            borderWidth: 1.5,
            pointRadius: 5,
            pointHoverRadius: 8,
            showLine: false
        };
    });

    const scatterCanvas = document.getElementById('scatterChart');
    if (scatterCanvas) {
        new Chart(scatterCanvas.getContext('2d'), {
            type: 'scatter',
            data: { datasets: clusterDatasets },
            options: {
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda default Chart.js agar tidak double dengan HTML di atas canvas
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Sales: $' + context.parsed.x.toLocaleString() + ' | Profit: $' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Sales ($)', color: '#A08090', font: { family: 'Poppins', size: 12, weight: '600' } },
                        grid: { color: '#f8e9ef' },
                        ticks: { callback: v => '$' + Number(v).toLocaleString() }
                    },
                    y: {
                        title: { display: true, text: 'Profit ($)', color: '#A08090', font: { family: 'Poppins', size: 12, weight: '600' } },
                        grid: { color: '#f8e9ef' },
                        ticks: { callback: v => '$' + Number(v).toLocaleString() }
                    }
                }
            }
        });
    }
});
</script>
@endpush

@endsection