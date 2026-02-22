@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="form-card text-center">
            <div class="user-avatar" style="width: 150px; height: 150px; margin: 0 auto 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 3rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <h4>{{ Auth::user()->name }}</h4>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <p><span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span></p>
            
            <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="file" name="avatar" class="form-control mb-2" accept="image/*">
                <button type="submit" class="btn btn-sm btn-primary">Update Avatar</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="form-card">
            <h5>Profile Information</h5>
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}" required>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ Auth::user()->city }}">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ Auth::user()->state }}">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ Auth::user()->postal_code }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ Auth::user()->country }}">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4">{{ Auth::user()->bio }}</textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
        
        <div class="form-card mt-4">
            <h5>Change Password</h5>
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-warning">Change Password</button>
            </form>
        </div>
    </div>
</div>
@endsection