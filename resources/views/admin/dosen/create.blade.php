@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-plus-circle me-2" style="color: #4FC3F7;"></i>
                Tambah Dosen Baru
            </h2>
            <p class="text-muted">Lengkapi formulir untuk menambah data dosen pembimbing</p>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i> Formulir Data Dosen
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.dosen.store') }}" method="POST">
                    @csrf

                    <!-- Nama Dosen -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap Dosen *
                        </label>
                        <input type="text" name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama') }}"
                               placeholder="Dr. Nama Lengkap Dosen, M.Kom" 
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
                                   value="{{ old('nidn') }}"
                                   placeholder="0123456789" 
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
                                   value="{{ old('email') }}"
                                   placeholder="dosen@example.com" 
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
                                   value="{{ old('username') }}"
                                   placeholder="username_dosen" 
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Username untuk login sistem</small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password *
                            </label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Bidang Penelitian -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-briefcase me-2 text-primary"></i>Bidang Penelitian *
                        </label>
                        <input type="text" name="bidang_penelitian" 
                               class="form-control @error('bidang_penelitian') is-invalid @enderror" 
                               value="{{ old('bidang_penelitian') }}"
                               placeholder="Contoh: Artificial Intelligence, Machine Learning" 
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
                               value="{{ old('keywords') }}"
                               placeholder="IoT, Sensor, Embedded System, Arduino, Smart Home" 
                               required>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-lightbulb me-1"></i>
                            <strong>PENTING:</strong> Pisahkan dengan koma (,). Keywords ini akan digunakan untuk matching dengan proposal mahasiswa.
                        </div>
                    </div>

                    <!-- Kuota Bimbingan -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>Kuota Bimbingan *
                        </label>
                        <input type="number" name="kuota_bimbingan" 
                               class="form-control @error('kuota_bimbingan') is-invalid @enderror" 
                               value="{{ old('kuota_bimbingan', 10) }}"
                               min="1" max="20" 
                               required>
                        @error('kuota_bimbingan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Maksimal mahasiswa yang dapat dibimbing (disarankan 5-15 mahasiswa)
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="alert" style="background: linear-gradient(135deg, #E1F5FE 0%, #B3E5FC 100%); border-left: 4px solid #4FC3F7;">
                        <h6 class="alert-heading fw-bold">
                            <i class="fas fa-info-circle me-2"></i>Informasi
                        </h6>
                        <ul class="mb-0">
                            <li>Semua field yang bertanda (*) wajib diisi</li>
                            <li>Keywords sangat penting untuk sistem rekomendasi otomatis</li>
                            <li>Dosen akan mendapat akun login dengan username dan password yang diinput</li>
                        </ul>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Data Dosen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection