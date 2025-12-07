<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Proposal TA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 50%, #0277BD 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .register-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 700px;
            margin: 0 auto;
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

        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .register-header i {
            font-size: 4rem;
            color: #4FC3F7;
            margin-bottom: 1rem;
        }

        .register-header h2 {
            color: #0277BD;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .register-header p {
            color: #666;
        }

        .form-control, .form-select {
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4FC3F7;
            box-shadow: 0 0 0 0.2rem rgba(79, 195, 247, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
            border: none;
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.3s;
            width: 100%;
            margin-top: 1.5rem;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(79, 195, 247, 0.4);
            background: linear-gradient(135deg, #29B6F6 0%, #0277BD 100%);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: #4FC3F7;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: #0277BD;
            text-decoration: underline;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="register-header">
                <i class="fas fa-user-plus"></i>
                <h2>Registrasi Mahasiswa</h2>
                <p>Daftar untuk mengajukan proposal tugas akhir</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Nama Lengkap -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-user me-1"></i> Nama Lengkap *
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-at me-1"></i> Username *
                        </label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username') }}" placeholder="Username untuk login" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- NIM -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-id-card me-1"></i> NIM *
                        </label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" 
                               value="{{ old('nim') }}" placeholder="Nomor Induk Mahasiswa" required>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-envelope me-1"></i> Email *
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Program Studi -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-university me-1"></i> Program Studi *
                        </label>
                        <select name="prodi" class="form-select @error('prodi') is-invalid @enderror" required>
                            <option value="">Pilih Prodi</option>
                            <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>
                                Sistem Informasi
                            </option>
                        </select>
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-calendar me-1"></i> Semester *
                        </label>
                        <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock me-1"></i> Password *
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock me-1"></i> Konfirmasi Password *
                        </label>
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Catatan:</strong> Pastikan semua data yang Anda masukkan sudah benar.
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                </button>
            </form>

            <div class="login-link">
                <p class="mb-0">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>