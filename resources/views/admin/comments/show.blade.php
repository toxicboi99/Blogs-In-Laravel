@extends('admin.layouts.app')

@section('title', 'View Comment')
@section('page-title', 'View Comment')

@section('page-actions')
    <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Comments
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Comment Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>Comment Content</h5>
                    <div class="border p-3 rounded bg-light">
                        {{ $comment->content }}
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Post</h5>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">
                                    {{ $comment->post->title }}
                                </a>
                            </h6>
                            <p class="card-text text-muted">{{ Str::limit($comment->post->excerpt, 150) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Comment Info</h6>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Author:</dt>
                    <dd class="col-sm-8">{{ $comment->author_name }}</dd>
                    
                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8">{{ $comment->author_email }}</dd>
                    
                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </dd>
                    
                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $comment->created_at->format('M d, Y H:i') }}</dd>
                    
                    <dt class="col-sm-4">Updated:</dt>
                    <dd class="col-sm-8">{{ $comment->updated_at->format('M d, Y H:i') }}</dd>
                </dl>

                @if($comment->status === 'pending')
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('comments.approve', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Approve Comment
                            </button>
                        </form>
                        <form method="POST" action="{{ route('comments.reject', $comment) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Reject Comment
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
