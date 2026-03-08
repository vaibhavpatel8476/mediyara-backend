<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Mediyara</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-text-hover: #f1f5f9;
            --sidebar-active: #3b82f6;
            --header-height: 64px;
            --header-bg: #ffffff;
            --header-border: #e2e8f0;
            --content-bg: #f1f5f9;
            --card-bg: #ffffff;
            --card-radius: 12px;
            --card-shadow: 0 1px 3px rgba(0,0,0,.06);
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
            background: var(--content-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }
        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: transform .2s ease, width .2s ease;
        }
        .admin-sidebar__brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .admin-sidebar__brand a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
            font-size: 1.125rem;
        }
        .admin-sidebar__brand svg { flex-shrink: 0; }
        .admin-sidebar__nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }
        .admin-sidebar__nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            margin-bottom: 2px;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }
        .admin-sidebar__nav a:hover {
            background: rgba(255,255,255,.06);
            color: var(--sidebar-text-hover);
        }
        .admin-sidebar__nav a.active {
            background: rgba(59, 130, 246, .15);
            color: var(--sidebar-active);
        }
        .admin-sidebar__nav a svg { flex-shrink: 0; opacity: .9; }
        .admin-sidebar__nav a.active svg { opacity: 1; }
        .admin-sidebar__footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .admin-sidebar__footer a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.9375rem;
            transition: background .15s, color .15s;
        }
        .admin-sidebar__footer a:hover { background: rgba(239, 68, 68, .15); color: #f87171; }
        .sidebar-logout-btn {
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            font: inherit;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: var(--sidebar-text);
            font-size: 0.9375rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }
        .sidebar-logout-btn:hover { background: rgba(239, 68, 68, .15); color: #f87171; }
        /* Main wrapper */
        .admin-main-wrap {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Top header */
        .admin-header {
            height: var(--header-height);
            background: var(--header-bg);
            border-bottom: 1px solid var(--header-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        .admin-header__title { font-size: 1.25rem; font-weight: 600; color: var(--text-primary); }
        .admin-header__actions { display: flex; align-items: center; gap: 1rem; }
        .admin-header__user { font-size: 0.875rem; color: var(--text-muted); }
        /* Content */
        .admin-content {
            flex: 1;
            padding: 1.5rem 2rem 2rem;
        }
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main-wrap { margin-left: 0; }
            .admin-content { padding: 1rem; }
        }
        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--header-bg);
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-primary);
        }
        @media (max-width: 768px) {
            .menu-toggle { display: flex; }
        }
        /* Overlay when sidebar open on mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 35;
        }
        @media (max-width: 768px) {
            .sidebar-overlay.open { display: block; }
        }
        /* Cards & tables */
        .card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .card-header h2 { margin: 0; font-size: 1.0625rem; font-weight: 600; }
        .card-body { padding: 1.5rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid var(--border); }
        th { font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .02em; }
        tr:last-child td { border-bottom: none; }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-processing { background: #ede9fe; color: #5b21b6; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            font-family: inherit;
            transition: background .15s, border-color .15s, color .15s;
        }
        .btn-primary { background: #2563eb; color: white; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-outline { background: white; border-color: var(--border); color: var(--text-primary); }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }
        .btn-danger { background: #dc2626; color: white; border-color: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.8125rem; }
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-size: 0.9375rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
        }
        .stat-card .label { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.375rem; font-weight: 500; }
        .stat-card .value { font-size: 1.75rem; font-weight: 700; letter-spacing: -0.02em; }
        select {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: inherit;
        }
        .flex { display: flex; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .items-center { align-items: center; }
        .flex-wrap { flex-wrap: wrap; }
        form.inline { display: inline; margin: 0; }
        label.block { display: block; margin-bottom: 0.375rem; font-size: 0.875rem; font-weight: 500; color: var(--text-primary); }
        input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9375rem;
            font-family: inherit;
        }
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { margin: 0 0 0.25rem; font-size: 1.5rem; font-weight: 700; }
        .page-header p { margin: 0; color: var(--text-muted); font-size: 0.9375rem; }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">
    <div class="sidebar-overlay" :class="{ open: sidebarOpen }" @click="sidebarOpen = false"></div>

    <aside class="admin-sidebar" :class="{ open: sidebarOpen }">
        <div class="admin-sidebar__brand">
            <a href="{{ route('admin.dashboard') }}">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
                <span>Mediyara</span>
            </a>
        </div>
        <nav class="admin-sidebar__nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Bookings
            </a>
            <a href="{{ route('admin.test-results.index') }}" class="{{ request()->routeIs('admin.test-results.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Test Results
            </a>
            <a href="{{ route('admin.enquiries.index') }}" class="{{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Enquiries
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Users
            </a>
            <a href="{{ route('admin.admins.index') }}" class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Admins
            </a>
        </nav>
        <div class="admin-sidebar__footer">
            <form method="POST" action="{{ route('admin.logout') }}" class="inline" style="width:100%;">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main-wrap">
        <header class="admin-header">
            <div class="flex items-center gap-3">
                <button type="button" class="menu-toggle" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <span class="admin-header__title">@yield('header_title', 'Admin')</span>
            </div>
            <div class="admin-header__actions">
                <span class="admin-header__user">{{ auth()->guard('admin')->user()->email ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Log out</button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
