@extends('admin.layouts.master')

@section('title', 'Danh Sách Người Dùng')

@section('content')
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
            Thêm Mới
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
                <caption>Danh Sách Người Dùng</caption>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Verify Email At</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($users as $user)
                    <tr class="table-primary table-bordered">
                        <td scope="row">{{ $user->id }}</td>
                        <td scope="row">{{ $user->first_name }}</td>
                        <td scope="row">{{ $user->last_name }}</td>
                        <td scope="row">{{ $user->email }}</td>
                        <td scope="row">
                            <img src="{{ Storage::url($user->image) }}" width="100px" class="img-fluid rounded-top"
                                alt="User Image" />
                        </td>
                        <td scope="row">
                            <span
                                class="badge 
                                {{ $user->role === 'admin'
                                    ? 'bg-primary'
                                    : ($user->role === 'editor'
                                        ? 'bg-warning'
                                        : ($user->role === 'author'
                                            ? 'bg-success'
                                            : 'bg-secondary')) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="text-center" scope="row">
                            <span class="bg {{ $user->is_active ? 'bg-success' : 'bg-danger' }}"
                                style="border-radius: 50%; display: inline-block; width: 15px; height: 15px;">
                            </span>
                        </td>
                        <td scope="row">
                            {{ $user->email_verified_at ? $user->email_verified_at : 'Chưa Xác Minh' }}
                        </td>
                        <td scope="row">
                            {{ $user->created_at ? $user->created_at : '' }}
                        </td>
                        <td scope="row">
                            {{ $user->updated_at ? $user->updated_at : '' }}
                        </td>
                        <td scope="row">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-xl">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="mt-2 mb-2 btn btn-warning btn-xl">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
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
                            {{ $users->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
