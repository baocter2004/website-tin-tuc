<?php

namespace App\Http\Controllers\Admin;

use App\Events\CommentStatusUpdate;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['parentComment', 'childComments', 'article', 'user'])
            ->latest('created_at')
            ->paginate(10);
        $selectOptions = Comment::Status;

        return view('admin.articles.comments.index', compact('comments', 'selectOptions'));
    }
    public function updateStatus(string $id)
    {
        try {
            $comment = Comment::findOrFail($id);

            $data = ['status' => request('status')];

            $comment->update($data);

            return redirect()->route('admin.comments.index')->with('success', 'Sửa Trạng Thái Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug('An ERROR WITH MESSAGE : ' . $th->getMessage());
            return back()->withErrors([
                'Có Lỗi Xảy Ra , Vui Lòng Kiểm Tra Lại !!!'
            ]);
        }
    }
    public function destroy(string $id)
    {
        try {
            $comments = Comment::findOrFail($id);
            $dataUpdate = [
                'status' => 'deleted',
                'deleted_at' => now(),
                'delete_reason' => request('delete_reason')
            ];
            $comments->update($dataUpdate);
            $comments->delete();
            return redirect()->route('admin.comments.index')->with('success', 'Thao Tác xóa Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug('An ERROR WITH MESSAGE : ' . $th->getMessage());
            return back()->withErrors([
                'Có Lỗi Xảy Ra , Vui Lòng Kiểm Tra Lại !!!'
            ]);
        }
    }
    public function forceDestroy(string $id)
    {
        try {
            $comments = Comment::findOrFail($id);
            $comments->forceDelete();
            return redirect()->route('admin.comments.index')->with('success', 'Thao Tác xóa Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug('An ERROR WITH MESSAGE : ' . $th->getMessage());
            return back()->withErrors([
                'Có Lỗi Xảy Ra , Vui Lòng Kiểm Tra Lại !!!'
            ]);
        }
    }
    public function trash()
    {
        $comments = Comment::onlyTrashed()
            ->with(['parentComment', 'childComments', 'article', 'user'])
            ->latest('created_at')
            ->paginate(10);

        return view('admin.articles.comments.trash', compact('comments'));
    }

    public function restore(string $id)
    {
        try {
            $comments = Comment::onlyTrashed()->findOrFail($id);
            $dataComment = [
                'delete_reason' => null,
                'status' => 'approved'
            ];
            $comments->restore();
            $comments->update($dataComment);
            return redirect()->route('admin.comments.index')->with('success', 'Thao Tác Khôi Phục Thành Công !!!');
        } catch (\Throwable $th) {
            Log::debug('An ERROR WITH MESSAGE : ' . $th->getMessage());
            return back()->withErrors([
                'Có Lỗi Xảy Ra , Vui Lòng Kiểm Tra Lại !!!'
            ]);
        }
    }
}
