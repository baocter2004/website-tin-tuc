@extends('admin.layouts.master')
@section('title')
    Thêm Mới Danh Mục
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
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mt-3 mb-3">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
