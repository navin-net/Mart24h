<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('picture/pie-chart.ico') }}">
    <title>Stock Management</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="{{ asset('assets1/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Inline Styles -->
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 60px;
            --primary-color: #0ea5e9;
            --transition-speed: 0.3s;
        }
        [data-bs-theme="light"] {
            --bg-color: #ffffff;
            --sidebar-bg: #f8fafc;
            --header-bg: #ffffff;
            --card-bg: #ffffff;
            --border-color: rgba(0, 0, 0, 0.1);
            --text-color: #1e293b;
            --text-muted: #64748b;
            --hover-bg: rgba(0, 0, 0, 0.05);
        }
        [data-bs-theme="dark"] {
            --bg-color: #0f172a;
            --sidebar-bg: #020617;
            --header-bg: #020617;
            --card-bg: #1e293b;
            --border-color: rgba(255, 255, 255, 0.1);
            --text-color: #e2e8f0;
            --text-muted: #94a3b8;
            --hover-bg: rgba(255, 255, 255, 0.05);
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }
        .app-header {
            height: var(--header-height);
            border-bottom: 1px solid var(--border-color);
            background-color: var(--header-bg);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: background-color var(--transition-speed);
        }
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            transition: transform var(--transition-speed) ease, background-color var(--transition-speed);
            z-index: 1020;
            overflow-y: auto;
            transform: translateX(-100%); /* Always closed by default */
        }
        .main-content {
            margin-left: 0; /* Always full width */
            margin-top: var(--header-height);
            transition: margin-left var(--transition-speed) ease;
            flex: 1;
            background-color: var(--bg-color);
            min-height: calc(100vh - var(--header-height));
            padding: 1.5rem;
        }
        .sidebar-visible .sidebar {
            transform: translateX(0);
        }
        .nav-link {
            color: var(--text-color);
            border-radius: 4px;
            margin-bottom: 5px;
            transition: all 0.2s;
            padding: 0.5rem 1rem;
        }
        .nav-link:hover {
            background-color: var(--hover-bg);
            transform: translateX(5px); /* Hover effect - slight movement */
            color: var(--primary-color); /* Hover effect - color change */
        }
        .nav-link.active {
            background-color: rgba(14, 165, 233, 0.2);
            color: #38bdf8;
            font-weight: 500;
        }
        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            transition: transform 0.2s; /* Hover effect for icons */
        }
        .nav-link:hover i {
            transform: scale(1.2); /* Hover effect - icon grows */
        }
        .settings-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            display: none;
            z-index: 1030;
            width: 40px;
            height: 40px;
            background-color: #0ea5e9;
            color: white;
            border: none;
            transition: transform 0.2s, background-color 0.2s;
        }
        .back-to-top:hover {
            transform: translateY(-3px);
            background-color: #0284c7;
        }
        .back-to-top.show {
            display: flex;
        }
        .card {
            border-radius: 8px;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color var(--transition-speed), border-color var(--transition-speed), transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px); /* Hover effect - card rises */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            transition: border-color var(--transition-speed);
        }
        .theme-toggle {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s, transform 0.2s;
            color: var(--text-color);
        }
        .theme-toggle:hover {
            background-color: var(--hover-bg);
            transform: rotate(15deg); /* Hover effect - slight rotation */
        }
        .btn-outline-custom {
            border: 1px solid var(--border-color);
            color: var(--text-color);
            background-color: transparent;
            transition: background-color 0.2s, color 0.2s, border-color 0.2s, transform 0.2s;
        }
        .btn-outline-custom:hover {
            background-color: var(--hover-bg);
            transform: translateY(-2px); /* Hover effect - button rises */
        }
        .section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }
        .dropdown-menu {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
        }
        .dropdown-item {
            color: var(--text-color);
            transition: color var(--transition-speed), background-color var(--transition-speed), transform 0.2s;
        }
        .dropdown-item:hover {
            background-color: var(--hover-bg);
            transform: translateX(5px); /* Hover effect - slight movement */
        }
        .search-bar {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            transition: background-color var(--transition-speed), box-shadow 0.2s;
        }
        .search-bar:hover {
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.3);
        }
        [data-bs-theme="light"] .search-bar {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: transform 0.2s;
        }
        .card:hover .stat-card-icon {
            transform: scale(1.1) rotate(10deg); /* Hover effect - icon grows and rotates */
        }
        .sidebar-user {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
            display: none;
        }
        /* Overlay for sidebar on mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1015;
            display: none;
        }
        .sidebar-visible .sidebar-overlay {
            display: block;
        }
        /* DataTables customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-color) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-color) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--primary-color) !important;
        }
        table.dataTable tbody tr {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }
        table.dataTable.stripe tbody tr.odd {
            background-color: rgba(0, 0, 0, 0.05) !important;
        }
        [data-bs-theme="dark"] table.dataTable.stripe tbody tr.odd {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
        @media (max-width: 992px) {
            .main-content {
                padding: 1rem;
            }
            .sidebar-user {
                display: flex;
                flex-direction: column;
            }
            .desktop-only {
                display: none !important;
            }
            .card {
                margin-bottom: 1rem;
            }
            .card-body {
                padding: 1rem;
            }
            h1.display-6 {
                font-size: 1.75rem;
            }
            .app-header {
                height: 56px;
            }
            .main-content {
                margin-top: 56px;
            }
            .sidebar {
                top: 56px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Header -->
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
                <div class="d-none d-md-flex align-items-center me-3 px-3 py-1 rounded search-bar desktop-only">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent" placeholder="Search...">
                    <span class="text-muted small ms-2">Ctrl K</span>
                </div>
                <div class="theme-toggle me-3" id="themeToggle" role="button" aria-label="Toggle theme">
                    <i class="bi bi-sun-fill fs-5"></i>
                </div>
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

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle me-2" width="40" height="40">
                <div>
                    <h6 class="mb-0">admin</h6>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
            <div class="dropdown mb-3 w-100">
                <button class="btn btn-outline-custom dropdown-toggle d-flex align-items-center justify-content-between w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div>
                        <i class="bi bi-translate me-2"></i>
                        <span>{{ app()->getLocale() == 'en' ? 'English' : 'Khmer' }}</span>
                    </div>
                </button>
                <ul class="dropdown-menu w-100">
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', ['language' => 'en']) }}">
                        <i class="bi bi-flag me-2"></i>{{ __('messages.english') }}
                    </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() == 'km' ? 'active' : '' }}" href="{{ route('language.switch', ['language' => 'km']) }}">
                            <i class="bi bi-flag me-2"></i>{{ __('messages.khmer') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control bg-transparent border-start-0" placeholder="Search...">
            </div>
        </div>
        <div class="p-3">
            <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>{{ __('messages.dashboard') }}</span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center {{ request()->is('products') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>{{ __('messages.products') }}</span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center {{ request()->is('sales') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>{{ __('messages.sales') }}</span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center {{ request()->is('purchase') ? 'active' : '' }}">
                <i class="bi bi-cart4"></i>
                <span>{{ __('messages.purchases') }}</span>
            </a>
            <div class="settings-heading">{{ __('messages.settings') }}</div>
            <div class="mb-2">
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->is('settings*') ? 'active' : '' }}"
                   data-bs-toggle="collapse"
                   href="#settings-nav"
                   aria-expanded="{{ request()->is('settings*') ? 'true' : 'false' }}"
                   aria-controls="settings-nav">
                    <div>
                        <i class="bi bi-gear"></i>
                        <span>{{ __('messages.settings_list') }}</span>
                    </div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div id="settings-nav" class="collapse {{ request()->is('settings*') ? 'show' : '' }} ps-4 mt-1">
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('brands') ? 'active' : '' }}">
                        <i class="bi bi-circle-fill fs-6"></i>
                        <span>{{ __('messages.brands') }}</span>
                    </a>
                    <a href="#" class="nav-link d-flex align-items-center {{ request()->is('categories') ? 'active' : '' }}">
                        <i class="bi bi-circle-fill fs-6"></i>
                        <span>{{ __('messages.categories') }}</span>
                    </a>
                </div>
            </div>
            <div class="settings-heading">{{ __('messages.getting_started') }}</div>
            <a href="#" class="nav-link d-flex align-items-center">
                <i class="bi bi-file-earmark-text"></i>
                <span>{{ __('messages.documentation') }}</span>
            </a>
            <a href="#" class="nav-link d-flex align-items-center">
                <i class="bi bi-question-circle"></i>
                <span>{{ __('messages.help_support') }}</span>
            </a>
            <div class="d-block d-lg-none mt-3">
                <div class="settings-heading">{{ __('messages.account') }}</div>
                <a href="{{ url('users-profile.html') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-person"></i>
                    <span>{{ __('messages.profile') }}</span>
                </a>
                <a href="{{ url('users-profile.html') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-gear"></i>
                    <span>{{ __('messages.account_settings') }}</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ __('messages.logout') }}</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid p-0">
            <div class="mb-4">
                <div class="section-title">{{ __('messages.dashboard') }}</div>
                <h1 class="display-6 fw-bold mb-3">{{ __('messages.stock_management_system') }}</h1>
                <p class="text-muted mb-4">{{ __('messages.dashboard_welcome') }}</p>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">{{ __('messages.total_sales') }}</h5>
                                <div class="stat-card-icon" style="background-color: rgba(14, 165, 233, 0.2);">
                                    <i class="bi bi-graph-up" style="color: #0ea5e9;"></i>
                                </div>
                            </div>
                            <h3 class="mb-1">$24,500</h3>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i>
                                <span>12% increase</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">{{ __('messages.products') }}</h5>
                                <div class="stat-card-icon" style="background-color: rgba(34, 197, 94, 0.2);">
                                    <i class="bi bi-box-seam" style="color: #22c55e;"></i>
                                </div>
                            </div>
                            <h3 class="mb-1">1,240</h3>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i>
                                <span>8% increase</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">{{ __('messages.customers') }}</h5>
                                <div class="stat-card-icon" style="background-color: rgba(168, 85, 247, 0.2);">
                                    <i class="bi bi-people" style="color: #a855f7;"></i>
                                </div>
                            </div>
                            <h3 class="mb-1">540</h3>
                            <div class="text-success small">
                                <i class="bi bi-arrow-up"></i>
                                <span>12% increase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">{{ __('messages.sales_report') }}</h5>
                                <small class="text-muted">{{ __('messages.example_data') }}</small>
                            </div>
                            <button class="btn btn-sm btn-outline-custom">
                                <i class="bi bi-three-dots"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.recent_activity') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-muted small">2 mins ago</div>
                                        <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                                        <div class="ms-3">New sale: $250.00</div>
                                    </div>
                                </div>
                                <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-muted small">1 hour ago</div>
                                        <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                        <div class="ms-3">Product "Laptop" updated</div>
                                    </div>
                                </div>
                                <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-muted small">4 hours ago</div>
                                        <div class="rounded-circle bg-warning" style="width: 8px; height: 8px;"></div>
                                        <div class="ms-3">Low stock alert: "Mouse"</div>
                                    </div>
                                </div>
                                <div class="list-group-item bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-muted small">1 day ago</div>
                                        <div class="rounded-circle bg-primary" style="width: 8px; height: 8px;"></div>
                                        <div class  style="width: 8px; height: 8px;"></div>
                                        <div class="ms-3">New customer registered</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Example DataTable -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('messages.products_list') }}</h5>
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg me-1"></i> Add New
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="productsTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>001</td>
                                        <td>Laptop Pro</td>
                                        <td>Electronics</td>
                                        <td>$1,200</td>
                                        <td>25</td>
                                        <td><span class="badge bg-success">In Stock</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>002</td>
                                        <td>Wireless Mouse</td>
                                        <td>Accessories</td>
                                        <td>$45</td>
                                        <td>12</td>
                                        <td><span class="badge bg-warning text-dark">Low Stock</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>003</td>
                                        <td>Bluetooth Speaker</td>
                                        <td>Audio</td>
                                        <td>$85</td>
                                        <td>30</td>
                                        <td><span class="badge bg-success">In Stock</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Back to Top -->
    <a href="#" class="back-to-top rounded-circle shadow d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Bootstrap 5.3 JS -->
    <script src="{{ asset('assets1/bootstrap.bundle.min.js') }}"></script>
    <!-- Chart.js for Sales Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;
            const sidebar = document.querySelector('.sidebar');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');

            function setTheme(theme) {
                html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                themeToggle.innerHTML = theme === 'dark' ? '<i class="bi bi-sun-fill fs-5"></i>' : '<i class="bi bi-moon-stars-fill fs-5"></i>';
            }

            const savedTheme = localStorage.getItem('theme');
            setTheme(savedTheme || 'dark');

            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-bs-theme');
                setTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });

            // Toggle sidebar visibility
            function toggleSidebar() {
                body.classList.toggle('sidebar-visible');
            }

            sidebarToggle.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking outside
            sidebarOverlay.addEventListener('click', () => {
                body.classList.remove('sidebar-visible');
            });

            // Close sidebar when clicking on a link (mobile)
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        body.classList.remove('sidebar-visible');
                    }
                });
            });

            // Hover effect to show sidebar
            document.addEventListener('mousemove', (e) => {
                if (e.clientX < 10 && !body.classList.contains('sidebar-visible')) {
                    body.classList.add('sidebar-visible');
                } else if (e.clientX > 300 && body.classList.contains('sidebar-visible') && !sidebar.contains(e.target)) {
                    body.classList.remove('sidebar-visible');
                }
            });

            const backToTopButton = document.querySelector('.back-to-top');
            window.addEventListener('scroll', () => {
                backToTopButton.classList.toggle('show', window.scrollY > 300);
            });

            backToTopButton.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Initialize DataTable
            if ($.fn.DataTable) {
                $('#productsTable').DataTable({
                    responsive: true,
                    language: {
                        search: "",
                        searchPlaceholder: "Search...",
                    },
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 5
                });
            }

            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Sales',
                        data: [1200, 1900, 1500, 2200, 1800, 2500, 2000],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
