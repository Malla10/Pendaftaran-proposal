@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="fas fa-chart-line me-2" style="color: #4FC3F7;"></i>
            Dashboard Admin
        </h2>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Kelola sistem pendaftaran proposal dengan mudah.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <i class="fas fa-file-alt" style="color: #4FC3F7;"></i>
            <h3>{{ $stats['total_proposals'] }}</h3>
            <p>Total Proposals</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <i class="fas fa-clock" style="color: #FFA726;"></i>
            <h3>{{ $stats['pending'] }}</h3>
            <p>Menunggu Penetapan</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <i class="fas fa-check-circle" style="color: #66BB6A;"></i>
            <h3>{{ $stats['assigned'] }}</h3>
            <p>Sudah Ditentukan</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <i class="fas fa-chalkboard-teacher" style="color: #AB47BC;"></i>
            <h3>{{ $stats['total_dosen'] }}</h3>
            <p>Total Dosen</p>
        </div>
    </div>
</div>

<!-- Quick Actions & Chart -->
<div class="row mb-4">
    <!-- Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2"></i> Beban Pembimbing Per Dosen
            </div>
            <div class="card-body">
                <canvas id="dosenBebanChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.proposals') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i> Lihat Semua Proposals
                    </a>
                    <a href="{{ route('admin.dosen.index') }}" class="btn btn-info">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Kelola Data Dosen
                    </a>
                    <a href="{{ route('admin.dosen.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Dosen Baru
                    </a>
                    <a href="{{ route('admin.logs') }}" class="btn btn-warning">
                        <i class="fas fa-clipboard-list me-2"></i> Activity Logs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Beban Dosen -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i> Daftar Dosen & Beban Bimbingan</span>
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-cog me-1"></i> Kelola
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Dosen</th>
                                <th width="25%">Bidang Penelitian</th>
                                <th width="10%">Kuota</th>
                                <th width="10%">Terpakai</th>
                                <th width="25%">Beban (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosenBeban as $index => $dosen)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle fa-2x me-2" style="color: #4FC3F7;"></i>
                                        <strong>{{ $dosen->nama }}</strong>
                                    </div>
                                </td>
                                <td>{{ $dosen->bidang_penelitian }}</td>
                                <td><span class="badge bg-primary">{{ $dosen->kuota_bimbingan }}</span></td>
                                <td><span class="badge bg-info">{{ $dosen->kuota_terpakai }}</span></td>
                                <td>
                                    <div class="progress" style="height: 30px;">
                                        <div class="progress-bar 
                                            @if($dosen->getPersentaseBeban() >= 80) bg-danger
                                            @elseif($dosen->getPersentaseBeban() >= 60) bg-warning
                                            @else bg-success
                                            @endif"
                                            style="width: {{ $dosen->getPersentaseBeban() }}%">
                                            <strong>{{ $dosen->getPersentaseBeban() }}%</strong>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x mb-2" style="color: #E0E0E0;"></i>
                                    <p class="text-muted mb-0">Belum ada data dosen</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dosenBebanChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dosenBeban->pluck('nama')) !!},
            datasets: [{
                label: 'Kuota Terpakai',
                data: {!! json_encode($dosenBeban->pluck('kuota_terpakai')) !!},
                backgroundColor: 'rgba(79, 195, 247, 0.8)',
                borderColor: 'rgba(79, 195, 247, 1)',
                borderWidth: 2
            }, {
                label: 'Kuota Total',
                data: {!! json_encode($dosenBeban->pluck('kuota_bimbingan')) !!},
                backgroundColor: 'rgba(41, 182, 246, 0.4)',
                borderColor: 'rgba(41, 182, 246, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            }
        }
    });
</script>
@endpush