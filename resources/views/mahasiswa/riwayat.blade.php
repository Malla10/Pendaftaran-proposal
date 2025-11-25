@extends('layouts.app')

@section('title', 'Riwayat Proposal')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="fas fa-history me-2" style="color: #4FC3F7;"></i>
            Riwayat Proposal
        </h2>
        <p class="text-muted">Daftar semua proposal yang pernah Anda ajukan</p>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i> Semua Proposal</span>
        <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Ajukan Baru
        </a>
    </div>
    <div class="card-body">
        @if($proposals->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                <h5 class="text-muted">Belum Ada Riwayat</h5>
                <p class="text-muted">Anda belum mengajukan proposal apapun</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proposals as $index => $proposal)
                        <tr>
                            <td>{{ $proposals->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ Str::limit($proposal->judul, 50) }}</strong>
                            </td>
                            <td>{{ $proposal->created_at->format('d/m/Y') }}</td>
                            <td>{!! $proposal->getStatusBadge() !!}</td>
                            <td>
                                @if($proposal->dosenPembimbing)
                                    {{ $proposal->dosenPembimbing->nama }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('mahasiswa.proposal.show', $proposal->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
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
@endsection