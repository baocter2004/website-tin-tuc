@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Người Dùng : {{ $user->name }}
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
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="mt-3 mb-2">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
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
                        <option @if ($role === $user->role) selected @endif value="{{ $role }}">
                            {{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
