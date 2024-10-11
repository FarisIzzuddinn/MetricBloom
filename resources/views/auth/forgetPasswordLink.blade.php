<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            padding: 30px;
            box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
            border: 2px solid white;
            border-radius: 10px;
            margin: auto;
        }

        .featured-image {
            text-align: center;
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

        .custom-alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 10px;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-label {
            color: white;
        }

        .form-control {
            background-color: #ffffff;
            border-radius: 5px;
        }

        .btn-success {
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .input-group-text {
            cursor: pointer;
            background-color: #ffffff; /* Ensure background matches input */
            border: 1px solid #ced4da; /* Match border with input */
        }
    </style>
    <title>Reset Password | JPM</title>
</head>

<body>
    <video autoplay muted loop id="myVideo">
        <source src="{{ asset('picture/green.mp4') }}" type="video/mp4">
    </video>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="box-area rounded-5">
            <div class="featured-image mb-4">
                <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="max-width: 200px; width: 100%;">
                <p class="text-white fs-3 mt-3" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">JABATAN PENJARA MALAYSIA</p>
            </div>

            <div class="text-center mb-4">
                <h2 class="text-white">Reset Password</h2>
                <p class="text-white">Please enter your new password below.</p>
            </div>

            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email_address" class="form-label">E-Mail Address</label>
                    <input type="text" id="email_address" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" id="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" required>
                        <span class="input-group-text" id="togglePassword1">
                            <i class="bi bi-eye-fill" id="eyeIcon1"></i>
                        </span>
                    </div>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" id="password-confirm" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" required>
                        <span class="input-group-text" id="togglePassword2">
                            <i class="bi bi-eye-fill" id="eyeIcon2"></i>
                        </span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success w-100 rounded-5">Reset Password</button>
                </div>
            </form>

            @if (Session::has('message'))
                <div class="custom-alert custom-alert-success" role="alert">
                    <span>{{ Session::get('message') }}</span>
                </div>
            @endif
        </div>
    </div>


    <script>
        // Function to toggle password visibility
        const togglePasswordVisibility = (inputId, iconId) => {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-fill");
                icon.classList.add("bi-eye-slash-fill");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash-fill");
                icon.classList.add("bi-eye-fill");
            }
        };

        document.getElementById('togglePassword1').addEventListener('click', () => {
            togglePasswordVisibility('password', 'eyeIcon1');
        });

        document.getElementById('togglePassword2').addEventListener('click', () => {
            togglePasswordVisibility('password-confirm', 'eyeIcon2');
        });
    </script>

</body>

</html>
