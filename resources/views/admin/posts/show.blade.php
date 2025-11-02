@extends('admin.layouts.app')

@section('title', 'View Post')
@section('page-title', 'View Post')

@section('page-actions')
    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Posts
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h1 class="h3 mb-3">{{ $post->title }}</h1>
                
                <div class="mb-3">
                    <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }} me-2">
                        {{ ucfirst($post->status) }}
                    </span>
                    <span class="text-muted">
                        <i class="fas fa-user me-1"></i>{{ $post->user->name }}
                        <i class="fas fa-tag me-1 ms-3"></i>{{ $post->category->name }}
                        <i class="fas fa-calendar me-1 ms-3"></i>{{ $post->created_at->format('M d, Y') }}
                    </span>
                </div>

                @if($post->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="img-fluid rounded">
                    </div>
                @endif

                @if($post->excerpt)
                    <div class="mb-4">
                        <h5>Excerpt</h5>
                        <p class="text-muted">{{ $post->excerpt }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h5>Content</h5>
                    <div class="content">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Slug:</dt>
                    <dd class="col-sm-8">{{ $post->slug }}</dd>
                    
                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </dd>
                    
                    <dt class="col-sm-4">Category:</dt>
                    <dd class="col-sm-8">{{ $post->category->name }}</dd>
                    
                    <dt class="col-sm-4">Author:</dt>
                    <dd class="col-sm-8">{{ $post->user->name }}</dd>
                    
                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $post->created_at->format('M d, Y H:i') }}</dd>
                    
                    @if($post->published_at)
                        <dt class="col-sm-4">Published:</dt>
                        <dd class="col-sm-8">{{ $post->published_at->format('M d, Y H:i') }}</dd>
                    @endif
                    
                    <dt class="col-sm-4">Updated:</dt>
                    <dd class="col-sm-8">{{ $post->updated_at->format('M d, Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Comments ({{ $post->comments->count() }})</h6>
            </div>
            <div class="card-body">
                @if($post->comments->count() > 0)
                    @foreach($post->comments->take(5) as $comment)
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $comment->author_name }}</h6>
                                <p class="mb-1">{{ Str::limit($comment->content, 100) }}</p>
                                <small class="text-muted">
                                    {{ $comment->created_at->diffForHumans() }}
                                    <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'warning') }} ms-2">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($post->comments->count() > 5)
                        <a href="{{ route('admin.comments.index', ['post' => $post->id]) }}" class="btn btn-sm btn-outline-primary">
                            View All Comments
                        </a>
                    @endif
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
