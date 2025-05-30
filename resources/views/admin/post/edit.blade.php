@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $post->title) }}">
                <span class="text-danger">{{ $errors->first('title') }}</span>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" id="category" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('category_id') }}</span>
            </div>
            
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" id="image">
                <span class="text-danger">{{ $errors->first('image') }}</span>
                
                @if($post->image_path)
                    <div class="mt-2">
                        <img src="{{ Storage::url($post->image_path) }}" alt="Current Image" width="150" class="img-thumbnail">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                            <label for="remove_image" class="form-check-label">Remove current image</label>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="body" id="content" cols="30" rows="10" class="form-control">{{ old('body', $post->body) }}</textarea>
                <span class="text-danger">{{ $errors->first('body') }}</span>
            </div>
            <div class="form-group">
                   <label for="tags">Tags (comma separated)</label>
                  <input type="text" name="tags" value="{{ old('tags', $tagNames) }}" class="form-control" placeholder="Enter tags, separated by commas">
                    <span class="text-danger">{{ $errors->first('tags') }}</span>
            </div> 
            @if(auth()->user()->role == 'admin')
            
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="2" {{ $post->status == 2 ? 'selected' : '' }}>Inactive</option>
                    <option value="3" {{ $post->status == 3 ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            @endif
            
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection