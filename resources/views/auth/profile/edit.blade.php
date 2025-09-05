@extends('admin.master')

@section('title', __('messages.my_account'))

@push('style')
<style>
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideInRight { from { transform: translateX(50px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
    .btn-primary { background-color: #3a86ff; border-color: #3a86ff; }
    .btn-primary:hover { background-color: #2a75e0; border-color: #2a75e0; }

    .dashboard-container { animation: fadeIn 0.8s ease-out; }
    .dashboard-sidebar { background-color: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); position: sticky; top: 100px; }
    .dashboard-content { animation: slideInRight 0.8s ease-out; }
    .dashboard-card { background-color: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px; overflow: hidden; }
    .dashboard-card-header { padding: 1.25rem; border-bottom: 1px solid #e9ecef; background-color: #f8f9fa; }
    .dashboard-card-body { padding: 1.25rem; }

    .user-avatar { width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 5px solid #e9f0ff; transition: opacity 0.3s ease; }
    .avatar-wrapper { position: relative; display: inline-block; cursor: pointer; }
    .avatar-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.4); border-radius:50%; display:flex; align-items:center; justify-content:center; opacity:0; transition: opacity 0.3s ease; }
    .avatar-wrapper:hover .avatar-overlay { opacity:1; }
    .avatar-overlay::before { content: '\f302'; font-family: 'bootstrap-icons'; color:white; font-size:2rem; }

    .form-control:focus { border-color: #3a86ff; box-shadow: 0 0 0 0.25rem rgba(58,134,255,0.25); }
    .save-btn { background-color:#3a86ff; border-color:#3a86ff; transition: all 0.3s ease; }
    .save-btn:hover { background-color:#2a75e0; transform:translateY(-2px); box-shadow: 0 5px 15px rgba(58,134,255,0.2); }

    .alert { margin-bottom:1rem; padding:1rem; border-radius:5px; }
    .alert-success { background-color:#d4edda; color:#155724; }
    .alert-danger { background-color:#f8d7da; color:#721c24; }

    .file-input-hidden { display:none; }
    .avatar-error { color:#721c24; font-size:0.875rem; margin-top:0.25rem; display:none; }
    .avatar-error.active { display:block; }

    .input-group { display:flex; }
    .input-group .form-control { flex:1; }
    .input-group button { border-radius:0 0.25rem 0.25rem 0; }
</style>
@endpush

@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">My Account</h2>
        <p class="text-muted">Manage your personal information and security</p>
    </div>
</div>

<form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">

        <!-- Sidebar / Avatar -->
<div class="col-lg-3 mb-4">
                <div class="dashboard-sidebar p-4 text-center">
                    <div class="avatar-wrapper" tabindex="0" role="button" aria-label="Click to upload new avatar">
                        <img src="{{ optional($user->profile)->image ? asset('storage/' . optional($user->profile)->image) : asset('storage/profiles/noimage.png') }}"
                             alt="Avatar" class="user-avatar mb-3" id="avatar-preview"
                             aria-describedby="avatar-error" style="height: 300px; width: 250px;">
                        <div class="avatar-overlay"></div>
                        <input type="file" name="image" id="image" class="file-input-hidden" accept="image/*" hidden>
                    </div>
                    <div id="avatar-error" class="avatar-error"></div>
                    @error('image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        <!-- Main Content -->
        <div class="col-lg-9 dashboard-content">

            <!-- Personal Info -->
            <div class="dashboard-card">
                <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Personal Information</h4>
                    <span class="badge bg-primary rounded-pill px-3">Primary</span>
                </div>
                <div class="dashboard-card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob', optional($user->profile)->dob) }}">
                        @error('dob') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="dashboard-card mt-4">
                <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Change Password</h4>
                    <span class="badge bg-warning text-dark rounded-pill px-3">Security</span>
                </div>
                <div class="dashboard-card-body">

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="old_password" class="form-control" placeholder="Current Password" autocomplete="current-password">
                            <button type="button" class="btn btn-outline-secondary toggle-password" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('old_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control" placeholder="New Password" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary toggle-password" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('new_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary toggle-password" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary save-btn mt-3 px-4">
                    <i class="bi bi-check2 me-2"></i>Save Changes
                </button>
            </div>

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            if(input.type === 'password'){
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // Avatar Upload & Preview
           // Avatar Click to Upload and Image Preview
        const avatarWrapper = document.querySelector('.avatar-wrapper');
        const avatarPreview = document.getElementById('avatar-preview');
        const fileInput = document.getElementById('image');
        const errorDiv = document.getElementById('avatar-error');
        const defaultAvatar = "{{ optional($user->profile)->image ? asset('storage/' . optional($user->profile)->image) : asset('storage/profiles/noimage.png') }}";
        const maxFileSize = 2 * 1024 * 1024; // 2MB

        avatarWrapper.addEventListener('click', () => fileInput.click());
        avatarWrapper.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            errorDiv.textContent = '';
            errorDiv.classList.remove('active');

            if (!file) {
                avatarPreview.src = defaultAvatar;
                avatarPreview.style.opacity = '1';
                return;
            }

            if (!file.type.startsWith('image/')) {
                errorDiv.textContent = 'Please select an image file (e.g., JPG, PNG).';
                errorDiv.classList.add('active');
                avatarPreview.src = defaultAvatar;
                this.value = '';
                return;
            }

            if (file.size > maxFileSize) {
                errorDiv.textContent = 'Image file is too large. Maximum size is 2MB.';
                errorDiv.classList.add('active');
                avatarPreview.src = defaultAvatar;
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                avatarPreview.src = e.target.result;
                avatarPreview.style.opacity = '1';
            };
            reader.readAsDataURL(file);
        });
</script>
@endpush
