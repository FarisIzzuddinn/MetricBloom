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
                    <div class="text-center">
                        <h2 style="color: white;">Register</h2>
                    </div>

                    @if ($errors->any())
                        <ul class="error-list mb-3">
                            <li class="text-center">{{ $errors->first() }}</li>
                        </ul>
                    @endif

                    <form class="needs-validation" method="POST" action="{{ url('register') }}" novalidate>
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name') }}" required autocomplete="off">
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autocomplete="off">
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="position-relative mb-3">
                            <input type="password" class="form-control pr-5" id="password" name="password" placeholder="Password" required autocomplete="off">
                            <div class="invalid-feedback">Please enter a password.</div>
                            <span class="position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%);" id="togglePassword">
                                <svg id="eyeIconOpenPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                </svg>
                                <svg id="eyeIconClosedPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                </svg>
                            </span>
                        </div>

                        <div class="position-relative mb-3">
                            <input type="password" class="form-control pr-5" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
                            <div class="invalid-feedback">Please confirm your password.</div>
                            <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);" id="togglePasswordConfirm">
                                <svg id="eyeIconOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                </svg>
                                <svg id="eyeIconClosedConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                </svg>
                            </span>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100 rounded-5">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            <p style="color: white;">Already have an account? <a href="{{ url('login') }}" class="text-success">Log in</a></p>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIconOpen = document.getElementById('eyeIconOpenPassword');
        const eyeIconClosed = document.getElementById('eyeIconClosedPassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIconOpen.style.display = type === 'password' ? 'none' : 'block';
            eyeIconClosed.style.display = type === 'password' ? 'block' : 'none';
        });

        // Toggle Confirm Password Visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const eyeIconOpenConfirm = document.getElementById('eyeIconOpenConfirm');
        const eyeIconClosedConfirm = document.getElementById('eyeIconClosedConfirm');

        togglePasswordConfirm.addEventListener('click', () => {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            eyeIconOpenConfirm.style.display = type === 'password' ? 'none' : 'block';
            eyeIconClosedConfirm.style.display = type === 'password' ? 'block' : 'none';
        });

        // Form Validation
        (function() {
            'use strict';

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0lCcW46tL0lY0iExdW6ORUtMNcbwE2LkL9y/Az5HRKpS5ABoTf/+0g1LwxMo4lVQ" crossorigin="anonymous"></script>
</body>
</html>
