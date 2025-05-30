@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
    </div>
    <div class="card-body">
       <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT') 
        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control" id="email">
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>

            <div class="form-group">
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control" id="password">
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="writer" {{ old('role', $user->role) == 'writer' ? 'selected' : '' }}>Writer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
