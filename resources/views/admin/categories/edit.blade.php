@extends('admin.layouts.master')
@section('title')
    Chỉnh Sửa
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
    @if (session('errors'))
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
    @endif
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mt-3 mb-3">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
