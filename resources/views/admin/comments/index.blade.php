@extends('admin.layouts.app')

@section('title', 'Comments')
@section('page-title', 'Comments')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Post</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $comment->author_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $comment->author_email }}</small>
                                </div>
                            </td>
                            <td>{{ Str::limit($comment->content, 100) }}</td>
                            <td>
                                <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($comment->status) }}
                                </span>
                            </td>
                            <td>{{ $comment->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($comment->status === 'pending')
                                        <form method="POST" action="{{ route('comments.approve', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('comments.reject', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No comments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection
