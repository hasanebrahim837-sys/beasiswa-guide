<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>Beasiswa Guide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #172033;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #0f766e;
        }

        .logo span {
            color: #111827;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-links a {
            color: #374151;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: #0f766e;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #0f766e;
            color: white;
        }

        .btn-primary:hover {
            background: #115e59;
        }

        .btn-light {
            background: white;
            color: #0f766e;
        }

        .btn-outline {
            border: 1px solid #0f766e;
            color: #0f766e;
            background: transparent;
        }

        .hero {
            padding: 80px 8%;
            background: linear-gradient(135deg, #0f766e, #064e3b);
            color: white;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: center;
        }

        .hero h1 {
            font-size: 48px;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.8;
            color: #d1fae5;
            margin-bottom: 30px;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 22px;
            padding: 30px;
            backdrop-filter: blur(8px);
        }

        .hero-card h3 {
            margin-bottom: 15px;
            font-size: 24px;
        }

        .hero-card ul {
            list-style: none;
            line-height: 2.1;
            color: #ecfdf5;
        }

        .section {
            padding: 65px 8%;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .section-title h2 {
            font-size: 32px;
            color: #111827;
        }

        .section-title p {
            color: #6b7280;
            margin-top: 8px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 35px;
        }

        .stat-card {
            background: white;
            color: #111827;
            border-radius: 18px;
            padding: 22px;
        }

        .stat-card h3 {
            color: #0f766e;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
            border: 1px solid #eef2f7;
        }

        .card h3 {
            font-size: 21px;
            margin-bottom: 12px;
            color: #111827;
        }

        .card p {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .badge-open {
            background: #dcfce7;
            color: #166534;
        }

        .badge-closed {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-soon {
            background: #fef3c7;
            color: #92400e;
        }

        .meta {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
        }

        .detail-box {
            background: white;
            border-radius: 22px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        }

        .detail-box h1 {
            font-size: 38px;
            margin-bottom: 15px;
        }

        .info-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: 25px 0;
        }

        .info-item {
            background: #f8fafc;
            padding: 18px;
            border-radius: 14px;
        }

        .info-item strong {
            display: block;
            margin-bottom: 8px;
            color: #0f766e;
        }

        .content-block {
            margin-top: 28px;
        }

        .content-block h3 {
            margin-bottom: 10px;
            color: #111827;
        }

        .content-block p {
            line-height: 1.8;
            color: #4b5563;
            white-space: pre-line;
        }

        .form-card {
            background: white;
            border-radius: 22px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #374151;
        }

        .form-full {
            grid-column: 1 / -1;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 15px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .table-card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        .admin-table th {
            color: #374151;
            background: #f9fafb;
        }

        .status-pill {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            background: #e0f2fe;
            color: #075985;
        }

        .file-link {
            display: block;
            margin-bottom: 8px;
            color: #0f766e;
            font-weight: bold;
        }

        .footer {
            background: #111827;
            color: #d1d5db;
            text-align: center;
            padding: 25px 8%;
            margin-top: 60px;
        }

        @media (max-width: 900px) {

            .hero,
            .grid,
            .stats,
            .info-row,
            .filter-box,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 34px;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 14px;
            }

            .section-title {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">Beasiswa<span>Guide</span></a>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('scholarships.index') }}">Scholarships</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.assistance_requests.index') }}">Requests</a>
                    <a href="{{ route('admin.scholarships.index') }}">Manage Scholarships</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                        style="background:none; border:none; font-weight:bold; color:#374151; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        @hasSection('content')
            @yield('content')
        @else
            @isset($slot)
                {{ $slot }}
            @endisset
        @endif
    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} Beasiswa Guide. Find verified scholarships and apply through official links.</p>
    </footer>
</body>

</html>