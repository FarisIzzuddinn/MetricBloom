<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login | JPM</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
            overflow: hidden;
        }

        #myVideo {
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .box-area {
            width: 100%;
            max-width: 930px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
        }

        .left-box {
            border-radius: 20px 0 0 20px;
        }

        .right-box {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 30px;
        }

        ::placeholder {
            font-size: 16px;
        }

        .custom-alert {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 10px;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .position-relative {
            position: relative;
        }

        /* Kedudukan Ikon untuk peranti mudah alih */
        @media (max-width: 768px) {
            .position-absolute {
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 2;
            }
        }

        /* Kedudukan Ikon untuk paparan besar (PC) */
        @media (min-width: 769px) {
            .position-absolute {
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 1;
            }
        }
    </style>
</head>

<body>
    <video autoplay muted loop id="myVideo">
        <source src="{{ asset('picture/green.mp4') }}" type="video/mp4">
    </video>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 shadow box-area">
            <div class="col-md-6 left-box rounded-4 d-flex justify-content-center align-items-center flex-column">
                <div class="featured-image mb-3">
                    <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="max-width: 250px; width: 100%;">
                </div>
                <p class="text-white text-center fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">JABATAN PENJARA MALAYSIA</p>
            </div>

            <div class="col-md-6">
                <div class="row align-items-center">
                    <div class="text-center mb-4">
                        <h2 style="color: white;">Login</h2>
                        <p style="color: white;">Enter your email and password</p>
                    </div>

                    <form method="POST" action="{{ url('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autocomplete="off">
                        </div>
                        <div class="position-relative mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="off">
                            <span class="position-absolute" id="togglePassword">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                            </span>
                        </div>

                        <div class="input-group mb-3">
                            <button class="btn btn-success w-100 rounded-5">Login</button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="custom-alert" role="alert">
                            <div>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- <div class="row">
                        <small style="color: white;">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></small>
                    </div> -->
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="checkbox">
                                <label>
                                    <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        });
    </script>
</body>
</html>
