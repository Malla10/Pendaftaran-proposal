@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="row">
    <!-- Left Column - Detail Proposal -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-alt me-2"></i> Detail Proposal
            </div>
            <div class="card-body">
                <!-- Judul -->
                <h4 class="mb-4" style="color: #0277BD;">{{ $proposal->judul }}</h4>
                
                <!-- Info Grid -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar fa-2x me-3" style="color: #4FC3F7;"></i>
                            <div>
                                <small class="text-muted d-block">Tanggal Pengajuan</small>
                                <strong>{{ $proposal->created_at->format('d F Y, H:i') }}</strong>
                                <br>
                                <small class="text-muted">{{ $proposal->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3" style="color: #4FC3F7;"></i>
                            <div>
                                <small class="text-muted d-block">Status Proposal</small>
                                {!! $proposal->getStatusBadge() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kata Kunci -->
                <div class="mb-4">
                    <h6 class="fw-bold">
                        <i class="fas fa-tags me-2"></i>Kata Kunci
                    </h6>
                    <div>
                        @foreach($proposal->getKeywordsArray() as $keyword)
                            <span class="badge bg-info me-2 mb-2" style="font-size: 1rem; padding: 8px 16px;">
                                {{ $keyword }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Abstrak -->
                <div class="mb-4">
                    <h6 class="fw-bold">
                        <i class="fas fa-align-left me-2"></i>Abstrak
                    </h6>
                    <p class="text-justify" style="text-align: justify; line-height: 1.8;">
                        {{ $proposal->abstrak }}
                    </p>
                </div>

                <!-- File Proposal -->
                @if($proposal->file_proposal)
                    <div class="mb-4">
                        <h6 class="fw-bold">
                            <i class="fas fa-file-pdf me-2"></i>Dokumen Proposal
                        </h6>
                        <a href="{{ Storage::url($proposal->file_proposal) }}" 
                           class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-download me-2"></i>Download Proposal (PDF)
                        </a>
                    </div>
                @endif

                <!-- Dosen Pembimbing yang Ditentukan -->
                @if($proposal->dosenPembimbing)
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle fa-3x me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-0">Dosen Pembimbing Telah Ditetapkan</h5>
                                <small>Ditetapkan pada: {{ $proposal->assigned_at->format('d F Y, H:i') }}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Dosen:</strong><br>
                                <span class="fs-5">{{ $proposal->dosenPembimbing->nama }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Bidang Penelitian:</strong><br>
                                <span>{{ $proposal->dosenPembimbing->bidang_penelitian }}</span>
                            </div>
                        </div>
                        @if($proposal->catatan_admin)
                            <hr>
                            <strong><i class="fas fa-comment me-2"></i>Catatan Admin:</strong>
                            <p class="mb-0 mt-2">{{ $proposal->catatan_admin }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Rekomendasi Dosen -->
    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <i class="fas fa-star me-2"></i> Rekomendasi Dosen Pembimbing
            </div>
            <div class="card-body">
                @if($proposal->status == 'menunggu_penetapan')
                    <div class="alert alert-info">
                        <i class="fas fa-hourglass-half me-2"></i>
                        <strong>Menunggu Admin</strong>
                        <p class="mb-0 mt-2">Admin sedang meninjau proposal Anda dan akan segera menetapkan dosen pembimbing.</p>
                    </div>
                @endif

                @forelse($proposal->recommendations as $index => $rec)
                    <div class="card mb-3 {{ $index == 0 ? 'border-warning' : 'border-light' }}" 
                         style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            @if($index == 0)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-crown me-1"></i>Rekomendasi Terbaik
                                    </span>
                                    <span class="badge" style="background: linear-gradient(135deg, #4FC3F7, #29B6F6);">
                                        Rank #{{ $rec->rank }}
                                    </span>
                                </div>
                            @else
                                <div class="text-end mb-2">
                                    <span class="badge bg-secondary">Rank #{{ $rec->rank }}</span>
                                </div>
                            @endif
                            
                            <!-- Nama Dosen -->
                            <h6 class="fw-bold mb-2" style="color: #0277BD;">
                                {{ $rec->dosen->nama }}
                            </h6>
                            
                            <!-- Bidang -->
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                <i class="fas fa-briefcase me-1"></i>
                                {{ $rec->dosen->bidang_penelitian }}
                            </p>

                            <!-- Skor Kecocokan -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="fw-bold">Skor Kecocokan</small>
                                    <small class="fw-bold">{{ round($rec->match_score) }}%</small>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" 
                                         style="width: {{ $rec->match_score }}%; 
                                                background: linear-gradient(90deg, #4FC3F7, #29B6F6);"
                                         role="progressbar">
                                        {{ round($rec->match_score) }}%
                                    </div>
                                </div>
                            </div>

                            <!-- Info Kuota -->
                            <div class="d-flex justify-content-between mb-3">
                                <small>
                                    <i class="fas fa-users me-1"></i>
                                    Kuota Tersisa
                                </small>
                                <small class="fw-bold">
                                    {{ $rec->dosen->getSisaKuota() }}/{{ $rec->dosen->kuota_bimbingan }}
                                </small>
                            </div>

                            <!-- Rating Stars -->
                            <div class="text-center mb-3" style="font-size: 1.5rem; color: #FFA726;">
                                {{ $rec->getStarRating() }}
                            </div>

                            <!-- Keywords Dosen -->
                            <div>
                                <small class="text-muted fw-bold">Keahlian:</small>
                                <div class="mt-2">
                                    @foreach(array_slice($rec->dosen->getKeywordsArray(), 0, 5) as $kw)
                                        <span class="badge bg-secondary mb-1" style="font-size: 0.75rem;">
                                            {{ $kw }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-3x mb-3" style="color: #E0E0E0;"></i>
                        <p class="text-muted">Belum ada rekomendasi dosen</p>
                    </div>
                @endforelse

                <!-- Info Box -->
                <div class="alert alert-light mt-3">
                    <small>
                        <i class="fas fa-lightbulb me-1"></i>
                        <strong>Catatan:</strong> Rekomendasi dosen dihitung berdasarkan kecocokan kata kunci dan ketersediaan kuota bimbingan.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection