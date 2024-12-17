@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Người Dùng
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
    @if (session()->has('success'))
        <div class="alert alert-success">
            Sửa Thành Công
        </div>
    @endif
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-3 mb-2">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name"
                        value="{{ old('first_name', $user->first_name) }}">
                </div>

                <div class="col-md-6 mt-3 mb-2">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name"
                        value="{{ old('last_name', $user->last_name) }}">
                </div>

            </div>
            <div class="mt-3 mb-2">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
            </div>
            <div class="mt-3 mb-2">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image">
                <img src="{{ Storage::url($user->image) }}" width="200px" class="img-fluid rounded-top" alt="" />
            </div>
            <div class="mt-3 mb-2">
                <label for="role">Role</label>
                <select name="role" id="" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" @if ($user->role === $role) selected @endif>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 mb-2">
                <label for="is_active">Active</label>
                <input type="checkbox" class="form-checkbox" name="is_active" value="1"
                    @if ($user->is_active === 1) checked @endif>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
