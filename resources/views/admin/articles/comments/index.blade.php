@extends('admin.layouts.master')

@section('title', 'Danh Sách Bình Luận')

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
                <caption>Danh Sách Bài Viết</caption>
                <tr>
                    <th>ID</th>
                    <th>Article Id - Article Name</th>
                    <th>User Id</th>
                    <th>Content</th>
                    <th>Parent Id</th>
                    <th>Status</th>
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
                            <button class="btn btn-warning btn-edit">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-xl btn-destroy mt-2">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal cho lý do xóa -->
                    <div class="modal fade" id="deleteReasonModal" tabindex="-1" aria-labelledby="deleteReasonModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteReasonModalLabel">Lý do xóa comment</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="deleteCommentForm"
                                        action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="mb-3">
                                            <label for="delete_reason" class="form-label">Lý do</label>
                                            <textarea class="form-control" id="delete_reason" name="delete_reason" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal cho lý do xóa -->
                    <!-- Modal cho thay đổi trạng thái -->
                    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalLabel">Thay Đổi Trạng Thái Bình Luận</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="editStatusForm"
                                        action="{{ route('admin.comments.update-status', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng Thái</label>
                                            <select class="form-control" id="status" name="status">
                                                @foreach ($selectOptions as $option)
                                                    <option value="{{ $option }}"
                                                        @if ($comment->status === $option) selected @endif>
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-primary"
                                                id="confirmStatusChange">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal cho thay đổi trạng thái -->
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
@push('script')
    <script>
        jQuery(document).ready(function() {

            // Mở modal xóa khi nhấn nút xóa
            jQuery('.btn-destroy').on('click', function(e) {
                e.preventDefault();
                jQuery('#deleteReasonModal').modal('show');
            });

            jQuery('#confirmDelete').on('click', function() {
                jQuery('#deleteCommentForm').submit();
            });

            jQuery('.btn-close, .btn-secondary').on('click', function() {
                jQuery('#deleteReasonModal').modal('hide');
            });


            // mở modal để thay đổi trạn thái
            jQuery('.btn-edit').on('click', function(e) {
                e.preventDefault();
                // Mở modal
                jQuery('#editStatusModal').modal('show');
            });

            // Đóng modal khi nhấn "Hủy" hoặc ngoài modal
            jQuery('.btn-close, .btn-secondary').on('click', function() {
                jQuery('#editStatusModal').modal('hide');
            });
        });
    </script>
@endpush
