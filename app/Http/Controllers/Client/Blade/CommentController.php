<?php

namespace App\Http\Controllers\Client\Blade;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{

    private function checkAndRejectComment($commentContent)
    {
        foreach (Comment::getBannerKeywords() as $key) {
            if (stripos(strtolower($commentContent), strtolower($key)) !== false) {
                return $key;
            }
        }

        return 'pending';
    }

    public function getComments($articleId)
    {
        $article = Article::findOrFail($articleId);
        return $article->comments()
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->with(['parentComment', 'childComments'])
            ->get();
    }

    public function storeComment($articleId)
    {
        request()->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        try {
            $articlePost = Article::findOrFail($articleId);

            $parentComment = null;

            if ($parentId = request('parent_id')) {
                $parentComment = Comment::findOrFail($parentId);
            }

            $bannedKeyword = $this->checkAndRejectComment(request('content'));

            if ($bannedKeyword !== 'pending') {
                return back()->withErrors([
                    'message' => 'Bình luận của bạn chứa từ khóa cấm: "' .   $bannedKeyword . '"'
                ]);
            }

            $dataComment = [
                'user_id' => auth()->id(),
                'content' => request('content'),
                'article_id' => $articlePost->id,
                'parent_id' => $parentComment ? $parentComment->id : null,
                'status' => 'pending'
            ];

            Comment::create($dataComment);
            return redirect()
                ->route('client.single-post', $articlePost->id)
                ->with('success', 'Bình luận đã được đăng , Vui Lòng Chờ Xét Duyệt!!!');
        } catch (\Throwable $th) {
            Log::debug('message : ' . $th->getMessage());
            return back()->withErrors([
                'messages' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }

    public function replyComment($commentId)
    {
        request()->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        try {
            $parentComment = Comment::findOrFail($commentId);
            $articlePost = $parentComment->article;
            $parentId = request('parent_id') ? request('parent_id') : $parentComment->id;

            $status = $this->checkAndRejectComment(request('content'));

            $dataComment = [
                'user_id' => auth()->id(),
                'content' => request('content'),
                'article_id' => $articlePost->id,
                'parent_id' => $parentId,
                'status' => $status
            ];

            Comment::create($dataComment);
            return redirect()
                ->route('client.single-post', $articlePost->id)
                ->with('success', 'Bình luận đã được đăng , Vui Lòng Chờ Xét Duyệt!!!');
        } catch (\Throwable $th) {
            Log::debug('message : ' . $th->getMessage());
            return back()->withErrors([
                'messages' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }

    public function forceDestroyComment($commentId)
    {
        try {
            $comment = Comment::with(['parentComment', 'childComments', 'article'])->findOrFail($commentId);
            $comment->childComments()->forceDelete();
            $comment->forceDelete();

            return redirect()
                ->route('client.single-post', $comment->article->id)
                ->with('success', 'Xóa Thành Công');
        } catch (\Throwable $th) {
            Log::debug('Message : ' . $th->getMessage());
            return back()
                ->withErrors([
                    'message' => 'Có Lỗi Xảy Ra Khi Xóa Bình Luận !!!'
                ]);
        }
    }

    public function updateComment($commentId)
    {
        request()->validate([
            'content' => 'required|string|max:1000',
        ]);
        try {
            $comment = Comment::with(['parentComment', 'childComments', 'article'])->findOrFail($commentId);
            $commentData = [
                'content' => request('content')
            ];

            $comment->update($commentData);
            return redirect()
                ->route('client.single-post', $comment->article->id)
                ->with('success', 'Sửa Thành Công');
        } catch (\Throwable $th) {
            Log::debug('message : ' . $th->getMessage());
            return back()->withErrors([
                'messages' => 'Có Lỗi Xảy Ra !!!'
            ]);
        }
    }
}
