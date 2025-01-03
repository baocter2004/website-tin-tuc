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
            <div class="row">
                <div class="col-md-6 mt-3 mb-2">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                </div>

                <div class="col-md-6 mt-3 mb-2">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                </div>
               
            </div>
            <div class="mt-3 mb-2">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
            </div>
            <div class="row">
                <div class="col-md-6 mt-3 mb-2">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="col-md-6 mt-3 mb-2">
                    <label for="name">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
            <div class="mt-3 mb-2">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mt-3 mb-2">
                <label for="role">Role</label>
                <select name="role" id="" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-2 mt-3 mb-2">
                    <label for="email_verified_at">Verify</label>
                    <input type="checkbox" class="form-checkbox" name="email_verified_at">
                </div>
                <div class="col-md-2 mt-3 mb-2">
                    <label for="is_active">Active</label>
                    <input type="checkbox" class="form-checkbox" name="is_active" value="1">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
