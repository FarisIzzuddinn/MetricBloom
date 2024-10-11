<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
            background-color: rgba(0, 0, 0, 0.5); /* Kesan hitam separa telus */
            backdrop-filter: blur(2px); /* Kesan kabur */
            padding: 30px;
            box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.5);
            border: 2px solid white; 
            border-radius: 5px; 
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

        /* Gaya untuk mesej kejayaan */
        .custom-alert-success {
            background-color: #d4edda; /* Warna latar belakang hijau muda */
            color: #155724; /* Warna teks hijau gelap */
            border: 1px solid #c3e6cb; /* Border hijau muda */
            border-radius: 4px;
            padding: 10px;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .position-absolute {
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 2;
            }
        }

        @media (min-width: 769px) {
            .position-absolute {
                right: -40px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 1;
            }
        }
    </style>
    <title>Forgot Password | JPM</title>
</head>

<body>
    <video autoplay muted loop id="myVideo">
        <source src="{{ asset('picture/green.mp4') }}" type="video/mp4">
    </video>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="box-area rounded-5">
            <!-- Bahagian logo di bahagian atas -->
            <div class="featured-image mb-4">
                <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="max-width: 200px; width: 100%;">
                <p class="text-white fs-3 mt-3" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">JABATAN PENJARA MALAYSIA</p>
            </div>

            <!-- Bahagian kanan untuk borang -->
            <div class="right-box">
                <div class="row align-items-center">
                    <div class="text-center mb-4">
                        <h2 class="text-white">Forgot Password?</h2>
                        <p class="text-white">Enter your email to reset your password</p>
                    </div>

                    <form action="{{ route('forget.password.post') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" id="email_address" name="email" placeholder="Enter your email address" required autofocus>
                            
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <button class="btn btn-success w-100 rounded-5">Reset Password</button>
                        </div>
                    </form>

                    @if (Session::has('message'))
                        <div class="custom-alert custom-alert-success" role="alert">
                            <span>{{ Session::get('message') }}</span>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <small class="text-white">Back to <a href="{{ url('login') }}" class="text-decoration-none">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
