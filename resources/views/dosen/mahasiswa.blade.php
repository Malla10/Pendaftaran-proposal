@extends('layouts.app')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="fas fa-users me-2" style="color: #4FC3F7;"></i>
            Mahasiswa Bimbingan
        </h2>
        <p class="text-muted">Daftar mahasiswa yang Anda bimbing</p>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i> Daftar Mahasiswa</span>
        <span class="badge bg-light text-dark">Total: {{ $mahasiswa->total() }} Mahasiswa</span>
    </div>
    <div class="card-body">
        @if($mahasiswa->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                <h5 class="text-muted">Belum Ada Mahasiswa</h5>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul Proposal</th>
                            <th>Tanggal Ditetapkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswa as $index => $proposal)
                        <tr>
                            <td>{{ $mahasiswa->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $proposal->mahasiswa->name }}</strong><br>
                                <small class="text-muted">{{ $proposal->mahasiswa->nim }}</small>
                            </td>
                            <td>{{ Str::limit($proposal->judul, 50) }}</td>
                            <td>{{ $proposal->assigned_at->format('d/m/Y') }}</td>
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

            {{ $mahasiswa->links() }}
        @endif
    </div>
</div>
@endsection