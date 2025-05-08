<header class="app-header shadow-sm">
    <div class="container-fluid d-flex align-items-center justify-content-between h-100 px-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <span class="fw-bold fs-4" style="color: #0ea5e9;">StockMangment</span>
            </a>
            <button id="sidebarToggle" class="btn btn-link p-0 text-body" type="button" aria-label="Toggle sidebar">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <!-- Search - Desktop Only -->
            <div class="d-none d-md-flex align-items-center me-3 px-3 py-1 rounded search-bar desktop-only">
                <i class="bi bi-search text-muted me-2"></i>
                <input type="text" class="form-control form-control-sm border-0 bg-transparent" placeholder="Search...">
                <span class="text-muted small ms-2">Ctrl K</span>
            </div>

            <!-- Theme Toggle -->
            <div class="theme-toggle me-3" id="themeToggle" role="button" aria-label="Toggle theme">
                <i class="bi bi-sun-fill fs-5"></i>
            </div>

            <!-- Language Dropdown - Desktop Only -->
            <div class="dropdown me-3 desktop-only">
                <button class="btn btn-outline-custom dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-translate me-2"></i>
                    <span class="d-none d-md-block ps-2">
                        {{ app()->getLocale() == 'en' ? __('messages.english') : __('messages.khmer') }}
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                           href="{{ route('language.switch', ['language' => 'en']) }}">
                            <i class="bi bi-flag"></i>
                            <span>{{ __('messages.english') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'km' ? 'active' : '' }}"
                           href="{{ route('language.switch', ['language' => 'km']) }}">
                            <i class="bi bi-flag"></i>
                            <span>{{ __('messages.khmer') }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Dropdown - Desktop Only -->
            <div class="dropdown desktop-only">
                <button class="btn btn-outline-custom dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle me-2" width="32" height="32">
                    <span>admin</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="{{ url('users-profile.html') }}">
                            <i class="bi bi-person me-2"></i>{{ __('messages.profile') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('users-profile.html') }}">
                            <i class="bi bi-gear me-2"></i>{{ __('messages.account_settings') }}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
