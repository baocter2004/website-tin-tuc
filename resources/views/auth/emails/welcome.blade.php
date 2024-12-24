@extends('auth.layouts.master')
@section('title')
    Thư Chào Mừng
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
        <p>Chào bạn,<strong> {{ $user->first_name }}</strong>!</p>
        <p>Chúng tôi rất vui khi bạn gia nhập cộng đồng của chúng tôi. Để bắt đầu, hãy khám phá các tính năng của nền tảng
            và tận hưởng những cơ hội mới!</p>
        <p>Chúc bạn có một trải nghiệm tuyệt vời!</p>
        <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
        <p><a href="{{ url('/') }}" class="btn btn-primary">Khám phá ngay</a></p>
    </div>
@endsection
