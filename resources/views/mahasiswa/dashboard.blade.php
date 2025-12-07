@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="fas fa-home me-2" style="color: #4FC3F7;"></i>
            Dashboard Mahasiswa
        </h2>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <i class="fas fa-file-alt" style="color: #4FC3F7;"></i>
            <h3>{{ $proposals->count() }}</h3>
            <p>Total Proposal Diajukan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <i class="fas fa-clock" style="color: #FFA726;"></i>
            <h3>{{ $proposals->where('status', 'menunggu_penetapan')->count() }}</h3>
            <p>Menunggu Penetapan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <i class="fas fa-check-circle" style="color: #66BB6A;"></i>
            <h3>{{ $proposals->where('status', 'pembimbing_ditentukan')->count() }}</h3>
            <p>Sudah Ditetapkan</p>
        </div>
    </div>
</div>

<!-- Action Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border: 3px dashed #4FC3F7;">
            <div class="card-body text-center py-5">
                <i class="fas fa-plus-circle fa-5x mb-3" style="color: #4FC3F7;"></i>
                <h3 class="mb-3">Ajukan Proposal Tugas Akhir Anda</h3>
                <p class="text-muted mb-4" style="max-width: 600px; margin: 0 auto;">
                    Mulai ajukan judul proposal tugas akhir Anda sekarang! Sistem akan secara otomatis 
                    mencocokkan dengan dosen pembimbing yang sesuai berdasarkan bidang keahlian.
                </p>
                <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i> Ajukan Proposal Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Proposal -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i> Daftar Proposal Saya</span>
                <span class="badge bg-light text-dark">{{ $proposals->count() }} Proposal</span>
            </div>
            <div class="card-body">
                @if($proposals->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                        <h5 class="text-muted">Belum Ada Proposal</h5>
                        <p class="text-muted">Anda belum mengajukan proposal tugas akhir</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Judul Proposal</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Dosen Pembimbing</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proposals as $index => $proposal)
                                <tr>
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <strong class="d-block mb-1">{{ $proposal->judul }}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-tags me-1"></i>
                                            @foreach(array_slice($proposal->getKeywordsArray(), 0, 3) as $keyword)
                                                <span class="badge bg-light text-dark me-1">{{ $keyword }}</span>
                                            @endforeach
                                        </small>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $proposal->created_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">{{ $proposal->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>{!! $proposal->getStatusBadge() !!}</td>
                                    <td>
                                        @if($proposal->dosenPembimbing)
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p>Dosen Pembimbing 1:</p>
                                                    <strong class="d-block">{{ $proposal->dosenPembimbing->nama }}</strong><hr>
                                                    <p>Dosen Pembimbing 2:</p>
                                                    <strong class="d-block">{{ $proposal->dosenPembimbing2->nama ?? '-' }}</strong>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-hourglass-half me-1"></i>
                                                Belum ditentukan
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('mahasiswa.proposal.show', $proposal->id) }}" 
                                           class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
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

<!-- Info Card -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi
                </h5>
                <ul class="mb-0">
                    <li>Pastikan judul proposal Anda unik dan belum pernah digunakan</li>
                    <li>Isi kata kunci yang relevan untuk mendapatkan rekomendasi dosen terbaik</li>
                    <li>Status proposal akan diupdate setelah admin menetapkan dosen pembimbing</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>
                    Tips
                </h5>
                <ul class="mb-0">
                    <li>Konsultasikan ide proposal dengan dosen wali terlebih dahulu</li>
                    <li>Persiapkan abstrak yang jelas dan terstruktur</li>
                    <li>Upload dokumen proposal lengkap untuk mempercepat proses review</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection