@extends('auth.layouts.master')
@section('title')
    Xác Thực Email
@endsection
@section('content')
    <style>
        .welcome-container {
            background-color: #2c2c2c;
            color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .welcome-container p {
            font-size: 1.1em;
        }

        .welcome-container a.btn {
            margin-top: 20px;
        }
    </style>
    <div class="container welcome-container">
        <h1>Xin chào, {{ $userName }}!</h1>
        <p>Vui lòng nhấp vào liên kết dưới đây để xác thực email của bạn:</p>
        <a href="{{ $verificationUrl }}"
            style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Xác
            thực Email</a>
        <p>Chúc bạn một ngày tốt lành!</p>
    </div>
@endsection
