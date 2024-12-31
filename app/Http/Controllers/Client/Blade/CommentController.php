<?php

namespace App\Http\Controllers\Client\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCommentClientRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeComment($articleId) {
        $dataComment = request()->validate([
            'content' => 'required|string|max:1000',
            'user_id' => 'required',
            'article_id' => 'required',
            'status' => 'required',
        ]);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
