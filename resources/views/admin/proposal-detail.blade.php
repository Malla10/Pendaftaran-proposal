@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('admin.proposals') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Proposals
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left: Detail Proposal -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-file-alt me-2"></i> Detail Proposal
                </div>
                <div class="card-body">
                    <!-- Mahasiswa Info -->
                    <div class="alert alert-light border">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-user me-2"></i>Nama Mahasiswa:</strong>
                                <p class="mb-2">{{ $proposal->mahasiswa->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-id-card me-2"></i>NIM:</strong>
                                <p class="mb-2">{{ $proposal->mahasiswa->nim }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-graduation-cap me-2"></i>Semester:</strong>
                                <p class="mb-2">{{ $proposal->mahasiswa->semester }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Judul -->
                    <h4 class="mb-4" style="color: #0277BD;">{{ $proposal->judul }}</h4>

                    <!-- Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong><i class="fas fa-calendar me-2"></i>Tanggal Pengajuan:</strong>
                            <p>{{ $proposal->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-info-circle me-2"></i>Status:</strong>
                            <p>{!! $proposal->getStatusBadge() !!}</p>
                        </div>
                    </div>

                    <!-- Keywords -->
                    <div class="mb-4">
                        <strong><i class="fas fa-tags me-2"></i>Kata Kunci:</strong>
                        <div class="mt-2">
                            @foreach ($proposal->getKeywordsArray() as $keyword)
                                <span class="badge bg-info me-1 mb-1" style="font-size: 0.95rem; padding: 8px 14px;">
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
                    @if ($proposal->file_proposal)
                        <div class="mb-4">
                            <strong><i class="fas fa-file-pdf me-2"></i>Dokumen:</strong>
                            <br>
                            <a href="{{ Storage::url($proposal->file_proposal) }}" class="btn btn-outline-primary mt-2"
                                target="_blank">
                                <i class="fas fa-download me-2"></i>Download Proposal
                            </a>
                        </div>
                    @endif

                    <!-- Status Dosen -->
                    @if ($proposal->dosenPembimbing)
                        <div class="alert alert-success">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle me-2"></i>
                                Dosen Pembimbing Sudah Ditetapkan
                            </h5>
                            <hr>
                            <strong>Dosen Pembimbing 1:</strong><br>
                            <strong>Nama:</strong> {{ $proposal->dosenPembimbing->nama }}<br>
                            <strong>Bidang:</strong> {{ $proposal->dosenPembimbing->bidang_penelitian }}<br>
                            <hr>
                            <strong>Dosen Pembimbing 2:</strong><br>
                            <strong>Nama:</strong> {{ $proposal->dosenPembimbing2->nama ?? '-' }}<br>
                            <strong>Bidang:</strong> {{ $proposal->dosenPembimbing2->bidang_penelitian ?? '-' }}<br>
                            <hr>
                            <strong>Ditetapkan oleh:</strong> {{ $proposal->assignedBy->name ?? 'System' }}<br>
                            <strong>Waktu:</strong> {{ $proposal->assigned_at->format('d F Y, H:i') }}
                            @if ($proposal->catatan_admin)
                                <hr>
                                <strong>Catatan:</strong> {{ $proposal->catatan_admin }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Rekomendasi & Assignment -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-star me-2"></i> Assign Dosen Pembimbing
                </div>
                <div class="card-body">
                    @if ($proposal->status == 'pembimbing_ditentukan')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Proposal ini sudah memiliki dosen pembimbing
                        </div>
                    @endif
                    {{-- 
                <!-- Auto Assign Button -->
                <div class="d-grid mb-3">
                    <form action="{{ route('admin.proposal.auto-assign', $proposal->id) }}" 
                          method="POST" onsubmit="return confirm('Yakin ingin auto-assign dosen dengan skor tertinggi?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-magic me-2"></i>
                            Auto Assign (Skor Tertinggi)
                        </button>
                    </form>
                </div> --}}

                    {{-- <div class="text-center mb-3">
                    <small class="text-muted">atau pilih manual di bawah</small>
                </div> --}}

                    <!-- Rekomendasi Dosen -->
                    <h6 class="fw-bold mb-3">Daftar Dosen:</h6>

                    <form action="{{ route('admin.proposal.assign', $proposal->id) }}" method="POST">
                        @csrf

                        @forelse($proposal->recommendations as $index => $rec)
                            <div class="card mb-3 {{ $index == 0 ? 'border-warning' : '' }}">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dosen_ids[]"
                                            value="{{ $rec->dosen->id }}" id="dosen{{ $rec->dosen->id }}">
                                        <label class="form-check-label w-100" for="dosen{{ $rec->dosen->id }}">
                                            {{-- @if ($index == 0)
                                        <span class="badge bg-warning text-dark mb-2">
                                            <i class="fas fa-crown"></i> Top
                                        </span>
                                    @endif
                                    <span class="badge bg-secondary mb-2">Rank #{{ $rec->rank }}</span> --}}

                                            <h6 class="fw-bold mb-1">{{ $rec->dosen->nama }}</h6>
                                            <small class="text-muted d-block mb-2">
                                                {{ $rec->dosen->bidang_penelitian }}
                                            </small>

                                            <!-- Progress Skor -->
                                            <div class="progress mb-2" style="height: 20px;">
                                                <div class="progress-bar"
                                                    style="width: {{ $rec->match_score }}%; background: linear-gradient(90deg, #4FC3F7, #29B6F6);">
                                                    {{ round($rec->match_score) }}%
                                                </div>
                                            </div>

                                            <small>
                                                <i class="fas fa-users me-1"></i>
                                                Kuota:
                                                {{ $rec->dosen->getSisaKuota() }}/{{ $rec->dosen->kuota_bimbingan }}
                                                @if ($rec->dosen->isKuotaPenuh())
                                                    <span class="badge bg-danger ms-2">PENUH</span>
                                                @endif
                                            </small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Tidak ada rekomendasi dosen
                            </div>
                        @endforelse

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan (Opsional):</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ $proposal->catatan_admin }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>
                                Tetapkan Dosen Pembimbing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="dosen_ids[]"]');

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const checked = document.querySelectorAll('input[name="dosen_ids[]"]:checked');
                    if (checked.length > 2) {
                        this.checked = false;
                        alert('Maksimal pilih 2 dosen pembimbing.');
                    }
                });
            });
        });
    </script>

@endsection
