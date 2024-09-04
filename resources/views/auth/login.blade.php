<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login | JPM</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    body{
        font-family: 'Poppins', sans-serif;
        background: #ececec;
    }

    /*------------ Login container ------------*/

    .box-area{
        width: 930px;
    }

    /*------------ Right box ------------*/

    .right-box{
        padding: 40px 30px 40px 40px;
    }

    /*------------ Custom Placeholder ------------*/

    ::placeholder{
        font-size: 16px;
    }

    .rounded-4{
        border-radius: 20px;
    }
    .rounded-5{
        border-radius: 30px;
    }


    /*------------ For small screens------------*/

    @media only screen and (max-width: 768px){

        .box-area{
            margin: 0 10px;

        }
        .left-box{
            height: 100px;
            overflow: hidden;
        }
        .right-box{
            padding: 20px;
        }
    }
</style>

<body>

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row border rounded-5 p-3 bg-white shadow box-area">

    <!--------------------------- Left Box ----------------------------->

       <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #1b8659;">
            <div class="featured-image mb-3">
                <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="width: 250px;">
            </div>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">JABATAN PENJARA MALAYSIA</small>
       </div> 

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
          <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2>Login</h2>
                    <p>Enter your email and password</p>
                </div>
                <form method="POST" action="{{ url('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autocomplete="off">
                    </div>

                   <div class="position-relative mb-3">
                    <input type="password" class="form-control pr-5" id="password" name="password" placeholder="Password" required autocomplete="off">
                    <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" id="togglePassword">
                        <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>
                        <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                        </svg>
                    </span>
                </div>

                    
                    
                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                    </div>
                </form>
                  
                <div class="row">
                    <small>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></small>
                </div>

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
</body>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var eyeIconOpen = document.getElementById('eyeIconOpen');
        var eyeIconClosed = document.getElementById('eyeIconClosed');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIconOpen.style.display = 'block';
            eyeIconClosed.style.display = 'none';
        } else {
            passwordField.type = 'password';
            eyeIconOpen.style.display = 'none';
            eyeIconClosed.style.display = 'block';
        }
    });
</script>
</html>
 

