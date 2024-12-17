@extends('admin.layouts.master')
@section('title')
    Thông Tin Người Dùng : {{ $user->last_name }} {{ $user->first_name }}
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover table-borderless table-primary align-middle">
            <thead class="table-light">
                <caption>Thông Tin Người Dùng : {{ $user->last_name }} {{ $user->first_name }}</caption>
                <tr>
                    <th>Trường</th>
                    <th>Dữ Liệu</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($user->toArray() as $key => $value)
                    <tr class="table-primary table-bordered">
                        <td>{{ $key }}</td>
                        @switch($key)
                            @case('image')
                                <td>
                                    <img src="{{ Storage::url($user->image) }}" width="150px" class="img-fluid rounded-top"
                                        alt="" />
                                </td>
                            @break

                            @case('is_active')
                                @if ($value === '1')
                                    <td>
                                        <span class="badge bg-success">Yes</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge bg-danger">No Active</span>
                                    </td>
                                @endif
                            @break

                            @default
                                <td>{{ $value }}</td>
                        @endswitch
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
