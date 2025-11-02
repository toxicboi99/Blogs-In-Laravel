@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_posts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Published Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published_posts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Draft Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['draft_posts'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-edit fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Categories</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_categories'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Comments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_comments'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Pending Comments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_comments'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Posts</h6>
            </div>
            <div class="card-body">
                @if($recent_posts->count() > 0)
                    @foreach($recent_posts as $post)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $post->category->name }} • {{ $post->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No posts yet.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Comments</h6>
            </div>
            <div class="card-body">
                @if($recent_comments->count() > 0)
                    @foreach($recent_comments as $comment)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.comments.show', $comment) }}" class="text-decoration-none">
                                        {{ Str::limit($comment->content, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    By {{ $comment->author_name }} on {{ $comment->post->title }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
