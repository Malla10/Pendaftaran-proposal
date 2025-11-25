<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pendaftaran Proposal TA')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4FC3F7;
            --secondary: #29B6F6;
            --dark-blue: #0277BD;
            --light-blue: #B3E5FC;
            --accent: #00ACC1;
            --success: #66BB6A;
            --warning: #FFA726;
            --danger: #EF5350;
            --info: #26C6DA;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #E1F5FE 0%, #B3E5FC 50%, #81D4FA 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 1rem 0;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            transition: transform 0.3s;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.6rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 5px;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.3);
            color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 10px !important;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: var(--light-blue);
            color: var(--dark-blue);
            padding-left: 25px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(79, 195, 247, 0.15);
            transition: all 0.3s;
            background: white;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(79, 195, 247, 0.25);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .card-header i {
            margin-right: 8px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(79, 195, 247, 0.4);
            background: linear-gradient(135deg, var(--secondary) 0%, var(--dark-blue) 100%);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #4CAF50;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #E53935;
            transform: translateY(-2px);
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #00ACC1;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #FB8C00;
            transform: translateY(-2px);
        }

        /* Badge Styling */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #2E7D32;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
            color: #C62828;
            border-left: 4px solid var(--danger);
        }

        .alert-info {
            background: linear-gradient(135deg, #E1F5FE 0%, #B3E5FC 100%);
            color: #01579B;
            border-left: 4px solid var(--info);
        }

        .alert-warning {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            color: #E65100;
            border-left: 4px solid var(--warning);
        }

        /* Table Styling */
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: var(--light-blue);
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.75rem;
            box-shadow: 0 5px 20px rgba(79, 195, 247, 0.15);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(79, 195, 247, 0.25);
        }

        .stats-card h3 {
            color: var(--primary);
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }

        .stats-card p {
            color: #666;
            margin: 0.5rem 0 0 0;
            font-weight: 500;
        }

        .stats-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        /* Form Styling */
        .form-control, .form-select {
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(79, 195, 247, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        /* Container */
        .container {
            max-width: 1200px;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }

        .page-link {
            color: var(--primary);
            border: 1px solid #E0E0E0;
            margin: 0 3px;
            border-radius: 5px;
        }

        .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Progress Bar */
        .progress {
            border-radius: 10px;
            overflow: hidden;
            background: #E0E0E0;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            transition: width 0.6s ease;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i>
                Sistem Proposal TA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if(Auth::user()->role == 'mahasiswa')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('mahasiswa.dashboard') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.dashboard') }}">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('mahasiswa.proposal.create') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.proposal.create') }}">
                                <i class="fas fa-plus-circle me-1"></i> Ajukan Proposal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('mahasiswa.riwayat') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.riwayat') }}">
                                <i class="fas fa-history me-1"></i> Riwayat
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-chart-line me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.proposals') ? 'active' : '' }}" 
                               href="{{ route('admin.proposals') }}">
                                <i class="fas fa-file-alt me-1"></i> Proposals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.dosen.*') ? 'active' : '' }}" 
                               href="{{ route('admin.dosen.index') }}">
                                <i class="fas fa-chalkboard-teacher me-1"></i> Kelola Dosen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.logs') ? 'active' : '' }}" 
                               href="{{ route('admin.logs') }}">
                                <i class="fas fa-clipboard-list me-1"></i> Activity Log
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'dosen')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dosen.dashboard') ? 'active' : '' }}" 
                               href="{{ route('dosen.dashboard') }}">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dosen.mahasiswa') ? 'active' : '' }}" 
                               href="{{ route('dosen.mahasiswa') }}">
                                <i class="fas fa-users me-1"></i> Mahasiswa Bimbingan
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2" style="font-size: 1.5rem;"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Content -->
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>