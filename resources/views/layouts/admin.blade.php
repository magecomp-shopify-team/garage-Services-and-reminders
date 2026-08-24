<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GaragePro Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #2b3035;
            color: #fff;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background-color: #ff4757;
        }
        .sidebar .nav-heading {
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
            padding: 15px 20px 5px;
        }
        .main-content {
            padding: 20px;
        }
        .navbar-top {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f4f6f9;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" style="width: 250px;">
            <div class="p-3">
                <h4 class="text-white"><i class="bi bi-tools text-danger"></i> GaragePro</h4>
            </div>
            
            <a href="{{ url('/admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            
            <div class="nav-heading">Customers</div>
            <a href="{{ url('/admin/customers') }}"><i class="bi bi-people me-2"></i> Customers</a>
            <a href="{{ url('/admin/vehicles') }}"><i class="bi bi-car-front me-2"></i> Vehicles</a>
            
            <div class="nav-heading">Workshop</div>
            <a href="{{ url('/admin/job-cards') }}"><i class="bi bi-clipboard2-data me-2"></i> Job Cards</a>
            <a href="{{ url('/admin/services') }}"><i class="bi bi-wrench me-2"></i> Services</a>
            <a href="{{ url('/admin/mechanics') }}"><i class="bi bi-person-gear me-2"></i> Mechanics</a>
            <a href="{{ url('/admin/spare-parts') }}"><i class="bi bi-gear-wide-connected me-2"></i> Spare Parts</a>
            
            <div class="nav-heading">Billing</div>
            <a href="{{ url('/admin/invoices') }}"><i class="bi bi-receipt me-2"></i> Invoices</a>
            <a href="{{ url('/admin/payments') }}"><i class="bi bi-cash-coin me-2"></i> Payments</a>
            
            <div class="nav-heading">Reminders</div>
            <a href="{{ url('/admin/service-reminders') }}"><i class="bi bi-bell me-2"></i> Service Reminders</a>
            
            <div class="nav-heading">Reports</div>
            <a href="{{ url('/admin/reports') }}"><i class="bi bi-bar-chart me-2"></i> Reports</a>
            
            <div class="nav-heading">System</div>
            <a href="{{ url('/admin/users') }}"><i class="bi bi-person-badge me-2"></i> Users</a>
            <a href="{{ url('/admin/settings') }}"><i class="bi bi-gear me-2"></i> Settings</a>
            
            <form method="POST" action="{{ url('/admin/logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none w-100 text-start ps-4">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 bg-light">
            <nav class="navbar navbar-expand-lg navbar-light navbar-top px-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">@yield('header', 'Dashboard')</span>
                    <div class="d-flex align-items-center">
                        <span class="me-3">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </nav>

            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
