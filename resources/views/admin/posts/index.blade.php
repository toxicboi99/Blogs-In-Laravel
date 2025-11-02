@extends('admin.layouts.app')

@section('title', 'Posts')
@section('page-title', 'Posts')

@section('page-actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>New Post
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $post->approval_status === 'approved' ? 'success' : ($post->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($post->approval_status) }}
                                </span>
                            </td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($post->approval_status === 'pending')
                                        <form method="POST" action="{{ route('admin.posts.approve', $post) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.posts.reject', $post) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
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
                            <td colspan="6" class="text-center">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
