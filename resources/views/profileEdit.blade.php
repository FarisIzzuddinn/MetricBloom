@extends('layout')
@section('title', 'Dashboard')
@section('content')
    {{-- to remove overflow --}}
    <head>
        <style>
            body, html {
                overflow-x: hidden;
                overflow-y: auto;
            }
            
            .container {
                overflow-x: hidden;
            }

            .card img {
                max-width: 100%;
                height: auto;
            }

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
    <h1 class="h3 mb-3">Staff Information</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">  
                <div class="card">  
                    <div class="card-header">{{ __('Edit Profile') }}</div>
                    <div class="card-body">   
                        <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">   
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success" role="alert" class="text-danger">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="mb-3 col-md-6">  
                                    <label for="name" class="form-label">Avatar: </label>
                                    <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" accept=".jpg,.jpeg" autocomplete="avatar">
                                    @error('avatar')
                                        <span role="alert" class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <img src="/avatars/{{ auth()->user()->avatar }}" style="width:80px;margin-top: 15px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name: </label>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ auth()->user()->name }}" placeholder = "Enter your name" autofocus="" >
                                    @error('name')
                                        <span role="alert" class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email: </label>
                                    <input 
                                        class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" readonly style="background-color: lightgray;">
                                    @error('email')
                                        <span role="alert" class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password: </label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" id="password" name="password" placeholder="Enter a new password" autofocus="">
                                        <span class="position-absolute" id="togglePassword1">
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span role="alert" class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="confirm_password" class="form-label">Confirm Password: </label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" autofocus="">
                                        <span class="position-absolute" id="togglePassword2">
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                            </svg>
                                        </span>
                                    </div>
                                    @error('confirm_password')
                                        <span role="alert" class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                                
    
                            <div class="row mb-0">
                                <div class="col-md-12 offset-md-5">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Profile') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword1').addEventListener('click', function () {
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

        document.getElementById('togglePassword2').addEventListener('click', function () {
            var passwordField = document.getElementById('confirm_password');
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
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Enter your Information</h5>
                </div>

                <div class="card-body">
                    {!! Form::model(auth()->user(), [
                        'route' => ['profileEdit.update', 0],
                        'method' => 'PUT',
                    ]) !!}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Staff Name</label>
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Enter your full name',
                                'id' => 'name',
                            ]) !!}
                            <span class="text-danger">{!! $errors->first('name') !!}</span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            {!! Form::email('email', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Enter your email address',
                                'id' => 'email',
                                'readonly' => 'readonly',                             
                            ]) !!}
                            <span class="text-danger">{!! $errors->first('email') !!}</span>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password">Password</label>
                            {!! Form::password('password', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter a new password',
                                'id' => 'password',
                            ]) !!}
                            <span class="text-danger">{!! $errors->first('password') !!}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group text-center">
                        {!! Form::submit('Confirm', ['class' => 'btn btn-primary px-4']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div> --}}

@endsection
