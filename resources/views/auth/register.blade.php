<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Register | JPM</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
        }

        .box-area {
            width: 100%;
            max-width: 930px; /* Hadkan lebar maksimum */
            border-radius: 20px;
        }

        .left-box {
            background: #1b8659;
            border-radius: 20px 0 0 20px;
        }

        ::placeholder {
            font-size: 16px;
        }

        .rounded-5 {
            border-radius: 30px;
        }

        @media only screen and (max-width: 768px) {
            .left-box {
                height: auto; /* Biarkan ketinggian automatik */
                display: flex; /* Pastikan ia tetap kelihatan pada skrin kecil */
            }

            .right-box {
                padding: 20px;
            }

            .header-text h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <div class="col-md-6 left-box rounded-4 d-flex justify-content-center align-items-center flex-column">
                <div class="featured-image mb-3">
                    <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="max-width: 250px; width: 100%;">
                </div>
                <p class="text-white text-center fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">JABATAN PENJARA MALAYSIA</p>
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Register</h2>
                    </div>

                    @if ($errors->any())
                        <ul class="error-list mb-3">
                            <li class="text-center">{{ $errors->first() }}</li>
                        </ul>
                    @endif

                    <form method="POST" action="{{ url('register') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name') }}" required autocomplete="off">
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autocomplete="off">
                        </div>

                        <div class="position-relative mb-3">
                            <input type="password" class="form-control pr-5" id="password" name="password" placeholder="Password" required autocomplete="off">
                            <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" id="togglePassword">
                                <svg id="eyeIconOpenPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                </svg>
                                <svg id="eyeIconClosedPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                </svg>
                            </span>
                        </div>

                        <div class="position-relative mb-3">
                            <input type="password" class="form-control pr-5" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
                            <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" id="togglePasswordConfirm">
                                <svg id="eyeIconOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                </svg>
                                <svg id="eyeIconClosedConfirm" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                </svg>
                            </span>
                        </div>

                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">Register</button>
                        </div>
                    </form>

                    <div class="row">
                        <small>Don't have an account? <a href="{{ route('login') }}">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeIconOpenPassword');
            const eyeClosed = document.getElementById('eyeIconClosedPassword');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.style.display = 'inline';
                eyeClosed.style.display = 'none';
            } else {
                passwordField.type = 'password';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'inline';
            }
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
            const confirmPasswordField = document.getElementById('password_confirmation');
            const eyeOpen = document.getElementById('eyeIconOpenConfirm');
            const eyeClosed = document.getElementById('eyeIconClosedConfirm');

            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                eyeOpen.style.display = 'inline';
                eyeClosed.style.display = 'none';
            } else {
                confirmPasswordField.type = 'password';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'inline';
            }
        });
    </script>
</body>
</html>
