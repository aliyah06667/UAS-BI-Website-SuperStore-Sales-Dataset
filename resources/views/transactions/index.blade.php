@php
$current_page = request()->segment(1) ?? 'orders';
// Menggunakan nama variabel $csvLogs agar sesuai dengan konteks riwayat file
$csvLogs = $csvLogs ?? $sales ?? [];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Impor Transaksi — SerbaSerbi.</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-plum: #5D3340;
            --dark-plum:    #4A2433;
            --accent-pink:  #FF5CA8;
            --glow-pink:    rgba(255, 92, 168, 0.30);
            --soft-pink:    #F9DCE7;
            --soft-rose:    #F5E4EA;
            --lavender:     #E9DFFF;
            --mint:         #DDF7EA;
            --bg-base:      #FFF9FB;
            --text-dark:    #3A2C32;
            --text-soft:    #9A8E94;
            --shadow-card:  0 12px 40px rgba(93,51,64,0.09);
            --shadow-hover: 0 20px 55px rgba(93,51,64,0.14);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(85px);
        }
        .blob-1 { width: 300px; height: 300px; background: radial-gradient(#FFB3D4, #FF5CA8); top: -140px; right: 5%;  opacity: .50; }
        .blob-2 { width: 350px; height: 350px; background: radial-gradient(#E9DFFF, #C5AAFF); bottom: 5%; left: -80px; opacity: .45; }
        .blob-3 { width: 280px; height: 280px; background: radial-gradient(#FFE1D6, #FFB89A); top: 48%; right: -60px; opacity: .40; }

        .main-content {
            flex: 1;
            padding: 2.5rem 2.8rem 3.5rem;
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.2rem;
            flex-wrap: wrap;
            gap: 1.2rem;
        }
        .page-title {
            font-size: 2.7rem;
            font-weight: 800;
            color: var(--primary-plum);
            line-height: 1.0;
            letter-spacing: -2px;
        }
        .page-subtitle {
            font-size: .9rem;
            color: var(--text-soft);
            font-weight: 400;
            margin-top: 6px;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .search-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .search-icon {
            position: absolute;
            left: 16px;
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--primary-plum);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: .8rem;
            pointer-events: none;
            z-index: 2;
        }
        .search-input {
            font-family: 'Poppins', sans-serif;
            font-size: .85rem;
            color: var(--text-dark);
            background: #fff;
            border: 1.5px solid rgba(255,92,168,0.28);
            border-radius: 15px;
            padding: 11px 22px 11px 60px;
            width: 280px;
            outline: none;
            box-shadow: 0 6px 20px rgba(255,92,168,0.08);
            transition: all .3s;
        }
        .search-input:focus {
            border-color: var(--accent-pink);
            box-shadow: 0 6px 24px rgba(255,92,168,0.18);
        }
        .search-input::placeholder { color: var(--text-soft); }

        .btn-add {
            font-family: 'Poppins', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            color: #fff;
            background: var(--primary-plum);
            border: none;
            border-radius: 15px;
            padding: 12px 26px;
            cursor: pointer;
            box-shadow: 0 10px 28px rgba(93,51,64,0.28), 0 0 20px var(--glow-pink);
            transition: all .3s cubic-bezier(.34,1.56,.64,1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-add:hover {
            transform: translateY(-3px) scale(1.02);
            color: #fff;
            box-shadow: 0 16px 36px rgba(93,51,64,0.32), 0 0 30px var(--glow-pink);
        }

        .stat-card {
            background: #fff;
            border-radius: 26px;
            padding: 24px 22px 20px;
            border: 1.5px solid rgba(249,220,231,0.85);
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: all .38s cubic-bezier(.34,1.56,.64,1);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 26px;
            background: radial-gradient(circle at 85% 15%, rgba(255,92,168,0.07), transparent 55%);
            pointer-events: none;
        }
        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-hover), 0 0 28px rgba(255,92,168,0.12);
            border-color: rgba(255,92,168,0.32);
        }

        .stat-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-soft);
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-plum);
            line-height: 1;
        }
        .stat-icon-wrap {
            width: 44px; height: 44px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            margin-bottom: 14px;
            transition: all .35s;
        }
        .stat-card:hover .stat-icon-wrap { transform: rotate(10deg) scale(1.1); }

        .table-card {
            background: #fff;
            border-radius: 32px;
            padding: 28px 28px 22px;
            border: 1.5px solid rgba(249,220,231,0.75);
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
        }

        .card-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.6rem;
            flex-wrap: wrap;
            gap: .8rem;
        }
        .card-h { font-size: 1.05rem; font-weight: 700; color: var(--primary-plum); }
        .card-sub { font-size: .75rem; color: var(--text-soft); margin-top: 2px; }

        .tbl { width: 100%; border-collapse: collapse; }
        .tbl thead tr th {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary-plum);
            padding: 0 16px 14px;
            border: none;
            white-space: nowrap;
        }
        .tbl tbody tr { transition: background .25s; cursor: pointer; }
        .tbl tbody tr:hover { background: rgba(255,92,168,0.04); }
        .tbl tbody td {
            padding: 14px 16px;
            border-top: 1px solid rgba(249,220,231,0.55);
            font-size: .84rem;
            vertical-align: middle;
        }

        .file-id-badge { font-weight: 700; color: var(--accent-pink); font-size: .82rem; }
        .file-wrap { display: flex; align-items: center; gap: 10px; }
        
        .file-icon-avatar {
            width: 36px; height: 36px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff;
            flex-shrink: 0;
            background: linear-gradient(135deg, #5D3340 0%, #C5AAFF 100%);
            box-shadow: 0 4px 10px rgba(93, 51, 64, 0.15);
        }
        
        .file-name { font-weight: 600; font-size: .85rem; color: var(--text-dark); word-break: break-all; }
        .row-count { font-weight: 700; color: var(--text-dark); }
        .file-size { color: var(--text-soft); font-size: .8rem; }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: .72rem;
            font-weight: 600;
        }
        .status-badge.sukses { background: rgba(45, 206, 137, 0.12); color: #2dce89; }
        .status-badge.gagal { background: rgba(245, 54, 92, 0.12); color: #f5365c; }

        .date-txt { font-size: .8rem; color: var(--text-soft); white-space: nowrap; }

        /* ===== CUSTOM MODAL STYLING ===== */
        .modal-content { border-radius: 28px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); background: #FFF9FB; }
        .modal-header { border-bottom: 1px solid rgba(249,220,231,0.8); padding: 1.5rem 2rem; }
        .modal-title { font-weight: 800; color: var(--primary-plum); letter-spacing: -0.5px; }
        .modal-body { padding: 2rem; }
        .modal-footer { border-top: 1px solid rgba(249,220,231,0.8); padding: 1.2rem 2rem; }
        .file-drop-zone {
            border: 2px dashed rgba(255,92,168,0.4);
            border-radius: 20px;
            background: #fff;
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .file-drop-zone:hover { border-color: var(--accent-pink); background: rgba(255,92,168,0.02); }

        .pagination-wrap {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
            margin-top: 1.6rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(249,220,231,0.5);
        }
        .pg-btn {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            border: 1.5px solid rgba(249,220,231,0.9);
            background: #fff;
            color: var(--text-soft);
            cursor: pointer;
            transition: all .25s cubic-bezier(.34,1.56,.64,1);
            text-decoration: none;
            user-select: none;
        }
        .pg-btn:hover:not(.disabled) {
            border-color: var(--accent-pink);
            color: var(--accent-pink);
            transform: translateY(-2px);
        }
        .pg-btn.disabled { opacity: 0.4; cursor: not-allowed; background: #f5f5f5; }
        .pg-btn.active {
            background: var(--primary-plum);
            color: #fff;
            border-color: var(--primary-plum);
            box-shadow: 0 6px 16px rgba(93,51,64,0.25);
        }
        .pg-info { font-size: .78rem; color: var(--text-soft); margin-right: auto; }
    </style>
</head>
<body>

@include('layouts.sidebar')

<div class="wrapper">
    <div class="page-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="main-content">
        <!-- PAGE HEADER -->
        <div class="page-header" data-aos="fade-down" data-aos-duration="700">
            <div>
                <h1 class="page-title">Impor Transaksi</h1>
                <p class="page-subtitle">Kelola berkas riwayat data penjualan berbasis CSV.</p>
            </div>
            <div class="header-controls" data-aos="fade-up" data-aos-duration="700">
                <div class="search-wrap">
                    <div class="search-icon"><i class="fas fa-search"></i></div>
                    <input type="text" id="fileSearch" class="search-input" placeholder="Cari nama berkas CSV...">
                </div>
                <!-- Trigger Modal via Bootstrap -->
                <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                    <i class="fas fa-cloud-upload-alt"></i> Unggah CSV
                </button>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="80">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap mb-0" style="background:rgba(255,92,168,0.11);color:var(--accent-pink);">
                            <i class="fas fa-file-csv"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Berkas Diimpor</div>
                            <div class="stat-value">{{ count($csvLogs) }} Berkas</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="160">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrap mb-0" style="background:rgba(180,140,255,0.13);color:#9B72FF;">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <div class="stat-label">Status Integrasi Sistem</div>
                            <div class="stat-value" style="font-size: 1.5rem; color:#2dce89;"><i class="fas fa-check-circle"></i> Terhubung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="table-card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-title-row">
                <div>
                    <div class="card-h">Riwayat Unggah Dokumen</div>
                    <div class="card-sub">Daftar berkas data transaksi yang telah masuk ke basis data</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="tbl" id="csvLogTable">
                    <thead>
                        <tr>
                            <th>ID Berkas</th>
                            <th>Nama Berkas</th>
                            <th>Total Baris</th>
                            <th>Ukuran</th>
                            <th>Status Eksekusi</th>
                            <th>Tanggal Diunggah</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($csvLogs) > 0)
                        @foreach($csvLogs as $row)
                            <tr data-filename="{{ strtolower($row->file_name ?? '') }}">
                                <td><span class="file-id-badge">#{{ $row->id ?? '—' }}</span></td>
                                <td>
                                    <div class="file-wrap">
                                        <div class="file-icon-avatar"><i class="fas fa-file-alt"></i></div>
                                        <span class="file-name">{{ $row->file_name ?? 'unnamed_batch.csv' }}</span>
                                    </div>
                                </td>
                                <td><span class="row-count">{{ number_format($row->row_count ?? 0, 0, ',', '.') }} Baris</span></td>
                                <td><span class="file-size">{{ $row->file_size ?? '— KB' }}</span></td>
                                <td>
                                    @if(($row->status ?? 'sukses') == 'sukses')
                                        <span class="status-badge sukses">Berhasil</span>
                                    @else
                                        <span class="status-badge gagal">Gagal</span>
                                    @endif
                                </td>
                                <td><span class="date-txt">{{ $row->created_at ?? $row->order_date ?? '—' }}</span></td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="no-data-row">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open d-block mb-3 fs-3"></i>
                                Belum ada riwayat unggahan berkas CSV.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="pagination-wrap">
                <span class="pg-info" id="paginationInfo">Menampilkan 0 dari 0 berkas</span>
                <button type="button" class="pg-btn" id="btnPrev"><i class="fas fa-chevron-left" style="font-size:.7rem;"></i></button>
                <div id="pageNumbers" class="d-flex gap-1"></div>
                <button type="button" class="pg-btn" id="btnNext"><i class="fas fa-chevron-right" style="font-size:.7rem;"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL UPLOAD CSV ===== -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCsvModalLabel"><i class="fas fa-file-csv text-pink me-2"></i>Unggah Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Pastikan format kolom berkas CSV Anda telah sesuai dengan aturan standardisasi database transaksi.</p>
                    
                    <!-- Area Input File -->
                    <div class="file-drop-zone" onclick="document.getElementById('csv_file').click()">
                        <i class="fas fa-cloud-upload-alt mb-3 fs-1 text-muted" style="color: var(--primary-plum) !important;"></i>
                        <h6 class="mb-1 fw-bold">Pilih berkas atau seret ke sini</h6>
                        <p class="text-muted small mb-0">Hanya menerima format file .csv (Maks. **1MB**)</p>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" class="d-none" required onchange="updateFileNameText(this)">
                    </div>
                    <div id="file-chosen-preview" class="text-center mt-3 fw-bold small text-muted d-none">
                        Terpilih: <span id="file-name-text" class="text-dark"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" style="border-radius:12px; font-weight:600;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-add py-2 px-4 border-0">Mulai Proses Impor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
// Fungsi pembantu memperbarui preview teks nama file terpilih di modal
function updateFileNameText(input) {
    const previewContainer = document.getElementById('file-chosen-preview');
    const nameSpan = document.getElementById('file-name-text');
    if(input.files && input.files.length > 0) {
        nameSpan.textContent = input.files[0].name;
        previewContainer.classList.remove('d-none');
    } else {
        previewContainer.classList.add('d-none');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    AOS.init({ duration: 800, once: true, easing: 'ease-out-back' });

    const searchInput = document.getElementById('fileSearch');
    const tableRows = Array.from(document.querySelectorAll('#csvLogTable tbody tr:not(.no-data-row)'));
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const pageNumbersContainer = document.getElementById('pageNumbers');
    
    const rowsPerPage = 10;
    let currentPage = 1;
    let filteredRows = [...tableRows];

    function displayTable() {
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
        
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        tableRows.forEach(row => row.style.display = 'none');

        filteredRows.slice(start, end).forEach(row => {
            row.style.display = '';
        });

        const infoSpan = document.getElementById('paginationInfo');
        if (infoSpan) {
            const visibleStart = totalRows === 0 ? 0 : start + 1;
            const visibleEnd = end > totalRows ? totalRows : end;
            infoSpan.textContent = `Menampilkan ${visibleStart}-${visibleEnd} dari ${totalRows} berkas`;
        }

        btnPrev.classList.toggle('disabled', currentPage === 1);
        btnNext.classList.toggle('disabled', currentPage === totalPages);

        pageNumbersContainer.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.className = `pg-btn ${i === currentPage ? 'active' : ''}`;
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', () => {
                currentPage = i;
                displayTable();
            });
            pageNumbersContainer.appendChild(pageBtn);
        }
    }

    function handleSearch() {
        const searchText = searchInput.value.toLowerCase().trim();

        filteredRows = tableRows.filter(row => {
            const fileName = row.getAttribute('data-filename') || '';
            return fileName.includes(searchText);
        });

        currentPage = 1;
        displayTable();
    }

    searchInput.addEventListener('input', handleSearch);

    btnPrev.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            displayTable();
        }
    });

    btnNext.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++;
            displayTable();
        }
    });

    displayTable();
});
</script>
</body>
</html>