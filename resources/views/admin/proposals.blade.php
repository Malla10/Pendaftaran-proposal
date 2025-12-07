@extends('layouts.app')

@section('title', 'Kelola Proposals')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="fas fa-file-alt me-2" style="color: #4FC3F7;"></i>
                Kelola Proposals
            </h2>
            <p class="text-muted">Daftar semua proposal yang diajukan mahasiswa</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Daftar Proposals</span>
            <div>
                <span class="badge bg-warning text-dark me-2">
                    {{ $proposals->where('status', 'menunggu_penetapan')->count() }} Menunggu
                </span>
                <span class="badge bg-success">
                    {{ $proposals->where('status', 'pembimbing_ditentukan')->count() }} Selesai
                </span>
            </div>
        </div>
        <div class="card-body">
            @if ($proposals->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                    <h5 class="text-muted">Belum Ada Proposal</h5>
                    <p class="text-muted">Belum ada mahasiswa yang mengajukan proposal</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Mahasiswa</th>
                                <th width="30%">Judul Proposal</th>
                                <th width="12%">Tanggal</th>
                                <th width="13%">Status</th>
                                <th width="15%">Dosen</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposals as $index => $proposal)
                                <tr>
                                    <td class="fw-bold">{{ $proposals->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong class="d-block">{{ $proposal->mahasiswa->name }}</strong>
                                                <small class="text-muted">{{ $proposal->mahasiswa->nim }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="d-block mb-1">{{ Str::limit($proposal->judul, 60) }}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-tags me-1"></i>
                                            {{ Str::limit($proposal->keywords, 40) }}
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
                                        @if ($proposal->dosenPembimbing)
                                            <p>Dosen Pembimbing 1:</p>
                                            <strong class="d-block">{{ $proposal->dosenPembimbing->nama }}</strong>
                                            <hr>
                                            <p>Dosen Pembimbing 2:</p>
                                            <strong class="d-block">{{ $proposal->dosenPembimbing2->nama ?? '-' }}</strong>
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-minus-circle me-1"></i>
                                                Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.proposal.show', $proposal->id) }}"
                                            class="btn btn-sm btn-info" title="Detail & Assign">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <div class="mt-2"></div>
                                        <form action="{{ route('admin.proposal.destroy', $proposal->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus proposal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Proposal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $proposals->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle me-2 text-info"></i>
                        Informasi
                    </h5>
                    <ul class="mb-0">
                        <li>Klik <strong>Detail</strong> untuk melihat rekomendasi dosen</li>
                        <li>Anda dapat assign dosen secara manual atau otomatis</li>
                        <li>Sistem memberikan 3-5 rekomendasi dosen terbaik</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-check-circle me-2 text-success"></i>
                        Tips Assignment
                    </h5>
                    <ul class="mb-0">
                        <li>Pertimbangkan skor kecocokan dan kuota dosen</li>
                        <li>Gunakan fitur auto-assign untuk efisiensi</li>
                        <li>Periksa beban bimbingan dosen sebelum assign</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
