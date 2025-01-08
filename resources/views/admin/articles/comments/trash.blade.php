@extends('admin.layouts.master')

@section('title', 'Danh Sách Bình Luận Đã Xóa')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-primary">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption>Danh Sách bình luận</caption>
                <tr>
                    <th>ID</th>
                    <th>Article Id - Article Name</th>
                    <th>User Id</th>
                    <th>Content</th>
                    <th>Parent Id</th>
                    <th>Status</th>
                    <th>Delete At</th>
                    <th>Delete Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($comments as $comment)
                    <tr class="table-primary table-bordered">
                        <td scope="row">{{ $comment->id }}</td>
                        <td scope="row">{{ $comment->article->id }} - {{ $comment->article->title }}</td>
                        <td scope="row">{{ $comment->user->id }} - {{ $comment->user->first_name }}</td>
                        <td scope="row">{{ Str::limit($comment->content, 150) }}</td>
                        <td scope="row">{{ $comment->parent_id ? $comment->parent_id : 'null' }}</td>
                        <td scope="row">
                           {{ $comment->status }}
                        </td>
                        <td scope="row">
                            {{ $comment->deleted_at ? $comment->deleted_at : 'null' }}
                        </td>
                        <td scope="row">
                            {{ $comment->delete_reason ? $comment->delete_reason : 'null' }}
                        </td>
                        <td scope="row">
                            
                            <form action="{{ route('admin.comments.restore', $comment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-xl"
                                    onclick="return confirm('Bạn có chắc chắn muốn Khôi Phục bình luận này?')">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.comments.force-destroy', $comment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xl mt-3"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bình luận này?')">
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
                            {{ $comments->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
