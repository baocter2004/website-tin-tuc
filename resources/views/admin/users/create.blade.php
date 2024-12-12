@extends('admin.layouts.master')

@section('title')
    Thêm Mới Người Dùng
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
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="mt-3 mb-2">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="mt-3 mb-2">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
            </div>
            <div class="mt-3 mb-2">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mt-3 mb-2">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mt-3 mb-2">
                <label for="name">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
            <div class="mt-3 mb-2">
                <label for="role">Role</label>
                <select name="role" id="" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
