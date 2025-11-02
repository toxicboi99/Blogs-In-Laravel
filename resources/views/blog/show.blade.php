@extends('blog.layout')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <article class="card shadow-sm">
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 400px; object-fit: cover;">
            @endif
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-primary">{{ $post->category->name }}</span>
                    <small class="text-muted ms-3">
                        <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                        <i class="fas fa-calendar me-1 ms-3"></i>{{ $post->published_at->format('M d, Y') }}
                    </small>
                </div>
                
                <h1 class="h2 mb-4">{{ $post->title }}</h1>
                
                @if($post->excerpt)
                    <div class="lead mb-4">{{ $post->excerpt }}</div>
                @endif

                <div class="content">
                    {!! $post->content !!}
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Comments ({{ $post->approvedComments->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if($post->approvedComments->count() > 0)
                    @foreach($post->approvedComments as $comment)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ substr($comment->author_name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $comment->author_name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                <p class="mt-2 mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No comments yet. Be the first to comment!</p>
                @endif

                <!-- Comment Form -->
                <div class="mt-4">
                    <h6>Leave a Comment</h6>
                    <form method="POST" action="{{ route('comment.store', $post) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="author_name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('author_name') is-invalid @enderror" 
                                       id="author_name" name="author_name" value="{{ old('author_name') }}" required>
                                @error('author_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="author_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('author_email') is-invalid @enderror" 
                                       id="author_email" name="author_email" value="{{ old('author_email') }}" required>
                                @error('author_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Comment</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Post Comment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper me-2"></i>Related Posts
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="d-flex mb-3">
                            @if($relatedPost->featured_image)
                                <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                     class="flex-shrink-0 me-3" alt="{{ $relatedPost->title }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('blog.show', $relatedPost) }}" class="text-decoration-none">
                                        {{ Str::limit($relatedPost->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ $relatedPost->published_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Categories -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2"></i>Categories
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('blog.category', $category) }}" class="text-decoration-none d-flex justify-content-between align-items-center">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-secondary">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
