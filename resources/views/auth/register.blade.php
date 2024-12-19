@extends('auth.layouts.master')

@section('title')
    Register
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="login-form">
        <form method="POST" action="{{ route('auth.register') }}">
            @csrf
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="first Name">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="first Name">
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label>Password Confirm</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Agree the terms and policy
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
            <div class="social-login-content">
                <div class="social-button">
                    <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i
                            class="ti-facebook"></i>Register with facebook</button>
                    <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i
                            class="ti-twitter"></i>Register with twitter</button>
                </div>
            </div>
            <div class="register-link m-t-15 text-center">
                <p>Already have account ? <a href="{{ route('auth.login') }}"> Sign in</a></p>
            </div>
        </form>
    </div>
@endsection
