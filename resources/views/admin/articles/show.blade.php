@extends('admin.layouts.master')

@section('title', 'Danh Sách Bài Viết')

@section('content')
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.articles.index') }}">
            Danh Sách
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption>Thông Tin Bài Viết</caption>
                <tr>
                    <th>Trường</th>
                    <th>Dữ Liệu</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($article->toArray() as $key => $value)
                    <tr class="table-primary table-bordered">
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            @switch($key)
                                @case('image')
                                    <img src="{{ Storage::url($value) }}" class="img-fluid rounded-top" width="200px"
                                        alt="Image" />
                                @break

                                @case('tags')
                                    @if (is_array($value))
                                        @foreach ($value as $tag)
                                            <span class="badge bg-secondary">{{ $tag['name'] }}</span>
                                        @endforeach
                                    @endif
                                @break

                                @case('paragraphs')
                                    @if (is_array($value))
                                        @foreach ($value as $paragraph)
                                            <span class="badge bg-secondary">{{ $paragraph['paragraph'] }}</span>
                                        @endforeach
                                    @endif
                                @break

                                @default
                                    {{ $value }}
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
