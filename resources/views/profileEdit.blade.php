@extends('layout')
@section('title', 'Dashboard')
@section('content')

    <h1 class="h3 mb-3">Staff Information</h1>

    <div class="row">
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
    </div>

@endsection
