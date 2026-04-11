@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── Stat cards ── */
.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .2s, box-shadow .2s;
    border-left: 4px solid transparent;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(0,0,0,.09); }
.stat-card.blue  { border-left-color: #3b82f6; }
.stat-card.green { border-left-color: #22c55e; }
.stat-card.amber { border-left-color: #f59e0b; }
.stat-card.red   { border-left-color: #ef4444; }
.stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.stat-val   { font-size: 1.8rem; font-weight: 700; color: #111827; line-height: 1; }
.stat-lbl   { font-size: 12px; color: #6b7280; margin-top: 4px; }

/* ── Chart card ── */
.chart-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 24px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
}
.chart-title {
    font-size: 14px; font-weight: 600; color: #111827; margin-bottom: 4px;
}
.chart-sub { font-size: 12px; color: #9ca3af; margin-bottom: 20px; }

/* ── Table card ── */
.dash-table-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
}
.dash-table-head {
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.dash-table-head h6 { font-size: 14px; font-weight: 600; color: #111827; margin: 0; }
.dash-table-head a  { font-size: 12px; color: #6b7280; text-decoration: none; }
.dash-table-head a:hover { color: #0d6efd; }
.dash-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.dash-table thead tr { background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
.dash-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; }
.dash-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { background: #f8fafc; }
.dash-table tbody td { padding: 12px 16px; vertical-align: middle; color: #374151; }

.badge-status { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-pending      { background: #fef9c3; color: #854d0e; }
.badge-disetujui    { background: #dcfce7; color: #166534; }
.badge-ditolak      { background: #fee2e2; color: #991b1b; }
.badge-dikembalikan { background: #dbeafe; color: #1e40af; }

/* ── Quick actions ── */
.qa-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 9px; font-size: 13px; font-weight: 500;
    text-decoration: none; transition: all .15s;
}
.qa-primary { background: #0d6efd; color: #fff !important; }
.qa-primary:hover { background: #0b5ed7; }
.qa-outline { background: #fff; color: #374151 !important; border: 1px solid #e5e7eb; }
.qa-outline:hover { background: #f8fafc; }
</style>
@endpush

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['total_buku'] }}</div>
                <div class="stat-lbl">Total Buku</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;">
                <i class="bi bi-arrow-left-right"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['total_peminjaman'] }}</div>
                <div class="stat-lbl">Total Peminjaman</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card amber">
            <div class="stat-icon" style="background:#fffbeb;color:#f59e0b;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['pending'] }}</div>
                <div class="stat-lbl">Menunggu Persetujuan</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card red">
            <div class="stat-icon" style="background:#fef2f2;color:#ef4444;">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['denda_belum_bayar'] }}</div>
                <div class="stat-lbl">Denda Belum Lunas</div>
            </div>
        </div>
    </div>
</div>

{{-- ── CHARTS ── --}}
<div class="row g-3 mb-4">
    {{-- Chart Peminjaman per bulan --}}
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-title">Peminjaman per Bulan</div>
            <div class="chart-sub">12 bulan terakhir</div>
            <canvas id="chartPinjam" height="100"></canvas>
        </div>
    </div>

    {{-- Donut status --}}
    <div class="col-lg-4">
        <div class="chart-card h-100 d-flex flex-column">
            <div class="chart-title">Status Peminjaman</div>
            <div class="chart-sub">Keseluruhan</div>
            <div class="d-flex align-items-center justify-content-center flex-grow-1">
                <canvas id="chartStatus" style="max-height:220px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Chart Denda per bulan --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-title">Total Denda per Bulan (Rp)</div>
            <div class="chart-sub">12 bulan terakhir</div>
            <canvas id="chartDenda" height="80"></canvas>
        </div>
    </div>
</div>

{{-- ── QUICK ACTIONS ── --}}
<div class="d-flex gap-2 flex-wrap mb-4">
    <a href="{{ route('admin.peminjaman.create') }}" class="qa-btn qa-primary">
        <i class="bi bi-plus-lg"></i> Tambah Peminjaman
    </a>
    <a href="{{ route('admin.peminjaman.index') }}" class="qa-btn qa-outline">
        <i class="bi bi-arrow-left-right"></i> Kelola Peminjaman
    </a>
    <a href="{{ route('admin.denda.index') }}" class="qa-btn qa-outline">
        <i class="bi bi-cash-coin"></i> Kelola Denda
    </a>
    <a href="{{ route('admin.buku.create') }}" class="qa-btn qa-outline">
        <i class="bi bi-book"></i> Tambah Buku
    </a>
</div>

{{-- ── TABEL PEMINJAMAN TERBARU ── --}}
<div class="dash-table-card">
    <div class="dash-table-head">
        <h6>Peminjaman Terbaru</h6>
        <a href="{{ route('admin.peminjaman.index') }}">Lihat semua →</a>
    </div>
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
                        <div class="fw-semibold">{{ $p->user->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $p->user->email }}</div>
                    </td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_request->format('d M Y') }}</td>
                    <td>
                        <span class="badge-status badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.peminjaman.show', $p) }}"
                           style="font-size:12px;color:#0d6efd;text-decoration:none;">
                            Detail →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:#9ca3af;">
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
const labels  = @json($chartLabels);
const pinjam  = @json($chartPinjam);
const denda   = @json($chartDenda);

// ── 1. Line chart peminjaman ──────────────────────────────────────────────
new Chart(document.getElementById('chartPinjam'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Peminjaman',
            data: pinjam,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1, precision: 0 },
                grid: { color: '#f1f5f9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// ── 2. Bar chart denda ────────────────────────────────────────────────────
new Chart(document.getElementById('chartDenda'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Total Denda (Rp)',
            data: denda,
            backgroundColor: 'rgba(239,68,68,.75)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + v.toLocaleString('id-ID'),
                },
                grid: { color: '#f1f5f9' }
            },
            x: { grid: { display: false } }
        }
    }
});

// ── 3. Donut status peminjaman ────────────────────────────────────────────
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
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        cutout: '68%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 11 }, padding: 12, boxWidth: 12 }
            }
        }
    }
});
</script>
@endpush
