@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-edit me-2" style="color: #4FC3F7;"></i>
                Edit Data Dosen
            </h2>
            <p class="text-muted">Perbarui informasi dosen: <strong>{{ $dosen->nama }}</strong></p>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i> Formulir Edit Dosen
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Dosen -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap Dosen *
                        </label>
                        <input type="text" name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $dosen->nama) }}"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIDN & Email -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-id-card me-2 text-primary"></i>NIDN *
                            </label>
                            <input type="text" name="nidn" 
                                   class="form-control @error('nidn') is-invalid @enderror" 
                                   value="{{ old('nidn', $dosen->nidn) }}"
                                   required>
                            @error('nidn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email *
                            </label>
                            <input type="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $dosen->user->email) }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Username & Password -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-at me-2 text-primary"></i>Username *
                            </label>
                            <input type="text" name="username" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   value="{{ old('username', $dosen->user->username) }}"
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>
                    </div>

                    <!-- Bidang Penelitian -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-briefcase me-2 text-primary"></i>Bidang Penelitian *
                        </label>
                        <input type="text" name="bidang_penelitian" 
                               class="form-control @error('bidang_penelitian') is-invalid @enderror" 
                               value="{{ old('bidang_penelitian', $dosen->bidang_penelitian) }}"
                               required>
                        @error('bidang_penelitian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keywords -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tags me-2 text-primary"></i>Keywords (Kata Kunci) *
                        </label>
                        <input type="text" name="keywords" 
                               class="form-control @error('keywords') is-invalid @enderror" 
                               value="{{ old('keywords', $dosen->keywords) }}"
                               required>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-lightbulb me-1"></i>
                            Pisahkan dengan koma (,). Contoh: IoT, AI, Machine Learning
                        </div>
                    </div>

                    <!-- Kuota Bimbingan -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>Kuota Bimbingan *
                        </label>
                        <input type="number" name="kuota_bimbingan" 
                               class="form-control @error('kuota_bimbingan') is-invalid @enderror" 
                               value="{{ old('kuota_bimbingan', $dosen->kuota_bimbingan) }}"
                               min="1" max="20" 
                               required>
                        @error('kuota_bimbingan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Saat ini terpakai: <strong>{{ $dosen->kuota_terpakai }}</strong> mahasiswa
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="alert alert-warning">
                        <h6 class="alert-heading fw-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>Perhatian
                        </h6>
                        <ul class="mb-0">
                            <li>Pastikan data yang diubah sudah benar</li>
                            <li>Perubahan keywords akan mempengaruhi rekomendasi proposal baru</li>
                            <li>Kuota tidak boleh lebih kecil dari jumlah mahasiswa yang sedang dibimbing ({{ $dosen->kuota_terpakai }})</li>
                        </ul>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-save me-2"></i>Update Data Dosen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection