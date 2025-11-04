<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Employer Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #212529;
      color: #fff;
      transition: all 0.3s;
    }
    .sidebar .nav-link {
      color: #adb5bd;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 15px;
      border-radius: 8px;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #495057;
      color: #fff;
    }
    .sidebar h5 {
      font-size: 18px;
      margin-bottom: 1rem;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    @media (max-width: 992px) {
      .sidebar {
        left: -250px;
      }
      .sidebar.show {
        left: 0;
      }
      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column p-3">
    <h5 class="text-white fw-bold mb-4">Employer Panel</h5>
    <ul class="nav nav-pills flex-column mb-auto">
      <li><a href="{{ route('employer.dashboard') }}" class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a></li>
      <li><a href="{{ route('employer.profile') }}" class="nav-link {{ request()->routeIs('employer.profile') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> My Profile
      </a></li>
      <li><a href="{{ route('employer.jobs.create') }}" class="nav-link {{ request()->routeIs('employer.jobs.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Post a Job
      </a></li>
      <li><a href="{{ route('employer.jobs.index') }}" class="nav-link {{ request()->routeIs('employer.jobs.index') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i> Manage Jobs
      </a></li>
      <li><a href="{{ route('employer.applications.index') }}" class="nav-link {{ request()->routeIs('employer.applications.index') ? 'active' : '' }}">
        <i class="bi bi-envelope-open"></i> Applications
      </a></li>
      <li><a href="{{ route('employer.comments.index') }}" class="nav-link {{ request()->routeIs('employer.comments.index') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i> Comments
      </a></li>
      <li><a href="{{ route('employer.analytics') }}" class="nav-link {{ request()->routeIs('employer.analytics') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line"></i> Analytics
      </a></li>
      <li><a href="{{ route('employer.notifications') }}" class="nav-link {{ request()->routeIs('employer.notifications') ? 'active' : '' }}">
        <i class="bi bi-bell"></i> Notifications
      </a></li>
      <li><a href="{{ route('logout') }}" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a></li>
    </ul>
  </div>

  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top" style="margin-left:250px;">
    <div class="container-fluid">
      <button class="btn btn-outline-secondary d-lg-none" id="toggleSidebar">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand ms-3 fw-semibold">Job Board System</span>
      <div class="dropdown ms-auto me-3">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
          <img src="https://via.placeholder.com/40" alt="user" class="rounded-circle me-2">
          <span>{{ Auth::user()->name ?? 'Employer' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{ route('employer.profile') }}">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="content pt-5 mt-4">
    <div class="container-fluid">
      @yield('content')
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  </script>
</body>
</html>
