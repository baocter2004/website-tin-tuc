@extends('client.layouts.master')
@section('title')
    Trang Chủ
@endsection
@section('content')
    <!-- Slider Section -->
    @include('client.layouts.partials.slide')
    <!-- /Slider Section -->
    <!-- Trending Category Section -->
    <section id="trending-category" class="trending-category section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="container" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-md-4">
                        <div class="post-entry lg">
                            <a href="{{ route('client.single-post', $articleLatest->id) }}">
                                <img src="{{ Storage::url($articleLatest->image) }}" alt="" class="img-fluid">
                            </a>
                            <div class="post-meta">
                                <span class="date">{{ $articleLatest->category->name }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $articleLatest->publish_at }}</span>
                            </div>
                            <h2><a
                                    href="{{ route('client.single-post', $articleLatest->id) }}">{{ $articleLatest->title }}</a>
                            </h2>
                            <p class="mb-4 d-block">
                                {{ Str::limit($articleLatest->summary, 150) }}
                            </p>

                            <ul class="tags list-unstyled d-flex flex-wrap">
                                @foreach ($articleLatest->tags as $tag)
                                    <li class="m-1">
                                        <a href="#" class="badge bg-secondary">{{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex align-items-center author">
                                <div class="name">
                                    <h3 class="m-0 p-0">{{ $articleLatest->user->first_name }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-5">
                            <div class="col-md-4 border-start custom-border">
                                @foreach ($articles->take(3) as $article)
                                    <div class="post-entry">
                                        <a href="{{ route('client.single-post', $article->id) }}">
                                            <img src="{{ Storage::url($article->image) }}" alt=""
                                                class="img-fluid">
                                        </a>
                                        <div class="post-meta">
                                            <span class="date">{{ $article->category->name }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $article->publish_at }}</span>
                                        </div>
                                        <h2><a
                                                href="{{ route('client.single-post', $article->id) }}">{{ $article->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4 border-start custom-border">
                                @foreach ($articles->skip(3)->take(3) as $article)
                                    <div class="post-entry">
                                        <a href="{{ route('client.single-post', $article->id) }}"><img
                                                src="{{ Storage::url($article->image) }}" alt=""
                                                class="img-fluid"></a>
                                        <div class="post-meta">
                                            <span class="date">{{ $article->category->name }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $article->publish_at }}</span>
                                        </div>
                                        <h2><a
                                                href="{{ route('client.single-post', $article->id) }}">{{ $article->title }}</a>
                                        </h2>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Trending Section -->
                            <div class="col-md-4">

                                <div class="trending">
                                    <h3>Trending</h3>
                                    <ul class="trending-post">
                                        @php
                                            $number = 1;
                                        @endphp
                                        @foreach ($articleTrending as $article)
                                            <li>
                                                <a href="{{ route('client.single-post', $article->id) }}">
                                                    <span class="number">{{ $number }}</span>
                                                    <h3>{{ $article->title }}</h3>
                                                    <span class="author">{{ $article->user->first_name }}</span>
                                                </a>
                                            </li>
                                            @php
                                                $number += 1;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </div>

                            </div> <!-- End Trending Section -->
                        </div>
                    </div>

                </div> <!-- End .row -->
            </div>

        </div>

    </section>
    <!-- /Trending Category Section -->

    <!-- Culture Category Section -->
    <section id="culture-category" class="culture-category section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <div class="section-title-container d-flex align-items-center justify-content-between">
                <h2>{{ $articleCultureViewest->category->name }}</h2>
                <p>
                    <a href="">Tất Cả Bài Viết Văn Hóa</a>
                </p>
            </div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">
                <div class="col-md-9">

                    <div class="d-lg-flex post-entry">
                        <a href="{{ route('client.single-post',$articleCultureViewest->id) }}"
                            class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">
                            <img src="{{ Storage::url($articleCultureViewest->image) }}" alt="" class="img-fluid"
                                width="600px">
                        </a>
                        <div>
                            <div class="post-meta">
                                <span class="date">{{ $articleCultureViewest->category->name }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $articleCultureViewest->publish_at }}</span>
                            </div>
                            <h3><a
                                    href="{{ route('client.single-post', $articleCultureViewest->id) }}">{{ $articleCultureViewest->title }}</a>
                            </h3>
                            <p>{{ Str::limit($articleCultureViewest->summary, 200) }}</p>
                            <div class="d-flex align-items-center author">
                                <div class="name">
                                    <h3 class="m-0 p-0">{{ $articleCultureViewest->user->first_name }}</h3>
                                </div>
                            </div>
                            <ul class="tags list-unstyled d-flex flex-wrap">
                                @foreach ($articleCultureViewest->tags as $tag)
                                    <li class="m-1">
                                        <a href="#" class="badge bg-secondary">{{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            @foreach ($articleCultures->take(2) as $article)
                                <div class="post-list border-bottom">
                                    @if ($article->image)
                                        <a href="{{ route('client.single-post', $article->id) }}"><img
                                                src="{{ Storage::url($article->image) }}" alt=""
                                                class="img-fluid"></a>
                                    @endif
                                    <div class="post-meta">
                                        <span class="date">{{ $article->category->name }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $article->publish_at }}</span>
                                    </div>
                                    <h2 class="mb-2"><a
                                            href="{{ route('client.single-post', $article->id) }}">{{ $article->title }}</a>
                                    </h2>
                                    <span class="author mb-3 d-block">{{ $article->user->first_name }}</span>
                                    <p class="mb-4 d-block">{{ Str::limit($article->summary, 30) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-8">
                            @if ($articleCultures->count() > 2)
                                <div class="post-list">
                                    @php $article = $articleCultures->last(); @endphp
                                    <a href="{{ route('client.single-post', $article->id) }}">
                                        <img src="{{ Storage::url($article->image) }}" alt="" class="img-fluid">
                                    </a>
                                    <div class="post-meta">
                                        <span class="date">{{ $article->category->name }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $article->publish_at }}</span>
                                    </div>
                                    <h2 class="mb-2"><a
                                            href="{{ route('client.single-post', $article->id) }}">{{ $article->title }}</a>
                                    </h2>
                                    <span class="author mb-3 d-block">{{ $article->user->first_name }}</span>
                                    <p class="mb-4 d-block">{{ Str::limit($article->summary, 220) }}</p>
                                    <p class="d-block">{{ Str::limit($article->content, 220) }}</p>
                                </div>
                                <ul class="tags list-unstyled d-flex flex-wrap">
                                    @foreach ($article->tags as $tag)
                                        <li class="m-1">
                                            <a href="#" class="badge bg-secondary">{{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-md-3">
                    @foreach ($articleCultures as $article)
                        <div class="post-list border-bottom">
                            <div class="post-meta">
                                <span class="date">{{ $article->category->name }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ $article->publish_at }}</span>
                            </div>
                            <h2 class="mb-2">
                                <a href="{{ route('client.single-post', $article->id) }}">{{ $article->title }}</a>
                            </h2>
                            <span class="author mb-3 d-block">{{ $article->user->first_name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>
    <!-- /Culture Category Section -->
@endsection
