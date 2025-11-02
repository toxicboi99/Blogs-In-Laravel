@extends('blog.layout')

@section('title', $category->name)

@section('hero')
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">{{ $category->name }}</h1>
        @if($category->description)
            <p class="lead">{{ $category->description }}</p>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        @if($posts->count() > 0)
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-6 mb-4">
                        <div class="card post-card h-100 shadow-sm">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    <small class="text-muted ms-2">{{ $post->published_at->format('M d, Y') }}</small>
                                </div>
                                <h5 class="card-title">
                                    <a href="{{ route('blog.show', $post) }}" class="text-decoration-none text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                @if($post->excerpt)
                                    <p class="card-text text-muted">{{ Str::limit($post->excerpt, 120) }}</p>
                                @endif
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                                        </small>
                                        <a href="{{ route('blog.show', $post) }}" class="btn btn-outline-primary btn-sm">
                                            Read More <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No posts in this category</h3>
                <p class="text-muted">Check back later for new content!</p>
                <a href="{{ route('blog.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to All Posts
                </a>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="sidebar">
            <h5 class="mb-3">
                <i class="fas fa-tags me-2"></i>All Categories
            </h5>
            @if($categories->count() > 0)
                <ul class="list-unstyled">
                    @foreach($categories as $cat)
                        <li class="mb-2">
                            <a href="{{ route('blog.category', $cat) }}" 
                               class="text-decoration-none d-flex justify-content-between align-items-center {{ $cat->id === $category->id ? 'fw-bold' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="badge bg-{{ $cat->id === $category->id ? 'primary' : 'secondary' }}">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No categories available.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Back to All Posts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
