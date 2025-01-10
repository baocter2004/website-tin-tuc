<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ParagraphController;

use App\Http\Controllers\AuthenController;

use App\Http\Controllers\Author\AuthorController;

use App\Http\Controllers\Client\Blade\ClientController;
use App\Http\Controllers\Client\Blade\CommentController;

use App\Http\Controllers\Editor\EditorController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthenController::class)
    ->middleware('throttle:5,1')
    ->name('auth.')
    ->group(function () {
        Route::get('/register', 'showFormRegister')->name('register')->middleware('checkIfLogin');
        Route::post('/register', 'handleRegister');

        Route::get('/login', 'showFormLogin')->name('login');
        Route::post('/login', 'handleLogin');

        Route::post('/logout', 'logout')->name('logout')->middleware('auth');

        Route::get('/verify/{id}/{hash}', 'verify')->name('verify')->middleware('auth');
    });

Route::prefix('admin')
    ->middleware(['auth', 'checkRole:admin'])
    ->name('admin.')
    ->group(function () {
        Route::controller(DashboardController::class)
            ->group(function () {
                Route::get('/', 'index')->name('dashboard');
            });

        Route::prefix('users')
            ->name('users.')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{user}/show', 'show')->name('show');
                Route::get('/{user}/edit', 'edit')->name('edit');
                Route::put('/{user}', 'update')->name('update');
                Route::delete('/{user}', 'destroy')->name('destroy');

                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{user}', 'restore')->name('restore');
                Route::delete('/{user}/force-destroy', 'forceDestroy')->name('force-destroy');
            });

        Route::prefix('categories')
            ->name('categories.')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{category}/show', 'show')->name('show');
                Route::get('/{category}/edit', 'edit')->name('edit');
                Route::put('/{category}', 'update')->name('update');
                Route::delete('/{category}', 'destroy')->name('destroy');

                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{category}', 'restore')->name('restore');
                Route::delete('/{category}/force-destroy', 'forceDestroy')->name('force-destroy');
            });

        Route::prefix('articles')
            ->name('articles.')
            ->controller(ArticleController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{article}/show', 'show')->name('show');
                Route::get('/{article}/edit', 'edit')->name('edit');
                Route::put('/{article}', 'update')->name('update');
                Route::delete('/{article}', 'destroy')->name('destroy');

                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{article}', 'restore')->name('restore');
                Route::delete('/{article}/force-destroy', 'forceDestroy')->name('force-destroy');
            });

        Route::prefix('tags')
            ->name('tags.')
            ->controller(TagController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{tag}/show', 'show')->name('show');
                Route::get('/{tag}/edit', 'edit')->name('edit');
                Route::put('/{tag}', 'update')->name('update');
                Route::delete('/{tag}', 'destroy')->name('destroy');

                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{tag}', 'restore')->name('restore');
                Route::delete('/{tag}/force-destroy', 'forceDestroy')->name('force-destroy');
            });

        Route::prefix('paragraphs')
            ->name('paragraphs.')
            ->controller(ParagraphController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{paragraph}/show', 'show')->name('show');
                Route::get('/{paragraph}/edit', 'edit')->name('edit');
                Route::put('/{paragraph}', 'update')->name('update');
                Route::delete('/{paragraph}', 'destroy')->name('destroy');

                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{paragraph}', 'restore')->name('restore');
                Route::delete('/{paragraph}/force-destroy', 'forceDestroy')->name('force-destroy');
            });

        Route::prefix('comments')
            ->name('comments.')
            ->controller(AdminCommentController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/{comment}/update-status', 'updateStatus')->name('update-status');

                Route::delete('/{comment}', 'destroy')->name('destroy');
                Route::get('/trash', 'trash')->name('trash');
                Route::post('/trash/{comment}', 'restore')->name('restore');
                Route::delete('/{comment}/force-destroy', 'forceDestroy')->name('force-destroy');
            });
    });

Route::controller(EditorController::class)
    ->prefix('editors')
    ->name('editors.')
    ->middleware(['auth', 'checkRole:editor'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{article}/edit', 'edit')->name('edit');
        Route::put('/{article}', 'update')->name('update');
    });

Route::controller(AuthorController::class)
    ->name('authors.')
    ->middleware(['auth', 'checkRole:author'])
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::controller(ClientController::class)
    ->name('client.')
    ->middleware('shareDataToHeader')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/single-post/{id}', 'singlePost')->name('single-post');

        Route::name('comments.')
            ->controller(CommentController::class)
            ->group(function () {
                Route::post('/{articleId}', 'storeComment')->name('store-comment')->middleware(['checkLoginToComment']);
                Route::post('/reply-comment/{commentId}', 'replyComment')->name('reply-comment');
                Route::put('/update-comment/{commentId}', 'updateComment')->name('update-comment');
                Route::delete('/destroy-comment/{commentId}', 'forceDestroyComment')->name('destroy-comment');
            });
    });
