@extends('admin.layouts.master')
@section('title')
    Thêm Mới Đoạn Văn
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
    <form action="{{ route('admin.paragraphs.update', $paragraph->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-3 mb-3">
            <label for="article_id" class="form-label">Article</label>
            <select name="article_id" id="article_id" class="form-control">
                @foreach ($articles as $article)
                    <option @if ($article->id === $paragraph->article_id) selected @endif value="{{ $article->id }}">
                        {{ $article->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <label for="order">Thứ tự đoạn văn:</label>
        <input type="number" id="order" name="order" min="1" max="10"
            value="{{ old('order', $paragraph->order) }}" class="form-control">
        <div class="mt-3 mb-3">
            <label for="paragraph" class="form-label">Paragraph</label>
            <textarea name="paragraph" id="paragraph" cols="30" rows="10" class="form-control">
                {{ old('paragraph', $paragraph->paragraph) }}
            </textarea>
        </div>
        <div class="mt-3 mb-3">
            @foreach ($paragraph->mediums as $media)
                <div class="form-media" id="file-input-container">
                    <label for="file_path" class="form-label">File Path</label>
                    <input type="file" class="form-control" name="file_path[{{$media->id}}]" id="file_path">
                </div>
                <img src="{{ Storage::url($media->file_path) }}" alt="" width="200px">
            @endforeach
        </div>
        <a name="add-file-input" id="add-file-input" class="btn btn-info mt-3">
            Thêm ảnh
        </a>
        <button type="submit" class="btn btn-primary mt-3">Thêm Mới</button>
    </form>
    <script>
        document.getElementById('add-file-input').addEventListener('click', function(event) {
            event.preventDefault();

            const container = document.getElementById('file-input-container');
            if (container.children.length <= 5) {
                container.innerHTML += `
                <div class="form-media mt-2">
                    <label class="form-label">File Path</label>
                    <input type="file" class="form-control" name="file_path[]">
                </div>
            `;
            } else {
                alert('Tối đa 5 ảnh!');
            }
        });
    </script>

@endsection
