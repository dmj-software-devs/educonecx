@extends('layouts.main')

@section('title', 'Profile - EDUCONECX | Your Account Settings')

@section('meta_description', 'Manage your profile information, update your avatar, change password, and customize your account settings on EDUCONECX.')

@push('styles')
<style>
    /* ===== Original styles (kept intact) ===== */
    .profile-container { padding: 40px 0; background: var(--light); min-height: calc(100vh - 400px); }
    .page-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
    .page-title { font-size: 2rem; font-weight: 700; color: var(--dark); margin: 0; display: flex; align-items: center; gap: 12px; }
    .page-title i { color: var(--primary); font-size: 2rem; }
    .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: var(--white); color: var(--dark); border-radius: var(--border-radius-full); text-decoration: none; font-weight: 500; transition: var(--transition); box-shadow: var(--shadow-sm); }
    .back-btn:hover { background: var(--primary); color: var(--white); transform: translateX(-5px); }
    .profile-card { background: var(--white); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; position: sticky; top: 100px; }
    .profile-cover { height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; }
    .profile-cover::before { content: ''; position: absolute; top: -50%; right: -10%; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: float 8s ease-in-out infinite; }
    .profile-cover::after { content: ''; position: absolute; bottom: -50%; left: -10%; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: float 6s ease-in-out infinite reverse; }
    .profile-avatar-wrapper { position: relative; margin-top: -60px; padding: 0 20px; display: flex; justify-content: center; z-index: 2; }
    .profile-avatar { width: 120px; height: 120px; border-radius: 50%; border: 4px solid var(--white); box-shadow: var(--shadow-lg); background: var(--white); overflow: hidden; position: relative; cursor: pointer; transition: var(--transition); }
    .profile-avatar:hover { transform: scale(1.05); }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-placeholder { width: 100%; height: 100%; background: var(--gradient-1); color: var(--white); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 600; }
    .avatar-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; opacity: 0; transition: var(--transition); }
    .profile-avatar:hover .avatar-overlay { opacity: 1; }
    .avatar-overlay i { color: var(--white); font-size: 1.5rem; }
    .profile-info { padding: 20px; text-align: center; border-bottom: 1px solid var(--gray-light); }
    .profile-name { font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 5px; }
    .profile-email { color: var(--gray); font-size: 0.95rem; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; gap: 5px; }
    .profile-email i { color: var(--primary); }
    .profile-badge { display: inline-block; padding: 5px 15px; background: var(--light); border-radius: var(--border-radius-full); font-size: 0.8rem; color: var(--primary); font-weight: 600; }
    .profile-stats { display: flex; justify-content: space-around; padding: 20px; border-bottom: 1px solid var(--gray-light); }
    .stat-item { text-align: center; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-bottom: 5px; }
    .stat-label { color: var(--gray); font-size: 0.85rem; }
    .profile-menu { padding: 15px; }
    .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: var(--border-radius-md); color: var(--gray); text-decoration: none; transition: var(--transition); margin-bottom: 5px; }
    .menu-item i { width: 20px; color: var(--primary); }
    .menu-item:hover { background: var(--light); color: var(--primary); transform: translateX(5px); }
    .menu-item.active { background: var(--gradient-1); color: var(--white); }
    .menu-item.active i { color: var(--white); }
    .form-card { background: var(--white); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; margin-bottom: 30px; }
    .form-header { padding: 20px 25px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 1px solid var(--gray-light); display: flex; align-items: center; gap: 10px; }
    .form-header i { width: 40px; height: 40px; background: var(--gradient-1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white); font-size: 1.2rem; }
    .form-header h3 { font-size: 1.3rem; font-weight: 700; color: var(--dark); margin: 0; }
    .form-body { padding: 30px; }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group.full-width { grid-column: span 2; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark); font-size: 0.95rem; }
    .form-label i { color: var(--primary); margin-right: 8px; }
    .form-control { width: 100%; padding: 12px 15px; border: 2px solid var(--gray-light); border-radius: var(--border-radius-md); font-size: 0.95rem; transition: var(--transition); background: var(--white); }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); }
    .form-control.is-invalid { border-color: var(--danger); }
    .invalid-feedback { color: var(--danger); font-size: 0.85rem; margin-top: 5px; display: flex; align-items: center; gap: 5px; }
    .avatar-upload { background: var(--light); border-radius: var(--border-radius-lg); padding: 20px; margin: 20px; border: 2px dashed var(--gray-light); transition: var(--transition); }
    .avatar-upload:hover { border-color: var(--primary); background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
    .file-input { position: relative; margin-bottom: 15px; }
    .file-input input { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
    .file-label { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px; background: var(--white); border: 2px solid var(--gray-light); border-radius: var(--border-radius-md); font-weight: 500; color: var(--gray); transition: var(--transition); cursor: pointer; }
    .file-label:hover { border-color: var(--primary); color: var(--primary); }
    .file-label i { font-size: 1.2rem; }
    .upload-btn { width: 100%; padding: 12px; background: var(--gradient-1); color: var(--white); border: none; border-radius: var(--border-radius-md); font-weight: 600; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 8px; }
    .upload-btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .form-actions { display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--gray-light); }
    .btn-primary { padding: 12px 30px; background: var(--gradient-1); color: var(--white); border: none; border-radius: var(--border-radius-full); font-weight: 600; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
    .btn-secondary { padding: 12px 30px; background: transparent; color: var(--gray); border: 2px solid var(--gray-light); border-radius: var(--border-radius-full); font-weight: 600; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
    .btn-secondary:hover { border-color: var(--primary); color: var(--primary); }
    .btn-warning { padding: 12px 30px; background: linear-gradient(135deg, #f72585 0%, #b5179e 100%); color: var(--white); border: none; border-radius: var(--border-radius-full); font-weight: 600; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; gap: 8px; }
    .btn-warning:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(247, 37, 133, 0.3); }
    .alert { padding: 15px 20px; border-radius: var(--border-radius-md); margin-bottom: 25px; display: flex; align-items: center; gap: 12px; animation: slideInDown 0.5s ease-out; }
    .alert-success { background: #f0fdf4; color: var(--success); border: 1px solid #dcfce7; }
    .alert-danger { background: #fef2f2; color: var(--danger); border: 1px solid #fee2e2; }
    .alert i { font-size: 1.2rem; }
    .alert-content { flex: 1; }
    .alert-content h4 { font-weight: 600; margin-bottom: 3px; }
    .alert-content p { font-size: 0.95rem; opacity: 0.9; }
    .alert-close { background: none; border: none; color: currentColor; cursor: pointer; opacity: 0.5; transition: var(--transition); }
    .alert-close:hover { opacity: 1; }
    .password-strength { margin-top: 8px; }
    .strength-meter { display: flex; gap: 5px; margin-bottom: 5px; }
    .strength-segment { height: 4px; flex: 1; background: var(--gray-light); border-radius: 2px; transition: var(--transition); }
    .strength-segment.active { background: var(--success); }
    .strength-segment.active.weak { background: var(--danger); }
    .strength-segment.active.medium { background: var(--warning); }
    .strength-segment.active.strong { background: var(--success); }
    .strength-text { font-size: 0.8rem; color: var(--gray); }
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: span 1; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary, .btn-warning { width: 100%; justify-content: center; }
    }

    /* ===== Enhanced Professional UI ===== */
    .profile-cover {
        background: linear-gradient(135deg, #667eea, #764ba2, #e06b9d);
        background-size: 300% 300%;
        animation: gradientShift 10s ease infinite;
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .profile-avatar {
        border: 4px solid transparent;
        background: linear-gradient(white, white) padding-box, 
                    linear-gradient(145deg, var(--primary), var(--accent)) border-box;
        box-shadow: 0 15px 30px -5px rgba(67,97,238,0.3);
    }
    .menu-item {
        position: relative;
        overflow: hidden;
    }
    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--primary);
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }
    .menu-item:hover::before,
    .menu-item.active::before {
        transform: scaleY(1);
    }
    .menu-item.active::before {
        background: white;
    }
    .form-card {
        border: none;
        box-shadow: 0 15px 30px -10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .form-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 35px -10px rgba(67,97,238,0.15);
    }
    .form-header i {
        box-shadow: 0 5px 15px rgba(67,97,238,0.3);
    }
    .form-control {
        border-radius: 12px;
        border: 1px solid var(--gray-light);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67,97,238,0.1);
    }
    .file-label {
        border-radius: 30px;
        transition: all 0.3s;
    }
    .strength-segment {
        height: 6px;
        border-radius: 3px;
    }
    .btn-primary, .btn-warning {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 30px;
    }
    .btn-secondary {
        background: white;
        border-radius: 30px;
    }
    .alert {
        border-left: 4px solid currentColor;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .stat-item .stat-value {
        background: linear-gradient(145deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .back-btn {
        border: 1px solid var(--gray-light);
        border-radius: 30px;
    }
    .back-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
    }
</style>
@endpush

@section('content')
    <!-- Profile Container -->
    <div class="profile-container">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header" data-aos="fade-up">
                <h1 class="page-title">
                    <i class="fas fa-user-circle"></i>
                    My Profile
                </h1>
                
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="profile-card" data-aos="fade-right">
                        <div class="profile-cover"></div>
                        
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar" onclick="document.getElementById('avatarInput').click()">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="avatar-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                        </div>

                        <div class="profile-info">
                            <h2 class="profile-name">{{ Auth::user()->name }}</h2>
                            <p class="profile-email">
                                <i class="fas fa-envelope"></i>
                                {{ Auth::user()->email }}
                            </p>
                            <span class="profile-badge">
                                <i class="fas fa-certificate"></i>
                                Member since {{ \Carbon\Carbon::parse(Auth::user()->created_at ?? now())->format('M Y') }}
                            </span>
                        </div>

                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $stats['courses_completed'] ?? 0 }}</div>
                                <div class="stat-label">Completed</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $stats['certificates'] ?? 0 }}</div>
                                <div class="stat-label">Certificates</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $stats['quizzes_taken'] ?? 0 }}</div>
                                <div class="stat-label">Quizzes</div>
                            </div>
                        </div>

                        <!-- Avatar Upload Form -->
                        <div class="avatar-upload">
                            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                                @csrf
                                <div class="file-input">
                                    <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewAvatar(this)">
                                    <label for="avatarInput" class="file-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        Choose New Avatar
                                    </label>
                                </div>
                                <button type="submit" class="upload-btn" id="uploadBtn" style="display: none;">
                                    <i class="fas fa-upload"></i>
                                    Upload Avatar
                                </button>
                            </form>
                            <p class="text-muted small mt-2 mb-0">
                                <i class="fas fa-info-circle"></i>
                                Max file size: 2MB. Supported: JPG, PNG, GIF
                            </p>
                        </div>

                        <!-- Quick Menu -->
                        <div class="profile-menu">
                            <a href="#profile-info" class="menu-item active" onclick="smoothScroll('profile-info')">
                                <i class="fas fa-user"></i>
                                Profile Information
                            </a>
                            <a href="#change-password" class="menu-item" onclick="smoothScroll('change-password')">
                                <i class="fas fa-lock"></i>
                                Change Password
                            </a>
                            <a href="#notification-settings" class="menu-item" onclick="smoothScroll('notification-settings')">
                                <i class="fas fa-bell"></i>
                                Notification Settings
                            </a>
                            <a href="#privacy-settings" class="menu-item" onclick="smoothScroll('privacy-settings')">
                                <i class="fas fa-shield-alt"></i>
                                Privacy Settings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success" id="successAlert">
                            <i class="fas fa-check-circle"></i>
                            <div class="alert-content">
                                <p>{{ session('success') }}</p>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" id="errorAlert">
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="alert-content">
                                <h4>Please fix the following errors:</h4>
                                <ul style="margin-top: 5px; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    <!-- Profile Information Form -->
                    <div id="profile-info" class="form-card" data-aos="fade-up">
                        <div class="form-header">
                            <i class="fas fa-user-edit"></i>
                            <h3>Profile Information</h3>
                        </div>

                        <div class="form-body">
                            <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                                @csrf
                                @method('PUT')

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            First Name
                                        </label>
                                        <input type="text" 
                                               name="first_name" 
                                               class="form-control @error('first_name') is-invalid @enderror" 
                                               value="{{ old('first_name', Auth::user()->first_name) }}" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Last Name
                                        </label>
                                        <input type="text" 
                                               name="last_name" 
                                               class="form-control @error('last_name') is-invalid @enderror" 
                                               value="{{ old('last_name', Auth::user()->last_name) }}" 
                                               required>
                                    </div>

                                    <div class="form-group full-width">
                                        <label class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            Email Address
                                        </label>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', Auth::user()->email) }}" 
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Phone Number
                                        </label>
                                        <input type="tel" 
                                               name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               value="{{ old('phone', Auth::user()->phone) }}"
                                               placeholder="+1 (555) 000-0000">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Address
                                        </label>
                                        <input type="text" 
                                               name="address" 
                                               class="form-control @error('address') is-invalid @enderror" 
                                               value="{{ old('address', Auth::user()->address) }}"
                                               placeholder="Street address">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-city"></i>
                                            City
                                        </label>
                                        <input type="text" 
                                               name="city" 
                                               class="form-control @error('city') is-invalid @enderror" 
                                               value="{{ old('city', Auth::user()->city) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map"></i>
                                            State
                                        </label>
                                        <input type="text" 
                                               name="state" 
                                               class="form-control @error('state') is-invalid @enderror" 
                                               value="{{ old('state', Auth::user()->state) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-mail-bulk"></i>
                                            Postal Code
                                        </label>
                                        <input type="text" 
                                               name="postal_code" 
                                               class="form-control @error('postal_code') is-invalid @enderror" 
                                               value="{{ old('postal_code', Auth::user()->postal_code) }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-globe"></i>
                                            Country
                                        </label>
                                        <select name="country" class="form-control @error('country') is-invalid @enderror">
                                            <option value="">Select Country</option>
                                            <option value="US" {{ (old('country', Auth::user()->country) == 'US') ? 'selected' : '' }}>United States</option>
                                            <option value="CA" {{ (old('country', Auth::user()->country) == 'CA') ? 'selected' : '' }}>Canada</option>
                                            <option value="UK" {{ (old('country', Auth::user()->country) == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="AU" {{ (old('country', Auth::user()->country) == 'AU') ? 'selected' : '' }}>Australia</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>

                                    <div class="form-group full-width">
                                        <label class="form-label">
                                            <i class="fas fa-align-left"></i>
                                            Bio
                                        </label>
                                        <textarea name="bio" 
                                                  class="form-control @error('bio') is-invalid @enderror" 
                                                  rows="4" 
                                                  placeholder="Tell us a little about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="reset" class="btn-secondary" onclick="resetForm('profileForm')">
                                        <i class="fas fa-undo"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-save"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div id="change-password" class="form-card" data-aos="fade-up">
                        <div class="form-header">
                            <i class="fas fa-lock"></i>
                            <h3>Change Password</h3>
                        </div>

                        <div class="form-body">
                            <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-key"></i>
                                        Current Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="current_password" 
                                               class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password"
                                               required>
                                        <button type="button" class="toggle-password" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-lock"></i>
                                        New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="new_password" 
                                               class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password"
                                               oninput="checkPasswordStrength(this.value)"
                                               required>
                                        <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Password Strength Meter -->
                                    <div class="password-strength" id="passwordStrength">
                                        <div class="strength-meter">
                                            <div class="strength-segment" id="strength1"></div>
                                            <div class="strength-segment" id="strength2"></div>
                                            <div class="strength-segment" id="strength3"></div>
                                            <div class="strength-segment" id="strength4"></div>
                                        </div>
                                        <span class="strength-text" id="strengthText">Enter a password</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-lock"></i>
                                        Confirm New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               name="new_password_confirmation" 
                                               class="form-control" 
                                               id="new_password_confirmation"
                                               required>
                                        <button type="button" class="toggle-password" onclick="togglePassword('new_password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="reset" class="btn-secondary" onclick="resetForm('passwordForm')">
                                        <i class="fas fa-undo"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn-warning">
                                        <i class="fas fa-sync-alt"></i>
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Notification Settings (Optional) -->
                    <div id="notification-settings" class="form-card" data-aos="fade-up">
                        <div class="form-header">
                            <i class="fas fa-bell"></i>
                            <h3>Notification Settings</h3>
                        </div>

                        <div class="form-body">
                            <form action="#" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label class="form-check">
                                        <input type="checkbox" name="email_notifications" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                        <span>Email Notifications</span>
                                        <small class="text-muted d-block">Receive updates about new courses and promotions</small>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="form-check">
                                        <input type="checkbox" name="course_updates" {{ Auth::user()->course_updates ? 'checked' : '' }}>
                                        <span>Course Updates</span>
                                        <small class="text-muted d-block">Get notified when your courses have new content</small>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="form-check">
                                        <input type="checkbox" name="achievement_alerts" {{ Auth::user()->achievement_alerts ? 'checked' : '' }}>
                                        <span>Achievement Alerts</span>
                                        <small class="text-muted d-block">Celebrate when you earn new certificates</small>
                                    </label>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-save"></i>
                                        Save Preferences
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = event.currentTarget.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password strength checker
    function checkPasswordStrength(password) {
        if (!password) {
            resetStrengthMeter();
            return;
        }
        
        const strengthSegments = [
            document.getElementById('strength1'),
            document.getElementById('strength2'),
            document.getElementById('strength3'),
            document.getElementById('strength4')
        ];
        const strengthText = document.getElementById('strengthText');
        
        let score = 0;
        
        // Length check
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        
        // Contains number
        if (/\d/.test(password)) score++;
        
        // Contains special character
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) score++;
        
        // Contains uppercase and lowercase
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
        
        // Cap at 4
        score = Math.min(score, 4);
        
        // Reset all segments
        strengthSegments.forEach(segment => {
            segment.classList.remove('active', 'weak', 'medium', 'strong');
        });
        
        // Update segments based on strength
        for (let i = 0; i < score; i++) {
            strengthSegments[i].classList.add('active');
            if (score <= 2) {
                strengthSegments[i].classList.add('weak');
            } else if (score === 3) {
                strengthSegments[i].classList.add('medium');
            } else if (score === 4) {
                strengthSegments[i].classList.add('strong');
            }
        }
        
        const messages = ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'];
        strengthText.textContent = messages[score];
    }

    function resetStrengthMeter() {
        const strengthSegments = document.querySelectorAll('.strength-segment');
        const strengthText = document.getElementById('strengthText');
        
        strengthSegments.forEach(segment => {
            segment.classList.remove('active', 'weak', 'medium', 'strong');
        });
        
        strengthText.textContent = 'Enter a password';
    }

    // Avatar preview
    function previewAvatar(input) {
        const uploadBtn = document.getElementById('uploadBtn');
        if (input.files && input.files[0]) {
            uploadBtn.style.display = 'flex';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                // Optional: Show preview
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Smooth scroll to sections
    function smoothScroll(targetId) {
        const target = document.querySelector(targetId);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Reset form
    function resetForm(formId) {
        document.getElementById(formId).reset();
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe form cards
    document.querySelectorAll('.form-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });

    // Active menu item on scroll
    window.addEventListener('scroll', function() {
        const sections = ['profile-info', 'change-password', 'notification-settings', 'privacy-settings'];
        const menuItems = document.querySelectorAll('.menu-item');
        
        let current = '';
        
        sections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section) {
                const sectionTop = section.offsetTop - 150;
                if (window.scrollY >= sectionTop) {
                    current = '#' + sectionId;
                }
            }
        });
        
        menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('onclick') && item.getAttribute('onclick').includes(current)) {
                item.classList.add('active');
            }
        });
    });
</script>
@endpush