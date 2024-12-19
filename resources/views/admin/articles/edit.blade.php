@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Bài Viết
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
    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-3 mb-2">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title"
                        value="{{ old('title', $article->title) }}">
                </div>

                <div class="col-md-6 mt-3 mb-2">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($article->category_id === $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3 mb-2">
                <label class="form-label" for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control">
                {{ old('content', $article->content) }}
               </textarea>
            </div>
            <div class="mt-3 mb-2">
                <label class="form-label" for="summary">Summary</label>
                <input type="text" class="form-control" name="summary" id="summary"
                    value="{{ old('summary', $article->summary) }}">
            </div>
            <div class="mt-3 mb-2">
                <label class="form-label" for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="{{ Storage::url($article->image) }}" class="mt-3 mb-3 img-fluid rounded-top" alt="" />
            </div>
            <div class="row">
                <div class="col-md-6 mt-3 mb-3">
                    <label for="tags">Tags</label>
                    <select name="tags[]" id="tags" multiple class="form-control">
                        @foreach ($tags as $tag)
                            <option @if (in_array($tag->id, $articleTags)) selected @endif value="{{ $tag->id }}">
                                {{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3 mb-2">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($statuses as $key => $value)
                        <option @if ($article->status === $value) selected @endif value="{{ $value }}">
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3 mb-2" id="reason-container" style="display: none;">
                <label class="form-label" for="delete_reason">reason delete</label>
                <input type="text" name="delete_reason" id="delete_reason" class="form-control"
                    value="{{ $article->delete_reason ?? null }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('status').addEventListener('change', function() {
                var status = this.value;
                var reasonContainer = document.getElementById('reason-container');

                if (status === 'deleted') {
                    reasonContainer.style.display = 'block';
                } else {
                    reasonContainer.style.display = 'none';
                }
            })
        })
    </script>
@endsection
