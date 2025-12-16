<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Budget Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand alloc-logo" href="{{ route('dashboard') }}">
                Al<span>loc</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}"
                           class="nav-link {{ request()->routeIs('transactions.*') ? 'active fw-semibold' : '' }}">
                            Transactions
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}"
                           class="nav-link {{ request()->routeIs('categories.*') ? 'active fw-semibold' : '' }}">
                            Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('budgets.index') }}"
                           class="nav-link {{ request()->routeIs('budgets.*') ? 'active fw-semibold' : '' }}">
                            Budgets
                        </a>
                    </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                </ul>

                @auth
                <div class="dropdown">
                    <button class="btn btn-sm btn-navbar dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth

            </div>

        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container py-4">

        <!-- ERROR ALERTS -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>