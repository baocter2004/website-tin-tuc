@extends('admin.layouts.master')
@section('title')
    Danh Sách Đoạn Văn
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
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('admin.paragraphs.create') }}" class="btn btn-primary mt-3 mb-3">
        Thêm Mới
    </a>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption>
                    Danh Sách Đoạn Văn
                </caption>
                <tr>
                    <th>ID</th>
                    <th>Article Id</th>
                    <th>Article Title</th>
                    <th>Article Order</th>
                    <th>Paragraph</th>
                    <th>Media Image</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($paragraphs as $paragraph)
                    <tr class="table-primary">
                        <td scope="row">{{ $paragraph->id }}</td>
                        <td>{{ $paragraph->article->id }}</td>
                        <td scope="row">{{ $paragraph->article->title }}</td>
                        <td scope="row">{{ $paragraph->order }}</td>
                        <td scope="row">{{ $paragraph->paragraph }}</td>
                        <td scope="row">
                            @foreach ($paragraph->mediums as $media)
                                <img src="{{ Storage::url($media->file_path) }}" class="img-fluid rounded-top"
                                    alt="ảnh paragraph" width="50px" />
                            @endforeach
                        </td>
                        <td>
                            {{ $paragraph->created_at->format('d-m-Y H:i:s') }}
                        </td>
                        <td>
                            {{ $paragraph->updated_at->format('d-m-Y H:i:s') }}
                        </td>
                        <td scope="row">
                            <a href="{{ route('admin.paragraphs.show', $paragraph->id) }}" class="btn btn-info btn-xl">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.paragraphs.edit', $paragraph->id) }}"
                                class="btn btn-warning btn-xl mt-2 mb-2">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.paragraphs.destroy', $paragraph->id) }}" method="POST"
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
                {{ $paragraphs->links() }}
            </tfoot>
        </table>
    </div>
@endsection
