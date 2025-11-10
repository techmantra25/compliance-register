<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('admin/sidebar.dashboard'))</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="overlay" id="overlay"></div>

    {{-- Sidebar --}}
    <nav class="sidebar" id="sidebar">
        <div class="text-left d-flex mb-4 mx-3 align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="40" width="35">
            <span class="ms-2 fw-semibold">{{__('admin/sidebar.project_name')}}</span>
        </div>

        <ul class="nav flex-column px-2">
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house me-2"></i> {{ __('admin/sidebar.dashboard') }}
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('admin.employees') }}"
                   class="nav-link {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> {{ __('admin/sidebar.employees') }}
                </a>
            </li>

           <li class="nav-item mb-2">
                <a href="{{ route('admin.agents') }}"
                class="nav-link {{ request()->routeIs('admin.agents') ? 'active' : '' }}">
                    <i class="bi bi-person-badge me-2"></i> {{ __('admin/sidebar.agents') }}
                </a>
            </li>
           <li class="nav-item mb-2">
                <a href="{{ route('admin.assemblies') }}"
                class="nav-link {{ request()->routeIs('admin.assemblies') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> {{ __('admin/sidebar.assemblies') }}
                </a>
            </li>
            <!-- Candidates Dropdown -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/candidates*') ? 'active' : 'collapsed' }}"
                data-bs-toggle="collapse"
                href="#candidateMenu"
                role="button"
                aria-expanded="{{ request()->is('admin/candidates*') ? 'true' : 'false' }}"
                aria-controls="candidateMenu">
                    <span><i class="bi bi-person-badge me-2"></i> {{ __('admin/sidebar.candidates') }}</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>

                <div class="collapse {{ request()->is('admin/candidates*') ? 'show' : '' }}" id="candidateMenu">
                    <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                        <li class="nav-item mb-1">
                            <a href="{{ route('admin.candidates.contacts') }}"
                            class="nav-link small {{ request()->routeIs('admin.candidates.contacts') ? 'active' : '' }}">
                                <i class="bi bi-telephone me-1"></i> {{ __('admin/sidebar.nomination_list') }}
                            </a>
                        </li>
                        {{-- <li class="nav-item mb-1">
                            <a href="{{ route('admin.candidates.discrepancies.report') }}"
                            class="nav-link small {{ request()->routeIs('admin.candidates.discrepancies.report') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text me-1"></i> Social Media
                                <!--<i class="bi bi-file-earmark-text me-1"></i> {{ __('admin/sidebar.discrepancy_list') }}-->
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Main Content --}}
    <div class="flex-grow-1">
        <header class="topbar d-flex justify-content-between align-items-center px-3">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle btn btn-link p-0" id="menu-toggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h6 class="mb-0 fw-semibold">@yield('title', __('admin/sidebar.dashboard'))</h6>
            </div>

            <div class="d-flex align-items-center gap-3">
                {{-- ЁЯМР Language Toggle --}}
                <div class="language-toggle">
                    <!--@if(app()->getLocale() == 'en')-->
                    <!--    <a href="{{ route('lang.switch', 'bn') }}" class="btn btn-sm btn-outline-primary">ржмрж╛ржВрж▓рж╛</a>-->
                    <!--@else-->
                    <!--    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm btn-outline-primary">English</a>-->
                    <!--@endif-->
                </div>

                {{-- ЁЯСд Admin Profile Dropdown --}}
                <div class="dropdown">
                    <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/user.png') }}" class="rounded-circle me-2" width="32" height="32" alt="User">
                        <span>{{ Auth::guard('admin')->user()->name ?? __('admin/sidebar.admin') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="#">{{ __('admin/sidebar.profile') }}</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">{{ __('admin/sidebar.logout') }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="main-content">
            {{ $slot }}
        </main>
    </div>

    {{-- Scripts --}}
    @livewireScripts
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "4000"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>

    @stack('scripts')

    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>
