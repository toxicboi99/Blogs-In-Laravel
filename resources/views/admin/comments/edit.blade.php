@extends('admin.layouts.app')

@section('title', 'Edit Comment')
@section('page-title', 'Edit Comment')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.comments.update', $comment) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="content" class="form-label">Comment Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="6" required>{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $comment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $comment->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $comment->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Author Info</label>
                        <div class="border p-3 rounded bg-light">
                            <strong>{{ $comment->author_name }}</strong><br>
                            <small class="text-muted">{{ $comment->author_email }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Post</label>
                        <div class="border p-3 rounded bg-light">
                            <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-decoration-none">
                                {{ $comment->post->title }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Comment</button>
            </div>
        </form>
    </div>
</div>
@endsection
