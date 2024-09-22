<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .form-gap {
            padding-top: 100px;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .logo-container img {
            max-width: 50%;
            height: auto;
            width: 250px; /* atau anda boleh menggunakan 'auto' jika ingin lebih responsif */
        }
    </style>
    <title>Reset Password</title>
</head>
<body>
    <main class="login-form">
        <div class="container form-gap">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="logo-container">
                            <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid">
                        </div>
                        <div class="card-header text-center">
                            <h2>Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                        </div>
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <form action="{{ route('forget.password.post') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email_address">E-Mail Address</label>
                                    <input type="email" id="email_address" class="form-control" name="email" placeholder="Enter your email address" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        DONE
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
