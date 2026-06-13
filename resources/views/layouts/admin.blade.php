<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #017bfe;
            --primary-dark: #0056b3;
            --secondary: #6c5ce7;
            --success: #00b894;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #3498db;
            --dark: #2c3e50;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 12px 32px rgba(30, 41, 59, 0.18);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .sidebar-user {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-details h6 {
            margin: 0;
            font-size: 0.9rem;
        }

        .user-details small {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }

        .nav-link i {
            width: 30px;
            font-size: 1.1rem;
        }

        .nav-header {
            padding: 10px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
        }

        /* Main Content */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .admin-top-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .header-search {
            min-width: 220px;
            max-width: 100%;
        }

        .mobile-nav-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #334155;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .mobile-nav-toggle:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s ease;
            z-index: 950;
        }

        .admin-content {
            padding: 25px;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .form-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            min-width: 720px;
        }

        .btn,
        .form-control,
        .form-select,
        .input-group-text {
            border-radius: 0.6rem;
        }

        .card,
        .modal-content,
        .dropdown-menu,
        .alert {
            border-radius: 0.75rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.6rem;
            border: 1px solid #cbd5e1;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem !important;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            body.sidebar-open .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }

            .mobile-nav-toggle {
                display: inline-flex;
            }

            .admin-top-header {
                padding: 12px 16px;
                flex-direction: column;
                align-items: stretch;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
                gap: 12px;
            }

            .header-search {
                width: 100%;
                min-width: 0;
                order: 2;
            }

            .header-search .form-control {
                width: 100% !important;
            }

            .admin-content {
                padding: 16px;
            }

            .form-card {
                padding: 20px;
            }

            .stat-card,
            .table-container {
                padding: 16px;
            }

            .sidebar-user .user-details h6 {
                max-width: 160px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        @media (max-width: 575.98px) {
            .page-title {
                font-size: 1.1rem;
            }

            .header-right {
                gap: 8px;
            }

            .nav-link {
                padding: 11px 16px;
            }

            .sidebar-header,
            .sidebar-user {
                padding: 16px;
            }

            .sidebar-header h3 {
                font-size: 1.25rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h3>EDUCONECX</h3>
        </div>

        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h6>{{ Auth::user()->name }}</h6>
                    <small>Administrator</small>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-header">Main</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>

            <div class="nav-header">Management</div>
            <div class="nav-item">
                <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Courses
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.english-practice-courses.index') }}" class="nav-link {{ request()->routeIs('admin.english-practice-*') ? 'active' : '' }}">
                    <i class="fas fa-video"></i> English Practice
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.english-practice-courses.create') }}" class="nav-link {{ request()->routeIs('admin.english-practice-courses.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Add Practice Course
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.quizzes.index') }}" class="nav-link {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i> Quizzes
                </a>
            </div>

            <!-- Add this new Progressive Quiz link -->
            <div class="nav-item">
                <a href="{{ route('admin.progressive-quizzes.index') }}" class="nav-link {{ request()->routeIs('admin.progressive-quizzes.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Progressive Quizzes
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.tags.index') }}" class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <i class="fas fa-tag"></i> Tags
                </a>
            </div>

            <div class="nav-header">Users</div>
            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> All Users
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.practice-credits.index') }}" class="nav-link {{ request()->routeIs('admin.practice-credits.*') ? 'active' : '' }}">
                    <i class="fas fa-coins"></i> Practice Credits
                </a>
            </div>

            <div class="nav-header">Sales</div>
            <div class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </div>
             <div class="nav-item">
                <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i> Subscriptions
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i> Coupons
                </a>
            </div>

            <!-- <div class="nav-header">Engagement</div>
            <div class="nav-item">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Reviews
                </a>
            </div> -->

            <div class="nav-header">Reports</div>
            <div class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </div>

            <div class="nav-header">System</div>
            <div class="nav-item">
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.backup') }}" class="nav-link {{ request()->routeIs('admin.backup') ? 'active' : '' }}">
                    <i class="fas fa-database"></i> Backup
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Profile
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
            </div>
            <div class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none; color: rgba(255,255,255,0.8);">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Header -->
        <header class="admin-top-header">
            <div class="header-left">
                <button class="mobile-nav-toggle" id="mobileNavToggle" type="button" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="header-right">
                <!-- Search -->
                <form action="{{ route('admin.search') }}" method="GET" class="d-flex header-search">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Search..." style="width: 200px;">
                </form>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-link text-dark position-relative" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ route('admin.notifications') }}" class="dropdown-item">View All</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="admin-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
            $('.select2').select2();

            const $body = $('body');
            const $sidebar = $('#adminSidebar');

            $('#mobileNavToggle').on('click', function() {
                $sidebar.toggleClass('active');
                $body.toggleClass('sidebar-open');
            });

            $('#sidebarOverlay').on('click', function() {
                $sidebar.removeClass('active');
                $body.removeClass('sidebar-open');
            });

            $(window).on('resize', function() {
                if (window.innerWidth > 991) {
                    $sidebar.removeClass('active');
                    $body.removeClass('sidebar-open');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>