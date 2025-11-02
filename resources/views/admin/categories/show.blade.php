@extends('admin.layouts.app')

@section('title', 'View Category')
@section('page-title', 'View Category')

@section('page-actions')
    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Category Details</h6>
            </div>
            <div class="card-body">
                <h1 class="h3 mb-3">{{ $category->name }}</h1>
                
                @if($category->description)
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $category->description }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h5>Posts in this Category ({{ $category->posts->count() }})</h5>
                    @if($category->posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->posts as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.posts.show', $post) }}" class="text-decoration-none">
                                                    {{ $post->title }}
                                                </a>
                                            </td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No posts in this category yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Category Info</h6>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Name:</dt>
                    <dd class="col-sm-8">{{ $category->name }}</dd>
                    
                    <dt class="col-sm-4">Slug:</dt>
                    <dd class="col-sm-8">{{ $category->slug }}</dd>
                    
                    <dt class="col-sm-4">Posts:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-primary">{{ $category->posts->count() }}</span>
                    </dd>
                    
                    <dt class="col-sm-4">Created:</dt>
                    <dd class="col-sm-8">{{ $category->created_at->format('M d, Y H:i') }}</dd>
                    
                    <dt class="col-sm-4">Updated:</dt>
                    <dd class="col-sm-8">{{ $category->updated_at->format('M d, Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
