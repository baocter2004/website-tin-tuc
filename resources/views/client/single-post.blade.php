@extends('client.layouts.master')
@section('title')
    Chi Tiết - {{ $article->title }}
@endsection
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Single Post</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('client.index') }}">Home</a></li>
                    <li class="current">Single Post</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @if (session()->has('link'))
                    <a href="{{ route('auth.login') }}" class="btn btn-danger">
                        Login
                    </a>
                @endif
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">

            <div class="col-lg-8">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container">

                        <article class="article">

                            <div class="post-img text-center">
                                <img src="{{ Storage::url($article->image) }}" alt="" class="img-fluid">
                            </div>

                            <h2 class="title text-center">{{ $article->title }}</h2>

                            <div class="meta-top">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-person"></i>
                                        <a href="{{ route('client.single-post', $article->id) }}">
                                            {{ $article->user->last_name }} {{ $article->user->first_name }}
                                        </a>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-clock"></i>
                                        <a href="{{ route('client.single-post', $article->id) }}">
                                            <span>{{ $article->first()->publish_at }}</span>
                                        </a>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-chat-dots"></i>
                                        <a
                                            href="{{ route('client.single-post', $article->id) }}">{{ $comments->count() }}</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End meta top -->

                            <div class="content">
                                <p>
                                    {{ $article->content }}
                                </p>
                                <p class="mt-2">
                                    @foreach ($article->paragraphs as $paragraph)
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                @foreach ($paragraph->mediums as $media)
                                                    <img src="{{ Storage::url($media->file_path) }}"
                                                        class="img-fluid rounded-top" alt="" />
                                                @endforeach
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <span>{{ $paragraph->paragraph }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </p>
                            </div>
                            <!-- End post content -->

                            <div class="meta-bottom">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                    <li><a href="#">Business</a></li>
                                </ul>
                                <i class="bi bi-tags"></i>
                                <ul class="tags">
                                    @foreach ($article->tags as $tag)
                                        <li>
                                            <a href="#">{{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End meta bottom -->
                        </article>

                    </div>
                </section>
                <!-- /Blog Details Section -->

                <!-- Blog Comments Section -->
                <section id="blog-comments" class="blog-comments section">

                    <div class="container">

                        @if ($comments->isNotEmpty())
                            <h4 class="comments-count">{{ $comments->count() }} Comments</h4>
                        @else
                            <h4 class="comments-count">No comments yet</h4>
                        @endif
                        @foreach ($comments as $comment)
                            <div id="comment-{{ $comment->id }}" class="mb-4 p-3 border rounded">
                                <div class="d-flex align-items-start">
                                    <div class="comment-img me-3">
                                        <img width="50px" height="50px" class="rounded-circle"
                                            src="{{ Storage::url($comment->user->image) }}"
                                            alt="{{ $comment->user->first_name }}">
                                    </div>

                                    <div class="comment-body w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="font-weight-bold mb-1">{{ $comment->user->first_name }}
                                                {{ $comment->user->last_name }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>

                                        <div class="comment-content mt-2 mb-3">
                                            {{ $comment->content }}
                                        </div>

                                        @foreach ($comment->childComments as $childComment)
                                            @if ($childComment->status === 'approved' && $childComment->parent_id == $comment->id)
                                                <div class="d-flex mt-3 ms-4">
                                                    <img src="{{ Storage::url($childComment->user->image) }}"
                                                        class="rounded-circle flex-shrink-0"
                                                        alt="{{ $childComment->user->first_name }}"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                    <div class="ms-3">
                                                        <h6 class="mb-1">{{ $childComment->user->first_name }}
                                                            {{ $childComment->user->last_name }}</h6>
                                                        <p class="mt-2" id="comment-content-{{ $childComment->id }}">
                                                            {{ $childComment->content }}
                                                        </p>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <button class="btn btn-link btn-sm reply-btn"
                                                                    data-id="{{ $comment->id }}">Reply</button>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <form
                                                                    action="{{ route('client.comments.update-comment', $childComment->id) }}"
                                                                    method="POST" class="edit-form"
                                                                    id="edit-form-{{ $childComment->id }}"
                                                                    style="display: none;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <textarea class="form-control mb-2" name="content" rows="2">{{ $childComment->content }}</textarea>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Save</button>
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm cancel-edit"
                                                                        data-id="{{ $childComment->id }}">Cancel</button>
                                                                </form>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="d-flex mt-2">
                                                                    @if (auth()->check() && auth()->user()->id === $childComment->user_id)
                                                                        <button class="btn btn-link btn-sm edit-comment-btn"
                                                                            data-id="{{ $childComment->id }}">Edit</button>
                                                                        <form
                                                                            action="{{ route('client.comments.destroy-comment', $childComment->id) }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-link btn-sm text-danger"
                                                                                type="submit"
                                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach ($childComment->childComments as $grandChildComment)
                                                    @if ($grandChildComment->status === 'approved')
                                                        <div class="ms-4 mt-3 border-start ps-3">
                                                            <div class="d-flex align-items-start">
                                                                <img src="{{ Storage::url($grandChildComment->user->image) }}"
                                                                    class="rounded-circle flex-shrink-0 me-3"
                                                                    style="width: 30px; height: 30px;">
                                                                <div class="flex-grow-1">
                                                                    <h6>{{ $grandChildComment->user->first_name }}
                                                                        {{ $grandChildComment->user->last_name }}</h6>
                                                                    <p>{{ $grandChildComment->content }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        <div class="d-flex mt-3">
                                            @if (auth()->check() && auth()->user()->id === $comment->user_id)
                                                <button class="btn btn-link btn-sm edit-comment-btn"
                                                    data-id="{{ $comment->id }}">Edit</button>
                                                <form
                                                    action="{{ route('client.comments.destroy-comment', $comment->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link btn-sm text-danger" type="submit"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endif

                                            @if ($comment->parent_id == 0)
                                                <button class="btn btn-link btn-sm reply-btn"
                                                    data-id="{{ $comment->id }}">Reply</button>
                                            @endif
                                        </div>

                                        <form action="{{ route('client.comments.update-comment', $comment->id) }}"
                                            method="POST" class="edit-form" id="edit-form-{{ $comment->id }}"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
                                            <textarea class="form-control mb-2" name="content" rows="2">{{ $comment->content }}</textarea>
                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                            <button type="button" class="btn btn-secondary btn-sm cancel-edit"
                                                data-id="{{ $comment->id }}">Cancel</button>
                                        </form>

                                        @if ($comment->parent_id == 0)
                                            <form action="{{ route('client.comments.reply-comment', $comment->id) }}"
                                                method="POST" id="form-reply-{{ $comment->id }}"
                                                class="mt-2 reply-form" style="display:none;">
                                                @csrf
                                                <textarea class="form-control" name="content" rows="2" placeholder="Enter your reply..."></textarea>
                                                <button class="btn btn-primary btn-sm mt-2">Submit</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </section>
                <!-- /Blog Comments Section -->

                <!-- Comment Form Section -->
                <section id="comment-form" class="comment-form section">
                    <div class="container">

                        <form action="{{ route('client.comments.store-comment', $article->id) }}" method="POST">
                            @csrf
                            <h4>Post Comment</h4>
                            <p>Your email address will not be published. Required fields are marked * </p>
                            <div class="row">
                                <div class="col form-group">
                                    <textarea name="content" class="form-control" placeholder="Your Comment*"></textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Post Comment

                                </button>
                            </div>

                        </form>

                    </div>
                </section><!-- /Comment Form Section -->

            </div>

            <div class="col-lg-4 sidebar">

                <div class="widgets-container">

                    <!-- Blog Author Widget -->
                    <div class="blog-author-widget widget-item">
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center w-100">
                                <img src="{{ Storage::url($article->user->image) }}" class="rounded-circle flex-shrink-0"
                                    alt="{{ $article->user->first_name }}"
                                    style="width: 80px; height: 80px; object-fit: cover;">

                                <div class="ms-3">
                                    <h4 class="mb-0">
                                        {{ $article->user->last_name }} {{ $article->user->first_name }}
                                    </h4>
                                    <small class="text-muted">{{ $article->user->email }}</small>
                                    <div class="social-links mt-2">
                                        <a href="https://x.com/#" class="text-muted me-2" target="_blank"><i
                                                class="bi bi-twitter"></i></a>
                                        <a href="https://facebook.com/#" class="text-muted me-2" target="_blank"><i
                                                class="bi bi-facebook"></i></a>
                                        <a href="https://instagram.com/#" class="text-muted me-2" target="_blank"><i
                                                class="bi bi-instagram"></i></a>
                                        <a href="https://linkedin.com/#" class="text-muted" target="_blank"><i
                                                class="bi bi-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Author Description -->
                            <p class="mt-3 text-center">
                                {{ $article->user->last_name }} {{ $article->user->first_name }} is a passionate writer
                                who shares insightful content with the world. Feel free to follow on social media or contact
                                via email.
                            </p>
                        </div>
                    </div>
                    <!--/Blog Author Widget -->

                    <!-- Search Widget -->
                    <div class="search-widget widget-item">

                        <h3 class="widget-title">Search</h3>
                        <form action="">
                            <input type="text">
                            <button type="submit" title="Search"><i class="bi bi-search"></i>
                            </button>
                        </form>

                    </div><!--/Search Widget -->

                    <!-- Recent Posts Widget -->
                    <div class="recent-posts-widget widget-item">

                        <h3 class="widget-title">Recent Posts</h3>
                        @foreach ($recentArticles as $recentArticle)
                            <div class="post-item">
                                <img src="{{ Storage::url($recentArticle->image) }}" alt=""
                                    class="flex-shrink-0">
                                <div>
                                    <h4>
                                        <a
                                            href="{{ route('client.single-post', $recentArticle->id) }}">{{ $recentArticle->title }}</a>
                                    </h4>
                                    <span>{{ $recentArticle->publish_at }}</span>
                                </div>
                            </div><!-- End recent post item-->
                        @endforeach
                    </div><!--/Recent Posts Widget -->

                    <!-- Tags Widget -->
                    <div class="tags-widget widget-item">

                        <h3 class="widget-title">Tags</h3>
                        <ul>
                            @foreach ($tags as $tag)
                                <li><a href="#">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                    </div><!--/Tags Widget -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Mở form sửa bình luận
            $('.edit-comment-btn').on('click', function() {
                var commentId = $(this).data('id');
                $('#comment-content-' + commentId).hide();
                $('#edit-form-' + commentId).show();
            });

            // Đóng form sửa khi nhấn "Cancel"
            $('.cancel-edit').on('click', function() {
                var commentId = $(this).data('id');
                $('#edit-form-' + commentId).hide();
                $('#comment-content-' + commentId).show();
            });

            // Mở form trả lời bình luận
            $('.reply-btn').on('click', function() {
                var commentId = $(this).data('id');
                $('#form-reply-' + commentId).toggle();
            });
        });
    </script>
@endpush
