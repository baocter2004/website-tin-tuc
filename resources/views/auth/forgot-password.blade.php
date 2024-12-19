@extends('auth.layouts.master')
@section('title')
    Quên Mật Khẩu
@endsection
@section('content')
    <div class="login-form">
        <form>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" placeholder="Email">
            </div>
            <button type="submit" class="btn btn-primary btn-flat m-b-15">Submit</button>
        </form>
    </div>
@endsection
