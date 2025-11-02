@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('page-actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>New Category
    </a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $category->posts_count }}</span>
                            </td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                            <td colspan="6" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
