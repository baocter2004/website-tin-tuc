@extends('auth.layouts.master')

@section('title')
    Login
@endsection

@section('content')
    @if ($errors->has('message'))
        <div class="alert alert-danger">
            {{ $errors->first('message') }}
        </div>
    @endif

    <div class="login-form">
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input id="email" type="email" name="email" class="@error('email') is-invalid @enderror form-control"
                    value="{{ old('email') }}" placeholder="Email">
                @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="@error('password') is-invalid @enderror form-control"
                    placeholder="Password">
                @error('password')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
                <label class="pull-right">
                    <a href="">Forgotten Password?</a>
                </label>
            </div>
            <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
            <div class="social-login-content">
                <div class="social-button">
                    <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i
                            class="ti-facebook"></i>Sign in with facebook</button>
                    <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign
                        in with twitter</button>
                </div>
            </div>
            <div class="register-link m-t-15 text-center">
                <p>Don't have account ? <a href="{{ route('auth.register') }}"> Sign Up Here</a></p>
            </div>
        </form>
    </div>
@endsection
