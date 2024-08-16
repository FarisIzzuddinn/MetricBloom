@extends('layout')
@section('title', 'JABATAN PENJARA MALAYSIA')
@section('body')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100 ">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box ----------------------------->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #1b8659;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('picture/penjara_logo.png') }}" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white text-center fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">JABATAN PENJARA MALAYSIA</p>
            </div> 
            <!-------------------- ------ Right Box ---------------------------->
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
                      
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                    </svg>
                                    <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password" required autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="display: none;">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 3a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                    </svg>
                                    <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control mb-3">
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">Register</button>
                        </div>
                    </form>
                    <div class="row">
                        <small>Don't have account? <a href="{{ route('login') }}">Login</a></small>
                    </div>
                </div> 
            </div>
        </div>
    </div>

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
@endsection
