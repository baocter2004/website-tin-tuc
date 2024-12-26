<?php

namespace App\Http\Controllers\Client\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $articles = Article::with('category','user','tags')->latest('created_at')->take(5)->get();
        return response()->json($articles, 200);
    }
}
