@extends('layouts.app')

@section('title', 'Ajukan Proposal')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-file-alt me-2" style="color: #4FC3F7;"></i>
                Formulir Pengajuan Proposal
            </h2>
            <p class="text-muted">Lengkapi formulir di bawah untuk mengajukan proposal tugas akhir Anda</p>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i> Form Pengajuan Proposal Tugas Akhir
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul Proposal -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-heading me-2 text-primary"></i>Judul Proposal *
                        </label>
                        <input type="text" name="judul" 
                               class="form-control form-control-lg @error('judul') is-invalid @enderror" 
                               value="{{ old('judul') }}" 
                               placeholder="Contoh: Sistem Informasi Manajemen Perpustakaan Berbasis Web dengan Teknologi IoT" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Judul harus unik, spesifik, dan menggambarkan topik penelitian Anda
                        </div>
                    </div>

                    <!-- Abstrak -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-align-left me-2 text-primary"></i>Abstrak Proposal *
                        </label>
                        <textarea name="abstrak" rows="8" 
                                  class="form-control @error('abstrak') is-invalid @enderror" 
                                  placeholder="Jelaskan latar belakang masalah, tujuan penelitian, metodologi, dan hasil yang diharapkan dari penelitian Anda. Minimal 100 karakter."
                                  required>{{ old('abstrak') }}</textarea>
                        @error('abstrak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Minimal 100 karakter. Jelaskan secara ringkas namun jelas tentang penelitian Anda.
                        </div>
                    </div>

                    <!-- Keywords -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tags me-2 text-primary"></i>Kata Kunci (Keywords) *
                        </label>
                        <input type="text" name="keywords" 
                               class="form-control @error('keywords') is-invalid @enderror" 
                               value="{{ old('keywords') }}" 
                               placeholder="Contoh: IoT, Sensor, Embedded System, Arduino, Smart Home"
                               required>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-lightbulb me-1"></i>
                            <strong>PENTING:</strong> Pisahkan dengan koma (,). Kata kunci ini akan dicocokkan dengan bidang keahlian dosen untuk memberikan rekomendasi pembimbing terbaik.
                        </div>
                        
                        <!-- Keyword Examples -->
                        <div class="mt-2">
                            <small class="text-muted fw-bold">Contoh kata kunci berdasarkan bidang:</small>
                            <div class="mt-2">
                                <span class="badge bg-info me-1">IoT</span>
                                <span class="badge bg-info me-1">Mobile App</span>
                                <span class="badge bg-info me-1">Web Development</span>
                                <span class="badge bg-info me-1">Machine Learning</span>
                                <span class="badge bg-info me-1">Data Mining</span>
                                <span class="badge bg-info me-1">Sistem Informasi</span>
                                <span class="badge bg-info me-1">Database</span>
                                <span class="badge bg-info me-1">AI</span>
                                <span class="badge bg-info me-1">Network Security</span>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-file-pdf me-2 text-primary"></i>Upload Dokumen Proposal (Opsional)
                        </label>
                        <input type="file" name="file_proposal" 
                               class="form-control @error('file_proposal') is-invalid @enderror" 
                               accept=".pdf">
                        @error('file_proposal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: PDF, Maksimal 5MB. Upload dokumen proposal lengkap jika sudah tersedia.
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="alert" style="background: linear-gradient(135deg, #E1F5FE 0%, #B3E5FC 100%); border-left: 4px solid #4FC3F7;">
                        <h6 class="alert-heading fw-bold">
                            <i class="fas fa-robot me-2"></i>Sistem Rekomendasi Otomatis
                        </h6>
                        <p class="mb-0">
                            Setelah submit, sistem akan <strong>otomatis mencocokkan</strong> kata kunci proposal Anda 
                            dengan bidang penelitian dosen dan memberikan <strong>3-5 rekomendasi dosen pembimbing terbaik</strong> 
                            berdasarkan tingkat kecocokan dan ketersediaan kuota.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Submit Proposal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            Tips Mengisi Proposal
                        </h5>
                        <ul class="mb-0">
                            <li>Pilih judul yang spesifik dan sesuai dengan minat penelitian</li>
                            <li>Isi kata kunci yang relevan dengan topik proposal</li>
                            <li>Abstrak yang jelas membantu dosen memahami topik</li>
                            <li>Upload dokumen proposal lengkap untuk mempercepat review</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                            Perhatian
                        </h5>
                        <ul class="mb-0">
                            <li>Pastikan judul belum pernah digunakan mahasiswa lain</li>
                            <li>Data yang sudah disubmit tidak bisa diubah</li>
                            <li>Proses penetapan pembimbing memakan waktu 1-3 hari kerja</li>
                            <li>Anda akan mendapat notifikasi setelah pembimbing ditetapkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection