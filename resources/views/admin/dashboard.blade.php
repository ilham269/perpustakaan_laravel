@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── Greeting banner ── */
.greeting-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #6366f1 100%);
    border-radius: 16px;
    padding: 24px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.greeting-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
}
.greeting-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 160px; height: 160px;
    background: rgba(255,255,255,.04);
    border-radius: 50%;
}
.greeting-text h4 { font-size: 20px; font-weight: 700; color: #fff; margin: 0 0 4px; }
.greeting-text p  { font-size: 13px; color: rgba(255,255,255,.65); margin: 0; }
.greeting-date    { font-size: 12px; color: rgba(255,255,255,.5); margin-top: 8px; }
.greeting-icon    { font-size: 52px; opacity: .25; position: relative; z-index: 1; }

/* ── Stat cards ── */
.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .2s, box-shadow .2s;
    position: relative;
    overflow: hidden;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,.1); }
.stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 14px 14px 0 0;
}
.stat-card.blue::after  { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.stat-card.green::after { background: linear-gradient(90deg, #22c55e, #4ade80); }
.stat-card.amber::after { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.stat-card.red::after   { background: linear-gradient(90deg, #ef4444, #f87171); }

.stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
.stat-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
}
.stat-trend {
    font-size: 11px; font-weight: 600; padding: 3px 8px;
    border-radius: 20px; display: inline-flex; align-items: center; gap: 3px;
}
.stat-trend.up   { background: #dcfce7; color: #166534; }
.stat-trend.warn { background: #fef9c3; color: #854d0e; }
.stat-trend.down { background: #fee2e2; color: #991b1b; }

.stat-val { font-size: 2rem; font-weight: 800; color: #111827; line-height: 1; letter-spacing: -.03em; }
.stat-lbl { font-size: 12px; color: #6b7280; margin-top: 5px; font-weight: 500; }

/* ── Section header ── */
.section-hd {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
}
.section-hd-title {
    font-size: 14px; font-weight: 700; color: #111827;
    display: flex; align-items: center; gap: 8px;
}
.section-hd-title::before {
    content: '';
    width: 3px; height: 16px;
    background: linear-gradient(180deg, #6366f1, #818cf8);
    border-radius: 3px;
    display: inline-block;
}
.section-hd a { font-size: 12px; color: #6b7280; text-decoration: none; }
.section-hd a:hover { color: #6366f1; }

/* ── Chart card ── */
.chart-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    height: 100%;
}
.chart-card-title { font-size: 13px; font-weight: 700; color: #111827; }
.chart-card-sub   { font-size: 11px; color: #9ca3af; margin-top: 2px; margin-bottom: 18px; }

/* ── Quick actions ── */
.qa-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}
.qa-card {
    background: #fff;
    border: 1px solid #e8ecf4;
    border-radius: 12px;
    padding: 16px;
    display: flex; align-items: center; gap: 12px;
    text-decoration: none;
    transition: all .15s;
    cursor: pointer;
}
.qa-card:hover {
    border-color: #a5b4fc;
    box-shadow: 0 4px 16px rgba(99,102,241,.12);
    transform: translateY(-1px);
}
.qa-card-icon {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.qa-card-label { font-size: 13px; font-weight: 600; color: #374151; }
.qa-card-sub   { font-size: 11px; color: #9ca3af; margin-top: 1px; }

/* ── Table card ── */
.dash-table-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
}
.dash-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.dash-table thead tr { background: #f8fafc; }
.dash-table thead th {
    padding: 11px 16px; font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .05em; color: #9ca3af;
    border-bottom: 1px solid #f1f5f9;
}
.dash-table tbody tr { border-bottom: 1px solid #f8fafc; transition: background .1s; }
.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { background: #fafbff; }
.dash-table tbody td { padding: 13px 16px; vertical-align: middle; color: #374151; }

.badge-status { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-pending      { background: #fef9c3; color: #854d0e; }
.badge-disetujui    { background: #dcfce7; color: #166534; }
.badge-ditolak      { background: #fee2e2; color: #991b1b; }
.badge-dikembalikan { background: #dbeafe; color: #1e40af; }

/* ── User avatar in table ── */
.user-avatar-sm {
    width: 30px; height: 30px; border-radius: 50%;
    background: linear-gradient(135deg, #818cf8, #6366f1);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
}
</style>
@endpush

@section('content')

{{-- ── GREETING BANNER ── --}}
<div class="greeting-banner">
    <div class="greeting-text">
        <h4>Selamat datang, {{ Auth::user()->name }} 👋</h4>
        <p>Berikut ringkasan aktivitas perpustakaan hari ini.</p>
        <div class="greeting-date">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
    <i class="bi bi-book-half greeting-icon"></i>
</div>

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="stat-top">
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">
                    <i class="bi bi-book"></i>
                </div>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> Koleksi</span>
            </div>
            <div class="stat-val">{{ $stats['total_buku'] }}</div>
            <div class="stat-lbl">Total Buku</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="stat-top">
                <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <span class="stat-trend up"><i class="bi bi-arrow-up-short"></i> Aktif</span>
            </div>
            <div class="stat-val">{{ $stats['total_peminjaman'] }}</div>
            <div class="stat-lbl">Total Peminjaman</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card amber">
            <div class="stat-top">
                <div class="stat-icon" style="background:#fffbeb;color:#f59e0b;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                @if($stats['pending'] > 0)
                <span class="stat-trend warn"><i class="bi bi-exclamation"></i> Perlu aksi</span>
                @endif
            </div>
            <div class="stat-val">{{ $stats['pending'] }}</div>
            <div class="stat-lbl">Menunggu Persetujuan</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card red">
            <div class="stat-top">
                <div class="stat-icon" style="background:#fef2f2;color:#ef4444;">
                    <i class="bi bi-cash-coin"></i>
                </div>
                @if($stats['denda_belum_bayar'] > 0)
                <span class="stat-trend down"><i class="bi bi-exclamation"></i> Belum lunas</span>
                @endif
            </div>
            <div class="stat-val">{{ $stats['denda_belum_bayar'] }}</div>
            <div class="stat-lbl">Denda Belum Lunas</div>
        </div>
    </div>
</div>

{{-- ── CHARTS ── --}}
<div class="section-hd">
    <div class="section-hd-title">Statistik Bulanan</div>
</div>
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-card-title">Peminjaman per Bulan</div>
            <div class="chart-card-sub">12 bulan terakhir</div>
            <canvas id="chartPinjam" height="110"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card d-flex flex-column">
            <div class="chart-card-title">Distribusi Status</div>
            <div class="chart-card-sub">Semua peminjaman</div>
            <div class="d-flex align-items-center justify-content-center flex-grow-1" style="min-height:200px;">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-card-title">Akumulasi Denda per Bulan</div>
            <div class="chart-card-sub">Total nominal denda yang terbentuk (Rp)</div>
            <canvas id="chartDenda" height="75"></canvas>
        </div>
    </div>
</div>

{{-- ── QUICK ACTIONS ── --}}
<div class="section-hd">
    <div class="section-hd-title">Aksi Cepat</div>
</div>
<div class="qa-grid mb-4">
    <a href="{{ route('admin.peminjaman.create') }}" class="qa-card">
        <div class="qa-card-icon" style="background:#eef2ff;color:#6366f1;">
            <i class="bi bi-plus-circle"></i>
        </div>
        <div>
            <div class="qa-card-label">Tambah Pinjam</div>
            <div class="qa-card-sub">Buat transaksi baru</div>
        </div>
    </a>
    <a href="{{ route('admin.peminjaman.index') }}?status=pending" class="qa-card">
        <div class="qa-card-icon" style="background:#fffbeb;color:#f59e0b;">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div>
            <div class="qa-card-label">Pending</div>
            <div class="qa-card-sub">{{ $stats['pending'] }} menunggu</div>
        </div>
    </a>
    <a href="{{ route('admin.denda.index') }}" class="qa-card">
        <div class="qa-card-icon" style="background:#fef2f2;color:#ef4444;">
            <i class="bi bi-cash-coin"></i>
        </div>
        <div>
            <div class="qa-card-label">Kelola Denda</div>
            <div class="qa-card-sub">{{ $stats['denda_belum_bayar'] }} belum lunas</div>
        </div>
    </a>
    <a href="{{ route('admin.buku.index') }}" class="qa-card">
        <div class="qa-card-icon" style="background:#f0fdf4;color:#22c55e;">
            <i class="bi bi-book"></i>
        </div>
        <div>
            <div class="qa-card-label">Kelola Buku</div>
            <div class="qa-card-sub">{{ $stats['total_buku'] }} koleksi</div>
        </div>
    </a>
    <a href="{{ route('admin.catalog.index') }}" class="qa-card">
        <div class="qa-card-icon" style="background:#f0f9ff;color:#0ea5e9;">
            <i class="bi bi-collection"></i>
        </div>
        <div>
            <div class="qa-card-label">Katalog</div>
            <div class="qa-card-sub">Kelola kategori</div>
        </div>
    </a>
</div>

{{-- ── TABEL PEMINJAMAN TERBARU ── --}}
<div class="section-hd">
    <div class="section-hd-title">Peminjaman Terbaru</div>
    <a href="{{ route('admin.peminjaman.index') }}">Lihat semua →</a>
</div>
<div class="dash-table-card">
    <div class="table-responsive">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Request</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman_terbaru as $p)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="user-avatar-sm">{{ strtoupper(substr($p->user->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:13px;">{{ $p->user->name }}</div>
                                <div style="font-size:11px;color:#9ca3af;">{{ $p->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="max-width:200px;">
                        <div style="font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $p->buku->judul }}
                        </div>
                    </td>
                    <td style="color:#6b7280;font-size:12px;">{{ $p->tanggal_request->format('d M Y') }}</td>
                    <td>
                        <span class="badge-status badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.peminjaman.show', $p) }}"
                           style="font-size:12px;color:#6366f1;text-decoration:none;font-weight:500;">
                            Detail →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:3rem;color:#9ca3af;">
                        <i class="bi bi-inbox d-block fs-2 mb-2"></i>
                        Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.color = '#9ca3af';

const labels = @json($chartLabels);
const pinjam = @json($chartPinjam);
const denda  = @json($chartDenda);

// ── Line chart peminjaman ──────────────────────────────────────────────────
new Chart(document.getElementById('chartPinjam'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Peminjaman',
            data: pinjam,
            borderColor: '#6366f1',
            backgroundColor: (ctx) => {
                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 260);
                g.addColorStop(0, 'rgba(99,102,241,.18)');
                g.addColorStop(1, 'rgba(99,102,241,0)');
                return g;
            },
            borderWidth: 2.5,
            pointBackgroundColor: '#6366f1',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e1b4b',
                titleColor: '#a5b4fc',
                bodyColor: '#fff',
                padding: 10,
                cornerRadius: 8,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, precision: 0, font: { size: 11 } },
                grid: { color: '#f1f5f9' },
                border: { display: false }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } },
                border: { display: false }
            }
        }
    }
});

// ── Bar chart denda ────────────────────────────────────────────────────────
new Chart(document.getElementById('chartDenda'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Total Denda (Rp)',
            data: denda,
            backgroundColor: (ctx) => {
                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
                g.addColorStop(0, 'rgba(239,68,68,.85)');
                g.addColorStop(1, 'rgba(239,68,68,.35)');
                return g;
            },
            borderRadius: 7,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e1b4b',
                titleColor: '#fca5a5',
                bodyColor: '#fff',
                padding: 10,
                cornerRadius: 8,
                callbacks: { label: ctx => ' Rp ' + ctx.raw.toLocaleString('id-ID') }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { font: { size: 11 }, callback: v => 'Rp ' + (v/1000).toLocaleString('id-ID') + 'k' },
                grid: { color: '#f1f5f9' },
                border: { display: false }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } },
                border: { display: false }
            }
        }
    }
});

// ── Donut status ───────────────────────────────────────────────────────────
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Disetujui', 'Ditolak', 'Dikembalikan'],
        datasets: [{
            data: [
                {{ \App\Models\Peminjaman::where('status','pending')->count() }},
                {{ \App\Models\Peminjaman::where('status','disetujui')->count() }},
                {{ \App\Models\Peminjaman::where('status','ditolak')->count() }},
                {{ \App\Models\Peminjaman::where('status','dikembalikan')->count() }},
            ],
            backgroundColor: ['#fef9c3','#dcfce7','#fee2e2','#dbeafe'],
            borderColor:      ['#f59e0b','#22c55e','#ef4444','#3b82f6'],
            borderWidth: 2.5,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 11 }, padding: 14, boxWidth: 10, usePointStyle: true }
            },
            tooltip: {
                backgroundColor: '#1e1b4b',
                bodyColor: '#fff',
                padding: 10,
                cornerRadius: 8,
            }
        }
    }
});
</script>
@endpush
