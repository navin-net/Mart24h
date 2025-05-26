@extends('admin.master')

@section('title', __('messages.my_account'))

@section('content')
    @push('style')
        <style>
            /* Custom animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideInRight {
                from {
                    transform: translateX(50px);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideInUp {
                from {
                    transform: translateY(30px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            /* General styles */
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
            }

            .btn-primary {
                background-color: #3a86ff;
                border-color: #3a86ff;
            }

            .btn-primary:hover {
                background-color: #2a75e0;
                border-color: #2a75e0;
            }

            /* Dashboard specific styles */
            .dashboard-container {
                animation: fadeIn 0.8s ease-out;
            }

            .dashboard-sidebar {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                position: sticky;
                top: 100px;
            }

            .dashboard-content {
                animation: slideInRight 0.8s ease-out;
            }

            .dashboard-card {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                margin-bottom: 20px;
                overflow: hidden;
            }

            .dashboard-card-header {
                padding: 1.25rem;
                border-bottom: 1px solid #e9ecef;
                background-color: #f8f9fa;
            }

            .dashboard-card-body {
                padding: 1.25rem;
            }

            .user-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
                border: 5px solid #e9f0ff;
            }

            .form-control:focus {
                border-color: #3a86ff;
                box-shadow: 0 0 0 0.25rem rgba(58, 134, 255, 0.25);
            }

            .save-btn {
                background-color: #3a86ff;
                border-color: #3a86ff;
                transition: all 0.3s ease;
            }

            .save-btn:hover {
                background-color: #2a75e0;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(58, 134, 255, 0.2);
            }
        </style>
    @endpush
    <div class="container py-5 dashboard-container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-0">My Account</h2>
                <p class="text-muted">Manage your personal information and security</p>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar with user info -->
            <div class="col-lg-3 mb-4">
                <div class="dashboard-sidebar p-4">
                    <div class="text-center mb-4">
                        <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80"
                            alt="John Doe" class="user-avatar mb-3">
                        <h5 class="mb-1">John Doe</h5>
                        <p class="text-muted mb-0">john.doe@example.com</p>
                    </div>

                    <hr>

                    <div class="text-center">
                        <a href="#" class="btn btn-outline-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                viewBox="0 0 16 16" class="me-2">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                            </svg>
                            Sign Out
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-lg-9 dashboard-content">
                <!-- Personal Information Card -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Personal Information</h4>
                        <span class="badge bg-primary rounded-pill px-3">Primary</span>
                    </div>
                    <div class="dashboard-card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" value="John">
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" value="Doe">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="john.doe@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" value="(123) 456-7890">
                            </div>
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" id="birthdate" value="1990-01-15">
                            </div>
                            <button type="submit" class="btn btn-primary save-btn px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-check2 me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                </svg>
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Password Change Card -->
                <div class="dashboard-card mt-4">
                    <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Change Password</h4>
                        <span class="badge bg-warning text-dark rounded-pill px-3">Security</span>
                    </div>
                    <div class="dashboard-card-body">
                        <form>
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="currentPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="form-text">Password must be at least 8 characters long and include at least one
                                    uppercase letter, one lowercase letter, one number, and one special character.</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary save-btn px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-shield-lock me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                                    <path
                                        d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z" />
                                </svg>
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Email Preferences Card -->
                <div class="dashboard-card mt-4">
                    <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Communication Preferences</h4>
                        <span class="badge bg-info rounded-pill px-3">Notifications</span>
                    </div>
                    <div class="dashboard-card-body">
                        <form>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailUpdates" checked>
                                    <label class="form-check-label" for="emailUpdates">Account Updates</label>
                                </div>
                                <div class="form-text text-muted">Receive important notifications about your account</div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="promotions" checked>
                                    <label class="form-check-label" for="promotions">Promotions and Offers</label>
                                </div>
                                <div class="form-text text-muted">Receive notifications about sales and special offers
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">Newsletter</label>
                                </div>
                                <div class="form-text text-muted">Receive our weekly newsletter</div>
                            </div>
                            <button type="submit" class="btn btn-primary save-btn px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-bell me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                </svg>
                                Save Preferences
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Toggle password visibility
            document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('currentPassword');
                togglePasswordVisibility(passwordInput, this);
            });

            document.getElementById('toggleNewPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('newPassword');
                togglePasswordVisibility(passwordInput, this);
            });

            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('confirmPassword');
                togglePasswordVisibility(passwordInput, this);
            });

            function togglePasswordVisibility(input, button) {
                if (input.type === 'password') {
                    input.type = 'text';
                    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                </svg>`;
                } else {
                    input.type = 'password';
                    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>`;
                }
            }

            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    // Simple animation to show success
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    Saved!
                `;

                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-success');

                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.classList.remove('btn-success');
                        submitBtn.classList.add('btn-primary');
                    }, 2000);
                });
            });
        </script>
    @endpush

@endsection
