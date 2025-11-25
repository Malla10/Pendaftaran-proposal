@extends('layouts.app')

@section('title', 'Kelola Dosen')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">
            <i class="fas fa-chalkboard-teacher me-2" style="color: #4FC3F7;"></i>
            Kelola Data Dosen
        </h2>
        <p class="text-muted">CRUD (Create, Read, Update, Delete) data dosen pembimbing</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i> Tambah Dosen
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i> Daftar Dosen</span>
        <span class="badge bg-light text-dark">Total: {{ $dosens->total() }} Dosen</span>
    </div>
    <div class="card-body">
        @if($dosens->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                <h5 class="text-muted">Belum Ada Data Dosen</h5>
                <p class="text-muted">Klik tombol "Tambah Dosen" untuk menambah data</p>
                <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Dosen Pertama
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Dosen</th>
                            <th width="12%">NIDN</th>
                            <th width="18%">Bidang Penelitian</th>
                            <th width="20%">Keywords</th>
                            <th width="12%">Beban</th>
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosens as $index => $dosen)
                        <tr>
                            <td class="fw-bold">{{ $dosens->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-2x me-2" style="color: #4FC3F7;"></i>
                                    <div>
                                        <strong class="d-block">{{ $dosen->nama }}</strong>
                                        <small class="text-muted">{{ $dosen->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $dosen->nidn }}</span></td>
                            <td>{{ $dosen->bidang_penelitian }}</td>
                            <td>
                                @foreach(array_slice($dosen->getKeywordsArray(), 0, 3) as $kw)
                                    <span class="badge bg-light text-dark">{{ $kw }}</span>
                                @endforeach
                                @if(count($dosen->getKeywordsArray()) > 3)
                                    <span class="badge bg-light text-dark">+{{ count($dosen->getKeywordsArray()) - 3 }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar 
                                        @if($dosen->getPersentaseBeban() >= 80) bg-danger
                                        @elseif($dosen->getPersentaseBeban() >= 60) bg-warning
                                        @else bg-success
                                        @endif"
                                        style="width: {{ $dosen->getPersentaseBeban() }}%">
                                        {{ $dosen->kuota_terpakai }}/{{ $dosen->kuota_bimbingan }}
                                    </div>
                                </div>
                                <small class="text-muted">{{ $dosen->getPersentaseBeban() }}%</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.dosen.edit', $dosen->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus dosen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                {{ $dosen->kuota_terpakai > 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $dosens->links() }}
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
                    <li>Klik <strong class="text-warning">Edit</strong> untuk mengubah data dosen</li>
                    <li>Klik <strong class="text-danger">Hapus</strong> untuk menghapus dosen</li>
                    <li>Dosen yang sedang membimbing tidak dapat dihapus</li>
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
                    <li>Keywords sangat penting untuk sistem matching</li>
                    <li>Pisahkan keywords dengan koma (,)</li>
                    <li>Update kuota sesuai kapasitas bimbingan dosen</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection