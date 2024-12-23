@extends('admin.layouts.master')
@section('title')
    Danh Sách Đoạn Văn Thùng Rác
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
    <a href="{{ route('admin.paragraphs.index') }}" class="btn btn-primary mt-3 mb-3">
        Danh Sách
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
                    <th>Delete At</th>
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
                            {{ $paragraph->deleted_at->format('d-m-Y H:i:s') }}
                        </td>
                        <td>
                            {{ $paragraph->created_at->format('d-m-Y H:i:s') }}
                        </td>
                        <td>
                            {{ $paragraph->updated_at->format('d-m-Y H:i:s') }}
                        </td>
                        <td scope="row">
                            <form action="{{ route('admin.paragraphs.restore', $paragraph->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-xl"
                                    onclick="return confirm('Bạn có chắc chắn muốn Khôi Phục Bài Viết này?')">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.paragraphs.force-destroy', $paragraph->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xl mt-3"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa Bài Viết này?')">
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
