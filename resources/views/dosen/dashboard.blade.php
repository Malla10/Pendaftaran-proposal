@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="fas fa-home me-2" style="color: #4FC3F7;"></i>
                Dashboard Dosen
            </h2>
            <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-users" style="color: #4FC3F7;"></i>
                <h3>{{ $stats['total_bimbingan'] }}</h3>
                <p>Total Mahasiswa Bimbingan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-user-check" style="color: #66BB6A;"></i>
                <h3>{{ $stats['kuota_tersisa'] }}</h3>
                <p>Kuota Tersisa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-chart-pie"
                    style="color: 
                @if ($stats['persentase_beban'] >= 80) #EF5350
                @elseif($stats['persentase_beban'] >= 60) #FFA726
                @else #66BB6A @endif"></i>
                <h3>{{ $stats['persentase_beban'] }}%</h3>
                <p>Beban Bimbingan</p>
            </div>
        </div>
    </div>

    <!-- Info Dosen -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-tie me-2"></i> Profil Dosen
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong><i class="fas fa-user me-2"></i>Nama:</strong>
                            <p>{{ $dosen->nama }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-id-card me-2"></i>NIDN:</strong>
                            <p>{{ $dosen->nidn }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-briefcase me-2"></i>Bidang:</strong>
                            <p>{{ $dosen->bidang_penelitian }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong><i class="fas fa-tags me-2"></i>Keywords:</strong>

                            <div class="mt-2 d-flex flex-wrap gap-2">
                                @foreach ($dosen->getKeywordsArray() as $kw)
                                    <span class="badge bg-info px-3 py-2 rounded-pill">
                                        {{ $kw }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Mahasiswa Bimbingan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users me-2"></i> Mahasiswa Bimbingan</span>
                    <span class="badge bg-light text-dark">{{ $mahasiswaBimbingan->count() }} Mahasiswa</span>
                </div>
                <div class="card-body">
                    @if ($mahasiswaBimbingan->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                            <h5 class="text-muted">Belum Ada Mahasiswa Bimbingan</h5>
                            <p class="text-muted">Anda belum memiliki mahasiswa bimbingan</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Mahasiswa</th>
                                        <th width="45%">Judul Proposal</th>
                                        <th width="15%">Tanggal Ditetapkan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mahasiswaBimbingan as $index => $proposal)
                                        <tr>
                                            <td class="fw-bold">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-circle fa-2x me-2" style="color: #4FC3F7;"></i>
                                                    <div>
                                                        <strong class="d-block">{{ $proposal->mahasiswa->name }}</strong>
                                                        <small class="text-muted">{{ $proposal->mahasiswa->nim }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong
                                                    class="d-block mb-1">{{ Str::limit($proposal->judul, 60) }}</strong>
                                                <small class="text-muted">
                                                    <i class="fas fa-tags me-1"></i>
                                                    {{ Str::limit($proposal->keywords, 40) }}
                                                </small>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $proposal->assigned_at->format('d M Y') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('dosen.proposal.show', $proposal->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
