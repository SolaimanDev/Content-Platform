@extends('layouts.app')
@section('content')
     <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Post Create</h6>
        </div>
        <div class="card-body">
           <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">   
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('category_id') }}</span>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="body" id="content" cols="30" rows="10" class="form-control"></textarea>
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                </div> 
                <div class="form-group">
                   <label for="tags">Tags (comma separated)</label>
                   <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags') }}">
                    <span class="text-danger">{{ $errors->first('tags') }}</span>
                </div> 
                             
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection