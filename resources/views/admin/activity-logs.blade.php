@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">
            <i class="fas fa-clipboard-list me-2" style="color: #4FC3F7;"></i>
            Activity Logs
        </h2>
        <p class="text-muted">Riwayat aktivitas sistem pendaftaran proposal</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-history me-2"></i> Log Aktivitas Sistem
    </div>
    <div class="card-body">
        @if($logs->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x mb-3" style="color: #E0E0E0;"></i>
                <h5 class="text-muted">Belum Ada Activity Log</h5>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">User</th>
                            <th width="15%">Activity</th>
                            <th width="45%">Deskripsi</th>
                            <th width="20%">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)
                        <tr>
                            <td class="fw-bold">{{ $logs->firstItem() + $index }}</td>
                            <td>
                                <strong class="d-block">{{ $log->user->name }}</strong>
                                <span class="badge 
                                    @if($log->user->role == 'admin') bg-danger
                                    @elseif($log->user->role == 'dosen') bg-info
                                    @else bg-primary
                                    @endif">
                                    {{ ucfirst($log->user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $log->activity }}</span>
                            </td>
                            <td>{{ $log->description }}</td>
                            <td>
                                <i class="fas fa-clock me-1"></i>
                                {{ $log->created_at->format('d M Y, H:i') }}
                                <br>
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection