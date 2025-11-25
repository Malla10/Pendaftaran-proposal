<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Proposal TA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 50%, #0277BD 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            max-width: 1000px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-left {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
            padding: 3rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .login-left-content {
            position: relative;
            z-index: 1;
        }

        .login-left h2 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .login-left p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .feature-list {
            margin-top: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .feature-item i {
            font-size: 1.5rem;
            margin-right: 1rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 10px;
        }

        .login-right {
            padding: 3rem 2.5rem;
        }

        .login-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title h3 {
            color: #0277BD;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .login-title p {
            color: #666;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #4FC3F7;
            box-shadow: 0 0 0 0.2rem rgba(79, 195, 247, 0.25);
        }

        .input-group-text {
            background: white;
            border: 2px solid #E0E0E0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
            border: none;
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(79, 195, 247, 0.4);
            background: linear-gradient(135deg, #29B6F6 0%, #0277BD 100%);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #E0E0E0;
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #E0E0E0;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .register-link a {
            color: #4FC3F7;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            color: #0277BD;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-left {
                padding: 2rem;
            }

            .login-right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card row g-0">
            <!-- Left Side -->
            <div class="col-lg-5 login-left">
                <div class="login-left-content">
                    <i class="fas fa-graduation-cap fa-5x mb-4"></i>
                    <h2>Sistem Pendaftaran Proposal</h2>
                    <p class="mb-0">Tugas Akhir Jurusan Sistem Informasi</p>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Pendaftaran judul proposal online</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-robot"></i>
                            <span>Rekomendasi dosen otomatis</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-user-tie"></i>
                            <span>Penetapan pembimbing cepat</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Monitoring status real-time</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="col-lg-7 login-right">
                <div class="login-title">
                    <h3><i class="fas fa-sign-in-alt me-2"></i>Login</h3>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" class="form-control" 
                               placeholder="Username" value="{{ old('username') }}" 
                               required autofocus>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" 
                               placeholder="Password" required>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                    </button>
                </form>

                <div class="divider">atau</div>

                <div class="register-link">
                    <p class="mb-0">
                        Belum punya akun? 
                        <a href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Daftar di sini
                        </a>
                    </p>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Login credentials default:<br>
                        Admin: admin/admin123 | Mahasiswa: mahasiswa/mahasiswa123
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>