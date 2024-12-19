@extends('admin.layouts.master')
@section('title')
    Thông Tin Danh Mục : {{ $category->name }}
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption> Thông Tin Danh Mục : {{ $category->name }}</caption>
                <tr>
                    <th>Trường</th>
                    <th>Dữ Liệu</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($category->toArray() as $key => $value)
                    <tr class="table-primary table-bordered">
                        <td>{{ $key }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
