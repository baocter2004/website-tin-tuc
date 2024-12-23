@extends('admin.layouts.master')

@section('title', 'Danh Sách Bài Viết')

@section('content')
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.articles.create') }}">
            Thêm Mới
        </a>
    </div>
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
                <caption>Danh Sách Bài Viết</caption>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Slug</th>
                    <th>Tags</th>
                    <th>Content</th>
                    <th>Summary</th>
                    <th>Auth_id</th>
                    <th>Category_id</th>
                    <th>Publish At</th>
                    <th>Status</th>
                    <th>Delete Reason</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($articles as $article)
                    <tr class="table-primary table-bordered">
                        <td scope="row">{{ $article->id }}</td>
                        <td scope="row">{{ $article->title }}</td>
                        <td scope="row">
                            <img src="{{ Storage::url($article->image) }}" width="100px" class="img-fluid rounded-top"
                                alt="article Image" />
                        </td>
                        <td scope="row">{{ $article->slug }}</td>
                        <td scope="row">
                            @foreach ($article->tags as $tag)
                                <span class="badge bg-primary">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td scope="row">{{ Str::limit($article->content, 50) }}</td>
                        <td scope="row">
                            {{ $article->summary }}
                        </td>
                        <td scope="row">
                            {{ $article->auth_id }}
                        </td>
                        <td scope="row">
                            {{ $article->category_id }}
                        </td>
                        <td scope="row">
                            {{ $article->publish_at }}
                        </td>
                        <td scope="row">
                            {{ $article->status }}
                        </td>
                        <td scope="row">
                            {{ $article->delete_reason }}
                        </td>
                        <td scope="row">
                            <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-xl"
                                    onclick="return confirm('Bạn có chắc chắn muốn Khôi Phục Bài Viết này?')">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.articles.force-destroy', $article->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xl"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa Bài Viết này?')">
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
                            {{ $articles->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
