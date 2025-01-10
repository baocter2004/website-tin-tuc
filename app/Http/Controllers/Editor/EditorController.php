<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function index() {
        $articles = Article::latest('id')->paginate(5);

        $comments = Comment::latest('id')->paginate(5);

        return view('editor.index',compact('articles'));
    }
}
