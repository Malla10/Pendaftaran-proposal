@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('dosen.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-file-alt me-2"></i> Detail Proposal Mahasiswa
    </div>
    <div class="card-body">
        <!-- Info Mahasiswa -->
        <div class="alert alert-light border mb-4">
            <h5 class="fw-bold mb-3">Informasi Mahasiswa</h5>
            <div class="row">
                <div class="col-md-4">
                    <strong><i class="fas fa-user me-2"></i>Nama:</strong>
                    <p>{{ $proposal->mahasiswa->name }}</p>
                </div>
                <div class="col-md-4">
                    <strong><i class="fas fa-id-card me-2"></i>NIM:</strong>
                    <p>{{ $proposal->mahasiswa->nim }}</p>
                </div>
                <div class="col-md-4">
                    <strong><i class="fas fa-envelope me-2"></i>Email:</strong>
                    <p>{{ $proposal->mahasiswa->email }}</p>
                </div>
            </div>
        </div>

        <!-- Judul -->
        <h4 class="mb-4" style="color: #0277BD;">{{ $proposal->judul }}</h4>

        <!-- Info Proposal -->
        <div class="row mb-4">
            <div class="col-md-6">
                <strong><i class="fas fa-calendar me-2"></i>Tanggal Pengajuan:</strong>
                <p>{{ $proposal->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div class="col-md-6">
                <strong><i class="fas fa-calendar-check me-2"></i>Tanggal Ditetapkan:</strong>
                <p>{{ $proposal->assigned_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        <!-- Keywords -->
        <div class="mb-4">
            <strong><i class="fas fa-tags me-2"></i>Kata Kunci:</strong>
            <div class="mt-2">
                @foreach($proposal->getKeywordsArray() as $keyword)
                    <span class="badge bg-info me-1 mb-1" style="font-size: 1rem; padding: 8px 14px;">
                        {{ $keyword }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Abstrak -->
        <div class="mb-4">
            <strong><i class="fas fa-align-left me-2"></i>Abstrak:</strong>
            <p class="mt-2" style="text-align: justify; line-height: 1.8;">
                {{ $proposal->abstrak }}
            </p>
        </div>

        <!-- File -->
        @if($proposal->file_proposal)
        <div class="mb-4">
            <strong><i class="fas fa-file-pdf me-2"></i>Dokumen Proposal:</strong>
            <br>
            <a href="{{ Storage::url($proposal->file_proposal) }}" 
               class="btn btn-primary mt-2" target="_blank">
                <i class="fas fa-download me-2"></i>Download Proposal (PDF)
            </a>
        </div>
        @endif
    </div>
</div>
@endsection