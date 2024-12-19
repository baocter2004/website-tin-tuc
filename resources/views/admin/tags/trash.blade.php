@extends('admin.layouts.master')

@section('title', 'Danh Mục Tin Tức')

@section('content')
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.tags.index') }}">
            Danh Sách
        </a>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption>Danh Sách Danh Mục</caption>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($tags as $tag)
                    <tr class="table-primary table-bordered">
                        <td scope="row">{{ $tag->id }}</td>
                        <td scope="row">{{ $tag->name }}</td>
                        <td scope="row">{{ $tag->slug }}</td>
                        <td scope="row">
                            <form action="{{ route('admin.tags.restore', $tag->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-xl"
                                    onclick="return confirm('Bạn có muốn khôi phục người dùng này?')">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.tags.force-destroy', $tag->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xl"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="d-flex justify-content-center">
                            {{ $tags->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
