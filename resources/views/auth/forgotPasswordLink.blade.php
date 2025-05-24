<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Login | Jabatan Penjara Malaysia</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #109927;
            --secondary: #00796b;
            --accent: #00bfa5;
            --light: #e0f2f1;
            --dark: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        #background-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #myVideo {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: linear-gradient(135deg, rgba(0, 77, 64, 0.8) 0%, rgba(0, 77, 64, 0.6) 100%); */
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: row;
        }

        .brand-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 45%;
            position: relative;
            overflow: hidden;
        }

        .brand-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .logo {
            width: 180px;
            height: auto;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .brand-title {
            color: white;
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            font-size: 14px;
            position: relative;
            z-index: 2;
        }

        .login-section {
            padding: 40px;
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #666;
            font-size: 14px;
        }

        .form-floating {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            height: 56px;
            padding: 1rem 1rem 0.5rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 12px;
            background-color: #f9f9f9;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--secondary);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(0, 121, 107, 0.1);
        }

        .form-floating label {
            padding: 1rem;
            color: #757575;
        }

        .btn-login {
            height: 56px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            font-size: 16px;
            padding: 0.5rem 0;
            margin-top: 10px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 77, 64, 0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: var(--secondary);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-password a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #757575;
            cursor: pointer;
            z-index: 10;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-error {
            background-color: #ffebee;
            border-left: 4px solid #ef5350;
            color: #b71c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 991px) {
            .login-card {
                flex-direction: column;
                max-width: 500px;
            }
            
            .brand-section, .login-section {
                width: 100%;
            }
            
            .brand-section {
                padding: 30px;
            }
            
            .login-section {
                padding: 30px;
            }
        }

        @media (max-width: 576px) {
            .brand-section, .login-section {
                padding: 25px 20px;
            }
            
            .brand-title {
                font-size: 18px;
            }
            
            .logo {
                width: 140px;
            }
        }
    </style>
</head>

<body>
    <div id="background-wrapper">
        <video autoplay muted loop id="myVideo">
            <source src="{{ asset('picture/green.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-section">
                <div class="brand-pattern"></div>
                <img src="{{ asset('picture/penjara_logo.png') }}" alt="Jabatan Penjara Malaysia Logo" class="logo">
                <h1 class="brand-title">SMART KPI</h1>
                <h1 class="brand-title">Jabatan Penjara Malaysia</h1>
            </div>
            
            <div class="login-section">
                <div class="login-header">
                    <h2 class="login-title">Reset Account Password</h2>
                    <p class="login-subtitle">Enter your new password here</p>
                </div>

                @if(session('status'))
                    <div>{{ session('status') }}</div>
                @endif

                @include('toast-notification')

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />

                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" value="{{ $email ?? old('email') }}" name="email" placeholder="Email Address" required autofocus>
                        <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                        <div class="mt-1 ms-2 text-danger">
                            @error('email') <div>{{ $message }}</div> @enderror
                        </div>
                    </div>

                     <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password"><i class="fas fa-envelope me-2"></i>Password</label>
                        <span class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                        <div class="mt-1 ms-2 text-danger">
                            @error('password') <div>{{ $message }}</div> @enderror
                        </div>
                    </div>

                     <div class="form-floating">
                        <input type="password" class="form-control" id="passwordConfirmation" name="password_confirmation" placeholder="Password Confirmation" required>
                        <label for="password"><i class="fas fa-envelope me-2"></i>Password Confirmation</label>
                        <span class="password-toggle" id="togglePasswordConfirmation">
                            <i class="fas fa-eye" id="eyeIcon2"></i>
                        </span>
                        <div class="mt-1 ms-2 text-danger">
                            @error('password') <div>{{ $message }}</div> @enderror
                        </div>
                    </div>

                
                    <button type="submit" class="btn btn-login w-100">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

 <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

     document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
        var passwordField = document.getElementById('passwordConfirmation');
        var eyeIcon2 = document.getElementById('eyeIcon2');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon2.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon2.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>