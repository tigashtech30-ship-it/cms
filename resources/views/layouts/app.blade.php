<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CMS - Complaint Management System</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #16213e 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 18px;
        }
        .sidebar-brand p {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            margin: 0;
        }
        .sidebar-menu { padding: 15px 0; }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left-color: #4e9af1;
        }
        .sidebar-menu a i { font-size: 16px; width: 20px; }
        .sidebar-label {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 5px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .top-navbar .page-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a5f;
            margin: 0;
        }
        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4e9af1, #1e3a5f);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .user-name { font-size: 14px; font-weight: 500; color: #333; }
        .user-role { font-size: 11px; color: #888; }

        /* Page Content */
        .page-content { padding: 25px; }

        /* Cards */
        .stat-card {
            border-radius: 12px;
            border: none;
            color: white;
            padding: 20px;
        }
        .stat-card-1 { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-card-2 { background: linear-gradient(135deg, #11998e, #38ef7d); }
        .stat-card-3 { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .stat-card .number { font-size: 32px; font-weight: 700; }
        .stat-card .label { font-size: 13px; opacity: 0.85; }
        .stat-card .icon { font-size: 28px; opacity: 0.7; }

        /* Table Card */
        .table-card {
            background: #fff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table-card .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 18px 20px;
        }
        .table thead th {
            background: #f8f9fc;
            color: #6c757d;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 12px 16px;
        }
        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-color: #f5f5f5;
            font-size: 14px;
        }
        .table tbody tr:hover { background: #f8f9ff; }

        /* Badges */
        .badge-active { background: #d1fae5; color: #065f46; font-size: 12px; padding: 5px 10px; border-radius: 20px; }
        .badge-inactive { background: #fee2e2; color: #991b1b; font-size: 12px; padding: 5px 10px; border-radius: 20px; }
        .branch-code-badge { background: #ede9fe; color: #5b21b6; font-size: 12px; padding: 4px 10px; border-radius: 8px; font-weight: 600; }
        .branch-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #ede9fe;
            color: #5b21b6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        /* Form */
        .form-card {
            background: #fff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #1e3a5f, #4e9af1);
            padding: 25px;
            color: white;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 14px;
            font-size: 14px;
            background: #fafafa;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4e9af1;
            box-shadow: 0 0 0 3px rgba(78,154,241,0.15);
            background: #fff;
        }
        .form-label { font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .btn-primary-custom {
            background: linear-gradient(135deg, #1e3a5f, #4e9af1);
            border: none;
            border-radius: 8px;
            padding: 11px 20px;
            font-weight: 600;
            font-size: 14px;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover { opacity: 0.9; transform: translateY(-1px); color: white; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>📋 CMS</h4>
            <p>Complaint Management</p>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-label">Main Menu</div>

            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('superadmin.dashboard') }}"
                    class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('superadmin.complaints') }}"
                    class="{{ request()->routeIs('superadmin.complaints') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> All Complaints
                </a>
                <a href="{{ route('superadmin.branches') }}"
                    class="{{ request()->routeIs('superadmin.branches') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> All Branches
                </a>
                <a href="{{ route('superadmin.users') }}"
                    class="{{ request()->routeIs('superadmin.users') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> All Users
                </a>

                <a href="{{ route('superadmin.reports.index') }}"
                    class="{{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-download"></i> Reports
                </a>
        {{-- admin dashboard --}}
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.branches.index') }}"
                   class="{{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Branches
                </a>

                 <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Categories
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users
                </a>

                <a href="{{ route('admin.complaints.index') }}"
                    class="{{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> Complaints
                </a>
                
            @else
                <a href="{{ route('user.dashboard') }}"
                   class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('user.dashboard') }}#my-complaints"
                   class="{{ request()->routeIs('user.complaint.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> My Complaints
                </a>
            @endif

            <div class="sidebar-label" style="margin-top:10px;">Account</div>
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <h1 class="page-title">
                {{ $header ?? 'Dashboard' }}
            </h1>
            <div class="user-badge">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            {{ $slot }}
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>