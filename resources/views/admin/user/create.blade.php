@extends('layouts.app')
@section('content')
     <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Create</h6>
        </div>
        <div class="card-body">
           <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">   
                @csrf
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" class="form-control" id="name">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">Email</label>
                    <input type="text" name="email" class="form-control" id="email">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                 <div class="form-group">
                    <label for="title">Confirmed Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                </div>
                <div class="form-group">
                    <label for="title">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="writer">Writer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection