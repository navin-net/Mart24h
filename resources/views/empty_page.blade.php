<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --transition-speed: 0.3s;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        [data-bs-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --hover-bg: #f1f5f9;
            --card-bg: #ffffff;
            --submenu-bg: #f8fafc;
            --table-hover: #f8fafc;
        }

        [data-bs-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --hover-bg: #334155;
            --card-bg: #1e293b;
            --submenu-bg: #0f172a;
            --table-hover: #334155;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1019;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            backdrop-filter: blur(4px);
        }

        .mobile-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1020;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-primary);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            box-shadow: var(--shadow-light);
        }

        .logo-text {
            opacity: 1;
            transition: opacity var(--transition-speed) ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
        }

        /* Collapse Button */
        .collapse-btn {
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 1021;
            box-shadow: var(--shadow-light);
        }

        .collapse-btn:hover {
            background: var(--hover-bg);
            transform: translateY(-50%) scale(1.1);
            box-shadow: var(--shadow-medium);
        }

        .collapse-btn i {
            font-size: 0.875rem;
            color: var(--text-primary);
            transition: transform var(--transition-speed) ease;
        }

        .sidebar.collapsed .collapse-btn i {
            transform: rotate(180deg);
        }

        /* Navigation */
        .sidebar-content {
            padding: 1.5rem 0;
            height: calc(100vh - var(--header-height));
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-title {
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            opacity: 1;
            transition: opacity var(--transition-speed) ease;
        }

        .sidebar.collapsed .nav-title {
            opacity: 0;
        }

        .nav-item {
            margin: 0 1rem 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
            transform: translateX(4px);
            box-shadow: var(--shadow-light);
        }

        .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-medium);
        }

        .nav-link.active:hover {
            transform: translateX(4px) scale(1.02);
        }

        .nav-link.has-submenu {
            justify-content: space-between;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nav-text {
            opacity: 1;
            transition: opacity var(--transition-speed) ease;
            white-space: nowrap;
            flex: 1;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
        }

        .nav-arrow {
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform var(--transition-speed) ease;
            opacity: 1;
        }

        .sidebar.collapsed .nav-arrow {
            opacity: 0;
        }

        .nav-link.expanded .nav-arrow {
            transform: rotate(90deg);
        }

        /* Sub Menu Styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height var(--transition-speed) ease;
            background: var(--submenu-bg);
            margin: 0.5rem 1rem 0;
            border-radius: 8px;
            border-left: 2px solid var(--border-color);
        }

        .submenu.expanded {
            max-height: 300px;
        }

        .submenu-item {
            margin: 0;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem 0.75rem 2rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 400;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .submenu-link::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--text-muted);
            opacity: 0.5;
            transition: all 0.2s ease;
        }

        .submenu-link:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
            transform: translateX(4px);
        }

        .submenu-link:hover::before {
            background: var(--text-primary);
            opacity: 1;
            transform: translateY(-50%) scale(1.2);
        }

        .submenu-link.active {
            background: var(--primary-gradient);
            color: white;
        }

        .submenu-link.active::before {
            background: white;
            opacity: 1;
        }

        .sidebar.collapsed .submenu {
            display: none;
        }

        /* Header */
        .app-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            z-index: 1030;
            transition: left var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-light);
        }

        .app-header.collapsed {
            left: var(--sidebar-collapsed-width);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            padding: 0 2rem;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Theme Toggle */
        .theme-toggle {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.125rem;
        }

        .theme-toggle:hover {
            background: var(--hover-bg);
            transform: rotate(15deg) scale(1.05);
            box-shadow: var(--shadow-medium);
        }

        .mobile-toggle {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.125rem;
        }

        .mobile-toggle:hover {
            background: var(--hover-bg);
            box-shadow: var(--shadow-medium);
        }

        .mobile-toggle.active {
            background: var(--primary-gradient);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--bg-primary);
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Page Content */
        .page-content {
            display: none;
        }

        .page-content.active {
            display: block;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover::before {
            transform: scaleX(1);
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-large);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .card-icon.primary { background: var(--primary-gradient); }
        .card-icon.success { background: var(--success-gradient); }
        .card-icon.warning { background: var(--warning-gradient); }
        .card-icon.info { background: var(--info-gradient); }

        .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .card-change {
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card-change.positive { color: #10b981; }
        .card-change.negative { color: #ef4444; }

        /* Data Table Styles */
        .data-table-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-secondary);
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }

        .table-controls {
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action:hover {
            background: var(--hover-bg);
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: var(--shadow-medium);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .data-table th {
            background: var(--bg-secondary);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .data-table th:hover {
            background: var(--hover-bg);
        }

        .data-table th.sortable::after {
            content: '\F282';
            font-family: 'bootstrap-icons';
            position: absolute;
            right: 1rem;
            opacity: 0.5;
            transition: all 0.2s ease;
        }

        .data-table th.sort-asc::after {
            content: '\F282';
            opacity: 1;
            color: #667eea;
        }

        .data-table th.sort-desc::after {
            content: '\F286';
            opacity: 1;
            color: #667eea;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .data-table tr:hover {
            background: var(--table-hover);
        }

        .data-table tr:hover td {
            color: var(--text-primary);
        }

        .product-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .table-pagination {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--bg-primary);
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .pagination-btn:hover:not(:disabled) {
            background: var(--hover-bg);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform var(--transition-speed) ease;
                width: 300px;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .app-header {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: flex !important;
            }

            .collapse-btn {
                display: none;
            }
            
            .header-content {
                padding: 0 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }

            .dashboard-card {
                padding: 1rem;
            }

            .card-value {
                font-size: 1.5rem;
            }

            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: auto;
            }

            .table-actions {
                justify-content: center;
            }

            .data-table {
                font-size: 0.75rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }

            .table-pagination {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none !important;
            }
        }

        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .dashboard-card {
            animation: slideInRight 0.6s ease forwards;
        }

        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }

        /* Custom Scrollbar */
        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loaded {
            opacity: 1;
        }
    </style>
</head>
<body class="loading">
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="bi bi-layers"></i>
                </div>
                <span class="logo-text">Dashboard</span>
            </a>
        </div>
        
        <div class="collapse-btn" id="collapseBtn">
            <i class="bi bi-chevron-left"></i>
        </div>

        <div class="sidebar-content">
            <nav>
                <div class="nav-section">
                    <div class="nav-title">Main</div>
                    <div class="nav-item">
                        <a href="#" class="nav-link active" data-page="dashboard">
                            <div class="nav-icon">
                                <i class="bi bi-house-door"></i>
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </div>
                    
                    <!-- Analytics with Sub Menu -->
                    <div class="nav-item">
                        <div class="nav-link has-submenu" data-submenu="analytics">
                            <div class="nav-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <span class="nav-text">Analytics</span>
                            <div class="nav-arrow">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <div class="submenu" id="submenu-analytics">
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="analytics-overview">Overview</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="analytics-reports">Reports</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="analytics-realtime">Real-time</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="analytics-goals">Goals</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Users with Sub Menu -->
                    <div class="nav-item">
                        <div class="nav-link has-submenu" data-submenu="users">
                            <div class="nav-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <span class="nav-text">Users</span>
                            <div class="nav-arrow">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <div class="submenu" id="submenu-users">
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="users-all">All Users</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="users-active">Active Users</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="users-roles">User Roles</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="users-permissions">Permissions</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nav-item">
                        <a href="#" class="nav-link" data-page="products">
                            <div class="nav-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <span class="nav-text">Products</span>
                        </a>
                    </div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Management</div>
                    
                    <!-- Orders with Sub Menu -->
                    <div class="nav-item">
                        <div class="nav-link has-submenu" data-submenu="orders">
                            <div class="nav-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <span class="nav-text">Orders</span>
                            <div class="nav-arrow">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <div class="submenu" id="submenu-orders">
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="orders-all">All Orders</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="orders-pending">Pending</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="orders-completed">Completed</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="orders-cancelled">Cancelled</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Settings with Sub Menu -->
                    <div class="nav-item">
                        <div class="nav-link has-submenu" data-submenu="settings">
                            <div class="nav-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <span class="nav-text">Settings</span>
                            <div class="nav-arrow">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <div class="submenu" id="submenu-settings">
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="settings-general">General</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="settings-security">Security</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="settings-notifications">Notifications</a>
                            </div>
                            <div class="submenu-item">
                                <a href="#" class="submenu-link" data-page="settings-integrations">Integrations</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nav-item">
                        <a href="#" class="nav-link" data-page="reports">
                            <div class="nav-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <span class="nav-text">Reports</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Header -->
    <header class="app-header" id="header">
        <div class="header-content">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle d-none" id="mobileToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="header-title" id="pageTitle">Welcome Back!</h1>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="theme-toggle" id="themeToggle">
                    <i class="bi bi-sun-fill"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Dashboard Page -->
        <div class="page-content active" id="page-dashboard">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card">
                            <div class="card-icon primary">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="card-title">Total Sales</div>
                            <h3 class="card-value">$24,500</h3>
                            <div class="card-change positive">
                                <i class="bi bi-arrow-up"></i>
                                <span>+12.5% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card">
                            <div class="card-icon success">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="card-title">Products</div>
                            <h3 class="card-value">1,240</h3>
                            <div class="card-change positive">
                                <i class="bi bi-arrow-up"></i>
                                <span>+8.2% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card">
                            <div class="card-icon info">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="card-title">Users</div>
                            <h3 class="card-value">540</h3>
                            <div class="card-change negative">
                                <i class="bi bi-arrow-down"></i>
                                <span>-2.1% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="dashboard-card">
                            <div class="card-icon warning">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="card-title">Orders</div>
                            <h3 class="card-value">89</h3>
                            <div class="card-change positive">
                                <i class="bi bi-arrow-up"></i>
                                <span>+15.3% from last month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Content Row -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-8">
                        <div class="dashboard-card">
                            <div class="card-title">Recent Activity</div>
                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-plus text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">New user registered</div>
                                            <small class="text-muted">John Doe joined the platform</small>
                                        </div>
                                    </div>
                                    <small class="text-muted">2 min ago</small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-cart-check text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Order completed</div>
                                            <small class="text-muted">Order #1234 has been delivered</small>
                                        </div>
                                    </div>
                                    <small class="text-muted">5 min ago</small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-exclamation-triangle text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">System alert</div>
                                            <small class="text-muted">Server maintenance scheduled</small>
                                        </div>
                                    </div>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="dashboard-card">
                            <div class="card-title">Quick Stats</div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Conversion Rate</span>
                                    <span class="fw-bold">3.2%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 32%"></div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Customer Satisfaction</span>
                                    <span class="fw-bold">94%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 94%"></div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Server Uptime</span>
                                    <span class="fw-bold">99.9%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 99.9%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Page -->
        <div class="page-content" id="page-products">
            <div class="data-table-container">
                <div class="table-header">
                    <h2 class="table-title">Products Management</h2>
                    <div class="table-controls">
                        <div class="search-box">
                            <input type="text" class="search-input" id="productSearch" placeholder="Search products...">
                        </div>
                        <div class="table-actions">
                            <button class="btn-action">
                                <i class="bi bi-funnel"></i>
                                Filter
                            </button>
                            <button class="btn-action">
                                <i class="bi bi-download"></i>
                                Export
                            </button>
                            <button class="btn-action btn-primary">
                                <i class="bi bi-plus-lg"></i>
                                Add Product
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table" id="productsTable">
                        <thead>
                            <tr>
                                <th class="sortable" data-column="image">Image</th>
                                <th class="sortable" data-column="name">Product Name</th>
                                <th class="sortable" data-column="category">Category</th>
                                <th class="sortable" data-column="price">Price</th>
                                <th class="sortable" data-column="stock">Stock</th>
                                <th class="sortable" data-column="status">Status</th>
                                <th class="sortable" data-column="created">Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                            <!-- Table rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="table-pagination">
                    <div class="pagination-info">
                        Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalRecords">50</span> entries
                    </div>
                    <div class="pagination-controls">
                        <button class="pagination-btn" id="prevBtn" disabled>
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div id="paginationNumbers"></div>
                        <button class="pagination-btn" id="nextBtn">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample products data
        const productsData = [
            { id: 1, name: 'iPhone 15 Pro', category: 'Electronics', price: 999.99, stock: 45, status: 'active', created: '2024-01-15', image: '/placeholder.svg?height=40&width=40' },
            { id: 2, name: 'Samsung Galaxy S24', category: 'Electronics', price: 899.99, stock: 32, status: 'active', created: '2024-01-14', image: '/placeholder.svg?height=40&width=40' },
            { id: 3, name: 'MacBook Pro M3', category: 'Computers', price: 1999.99, stock: 12, status: 'active', created: '2024-01-13', image: '/placeholder.svg?height=40&width=40' },
            { id: 4, name: 'Dell XPS 13', category: 'Computers', price: 1299.99, stock: 8, status: 'active', created: '2024-01-12', image: '/placeholder.svg?height=40&width=40' },
            { id: 5, name: 'AirPods Pro', category: 'Accessories', price: 249.99, stock: 67, status: 'active', created: '2024-01-11', image: '/placeholder.svg?height=40&width=40' },
            { id: 6, name: 'Sony WH-1000XM5', category: 'Accessories', price: 399.99, stock: 23, status: 'active', created: '2024-01-10', image: '/placeholder.svg?height=40&width=40' },
            { id: 7, name: 'iPad Air', category: 'Tablets', price: 599.99, stock: 0, status: 'inactive', created: '2024-01-09', image: '/placeholder.svg?height=40&width=40' },
            { id: 8, name: 'Surface Pro 9', category: 'Tablets', price: 1099.99, stock: 15, status: 'active', created: '2024-01-08', image: '/placeholder.svg?height=40&width=40' },
            { id: 9, name: 'Apple Watch Series 9', category: 'Wearables', price: 399.99, stock: 28, status: 'active', created: '2024-01-07', image: '/placeholder.svg?height=40&width=40' },
            { id: 10, name: 'Fitbit Charge 6', category: 'Wearables', price: 159.99, stock: 41, status: 'active', created: '2024-01-06', image: '/placeholder.svg?height=40&width=40' },
            { id: 11, name: 'Nintendo Switch OLED', category: 'Gaming', price: 349.99, stock: 19, status: 'pending', created: '2024-01-05', image: '/placeholder.svg?height=40&width=40' },
            { id: 12, name: 'PlayStation 5', category: 'Gaming', price: 499.99, stock: 6, status: 'active', created: '2024-01-04', image: '/placeholder.svg?height=40&width=40' },
            { id: 13, name: 'Xbox Series X', category: 'Gaming', price: 499.99, stock: 11, status: 'active', created: '2024-01-03', image: '/placeholder.svg?height=40&width=40' },
            { id: 14, name: 'Canon EOS R5', category: 'Cameras', price: 3899.99, stock: 3, status: 'active', created: '2024-01-02', image: '/placeholder.svg?height=40&width=40' },
            { id: 15, name: 'Sony A7 IV', category: 'Cameras', price: 2499.99, stock: 7, status: 'active', created: '2024-01-01', image: '/placeholder.svg?height=40&width=40' }
        ];

        let currentPage = 1;
        let itemsPerPage = 10;
        let filteredData = [...productsData];
        let sortColumn = '';
        let sortDirection = 'asc';

        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const sidebar = document.getElementById('sidebar');
            const header = document.getElementById('header');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            const themeToggle = document.getElementById('themeToggle');
            const mobileToggle = document.getElementById('mobileToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const html = document.documentElement;
            const navLinks = document.querySelectorAll('.nav-link:not(.has-submenu)');
            const submenuLinks = document.querySelectorAll('.submenu-link');
            const submenuToggles = document.querySelectorAll('.nav-link.has-submenu');
            const body = document.body;
            const pageTitle = document.getElementById('pageTitle');

            // Initialize products table
            renderProductsTable();
            setupTableEventListeners();

            // Theme Management
            function setTheme(theme) {
                html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                const icon = themeToggle.querySelector('i');
                icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            }

            // Initialize theme
            const savedTheme = localStorage.getItem('theme') || 'dark';
            setTheme(savedTheme);

            // Theme toggle event
            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-bs-theme');
                setTheme(currentTheme === 'dark' ? 'light' : 'dark');
            });

            // Page switching function
            function showPage(pageId) {
                // Hide all pages
                document.querySelectorAll('.page-content').forEach(page => {
                    page.classList.remove('active');
                });
                
                // Show selected page
                const targetPage = document.getElementById(`page-${pageId}`);
                if (targetPage) {
                    targetPage.classList.add('active');
                }

                // Update page title
                const pageTitles = {
                    'dashboard': 'Welcome Back!',
                    'products': 'Products Management',
                    'analytics-overview': 'Analytics Overview',
                    'analytics-reports': 'Analytics Reports',
                    'analytics-realtime': 'Real-time Analytics',
                    'analytics-goals': 'Analytics Goals',
                    'users-all': 'All Users',
                    'users-active': 'Active Users',
                    'users-roles': 'User Roles',
                    'users-permissions': 'User Permissions',
                    'orders-all': 'All Orders',
                    'orders-pending': 'Pending Orders',
                    'orders-completed': 'Completed Orders',
                    'orders-cancelled': 'Cancelled Orders',
                    'settings-general': 'General Settings',
                    'settings-security': 'Security Settings',
                    'settings-notifications': 'Notification Settings',
                    'settings-integrations': 'Integration Settings',
                    'reports': 'Reports'
                };

                pageTitle.textContent = pageTitles[pageId] || 'Dashboard';
            }

            // Sidebar collapse (Desktop)
            if (collapseBtn) {
                collapseBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    header.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                    
                    // Close all submenus when collapsing
                    if (sidebar.classList.contains('collapsed')) {
                        document.querySelectorAll('.submenu').forEach(submenu => {
                            submenu.classList.remove('expanded');
                        });
                        document.querySelectorAll('.nav-link.has-submenu').forEach(toggle => {
                            toggle.classList.remove('expanded');
                        });
                    }
                    
                    // Save collapse state
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                });
            }

            // Restore sidebar state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
                header.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            }

            // Sub Menu Toggle Functionality
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Don't toggle if sidebar is collapsed
                    if (sidebar.classList.contains('collapsed')) {
                        return;
                    }
                    
                    const submenuId = toggle.getAttribute('data-submenu');
                    const submenu = document.getElementById(`submenu-${submenuId}`);
                    
                    // Close other submenus
                    submenuToggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            const otherSubmenuId = otherToggle.getAttribute('data-submenu');
                            const otherSubmenu = document.getElementById(`submenu-${otherSubmenuId}`);
                            otherSubmenu.classList.remove('expanded');
                            otherToggle.classList.remove('expanded');
                        }
                    });
                    
                    // Toggle current submenu
                    submenu.classList.toggle('expanded');
                    toggle.classList.toggle('expanded');
                });
            });

            // Mobile toggle
            mobileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('show');
                mobileOverlay.classList.toggle('show');
                mobileToggle.classList.toggle('active');
            });

            // Close sidebar when clicking overlay
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                mobileOverlay.classList.remove('show');
                mobileToggle.classList.remove('active');
            });

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        mobileOverlay.classList.remove('show');
                        mobileToggle.classList.remove('active');
                    }
                }
            });

            // Prevent sidebar clicks from closing it
            sidebar.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            // Navigation links (main nav)
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Remove active class from all main nav links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Remove active class from all submenu links
                    submenuLinks.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked link
                    link.classList.add('active');
                    
                    // Close mobile sidebar
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        mobileOverlay.classList.remove('show');
                        mobileToggle.classList.remove('active');
                    }
                    
                    // Page switching logic
                    const page = link.getAttribute('data-page');
                    showPage(page);
                    console.log('Navigating to:', page);
                });
            });

            // Submenu links
            submenuLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Remove active class from all nav links
                    navLinks.forEach(l => l.classList.remove('active'));
                    submenuLinks.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked submenu link
                    link.classList.add('active');
                    
                    // Close mobile sidebar
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        mobileOverlay.classList.remove('show');
                        mobileToggle.classList.remove('active');
                    }
                    
                    // Page switching logic
                    const page = link.getAttribute('data-page');
                    showPage(page);
                    console.log('Navigating to:', page);
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Ctrl/Cmd + B to toggle sidebar
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    if (window.innerWidth > 768) {
                        collapseBtn?.click();
                    } else {
                        mobileToggle.click();
                    }
                }
                
                // Ctrl/Cmd + D to toggle theme
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    themeToggle.click();
                }

                // Escape to close mobile sidebar
                if (e.key === 'Escape' && window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                    mobileToggle.classList.remove('active');
                }
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                    mobileToggle.classList.remove('active');
                } else {
                    // Close all submenus on mobile
                    document.querySelectorAll('.submenu').forEach(submenu => {
                        submenu.classList.remove('expanded');
                    });
                    document.querySelectorAll('.nav-link.has-submenu').forEach(toggle => {
                        toggle.classList.remove('expanded');
                    });
                }
            });

            // Loading animation
            window.addEventListener('load', () => {
                setTimeout(() => {
                    body.classList.remove('loading');
                    body.classList.add('loaded');
                }, 100);
            });

            // Add some interactive feedback
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Products Table Functions
        function renderProductsTable() {
            const tbody = document.getElementById('productsTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredData.slice(startIndex, endIndex);

            tbody.innerHTML = pageData.map(product => `
                <tr>
                    <td>
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                    </td>
                    <td>
                        <div class="fw-semibold">${product.name}</div>
                        <small class="text-muted">ID: ${product.id}</small>
                    </td>
                    <td>${product.category}</td>
                    <td>$${product.price.toFixed(2)}</td>
                    <td>
                        <span class="${product.stock <= 10 ? 'text-warning' : 'text-success'} fw-semibold">
                            ${product.stock}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-${product.status}">
                            ${product.status}
                        </span>
                    </td>
                    <td>${new Date(product.created).toLocaleDateString()}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

            updatePaginationInfo();
            renderPaginationControls();
        }

        function setupTableEventListeners() {
            // Search functionality
            const searchInput = document.getElementById('productSearch');
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                filteredData = productsData.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) ||
                    product.category.toLowerCase().includes(searchTerm) ||
                    product.status.toLowerCase().includes(searchTerm)
                );
                currentPage = 1;
                renderProductsTable();
            });

            // Sorting functionality
            const sortableHeaders = document.querySelectorAll('.sortable');
            sortableHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const column = header.getAttribute('data-column');
                    
                    if (sortColumn === column) {
                        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortColumn = column;
                        sortDirection = 'asc';
                    }

                    // Update header classes
                    sortableHeaders.forEach(h => {
                        h.classList.remove('sort-asc', 'sort-desc');
                    });
                    header.classList.add(sortDirection === 'asc' ? 'sort-asc' : 'sort-desc');

                    // Sort data
                    filteredData.sort((a, b) => {
                        let aVal = a[column];
                        let bVal = b[column];

                        if (column === 'price') {
                            aVal = parseFloat(aVal);
                            bVal = parseFloat(bVal);
                        } else if (column === 'stock') {
                            aVal = parseInt(aVal);
                            bVal = parseInt(bVal);
                        } else if (column === 'created') {
                            aVal = new Date(aVal);
                            bVal = new Date(bVal);
                        } else {
                            aVal = aVal.toString().toLowerCase();
                            bVal = bVal.toString().toLowerCase();
                        }

                        if (aVal < bVal) return sortDirection === 'asc' ? -1 : 1;
                        if (aVal > bVal) return sortDirection === 'asc' ? 1 : -1;
                        return 0;
                    });

                    currentPage = 1;
                    renderProductsTable();
                });
            });

            // Pagination controls
            document.getElementById('prevBtn').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderProductsTable();
                }
            });

            document.getElementById('nextBtn').addEventListener('click', () => {
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderProductsTable();
                }
            });
        }

        function updatePaginationInfo() {
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, filteredData.length);
            
            document.getElementById('showingStart').textContent = startIndex;
            document.getElementById('showingEnd').textContent = endIndex;
            document.getElementById('totalRecords').textContent = filteredData.length;
        }

        function renderPaginationControls() {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const paginationNumbers = document.getElementById('paginationNumbers');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            // Update prev/next buttons
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            // Generate page numbers
            let paginationHTML = '';
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button class="pagination-btn ${i === currentPage ? 'active' : ''}" 
                            onclick="goToPage(${i})">${i}</button>
                `;
            }

            paginationNumbers.innerHTML = paginationHTML;
        }

        function goToPage(page) {
            currentPage = page;
            renderProductsTable();
        }
    </script>
</body>
</html>