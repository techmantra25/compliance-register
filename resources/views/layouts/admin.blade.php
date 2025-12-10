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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
            <!-- Master Data Dropdown -->
            @if(userAccess(Auth::guard('admin')->user()->id,'master_management'))
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/master*') ? 'active' : 'collapsed' }}"
                        data-bs-toggle="collapse"
                        href="#masterMenu"
                        role="button"
                        aria-expanded="{{ request()->is('admin/master*') ? 'true' : 'false' }}"
                        aria-controls="masterMenu">
                        <span><i class="bi bi-gear me-2"></i> Master</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->is('admin/master*') ? 'show' : '' }}" id="masterMenu">
                        <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_view_zones'))
                                <li class="nav-item mb-1">
                                    <a href="{{ route('admin.master.zones') }}"
                                        class="nav-link small {{ request()->routeIs('admin.master.zones') ? 'active' : '' }}">
                                        <i class="bi bi-geo-alt me-1"></i> Zones
                                    </a>
                                </li>
                            @endif

                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_view_phases'))
                                <li class="nav-item mb-1">
                                    <a href="{{ route('admin.master.phases') }}"
                                        class="nav-link small {{ request()->routeIs('admin.master.phases') ? 'active' : '' }}">
                                        <i class="bi bi-calendar2-event me-1"></i> Phases
                                    </a>
                                </li>
                            @endif
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'master_view_event_categories'))
                                <li class="nav-item mb-1">
                                <a href="{{ route('admin.master.eventcategory') }}"
                                    class="nav-link small {{ request()->routeIs('admin.master.eventcategory') ? 'active' : '' }}">
                                        <i class="bi bi-calendar-event-fill me-1"></i> Event Categories
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif


            @if(userAccess(Auth::guard('admin')->user()->id,'employee_management'))
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.employees') }}"
                    class="nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Employees
                    </a>
                </li>
            @endif

            @if(userAccess(Auth::guard('admin')->user()->id,'contact_management'))
            <li class="nav-item mb-2">
                    <a href="{{ route('admin.agents') }}"
                    class="nav-link {{ request()->routeIs('admin.agents') ? 'active' : '' }}">
                        <i class="bi bi-person-badge me-2"></i> Contacts
                    </a>
                </li>
            @endif

            @if(userAccess(Auth::guard('admin')->user()->id,'assembly_management'))
            <li class="nav-item mb-2">
                    <a href="{{ route('admin.assemblies') }}"
                    class="nav-link {{ request()->routeIs('admin.assemblies') ? 'active' : '' }}">
                        <i class="bi bi-building me-2"></i> {{ __('admin/sidebar.assemblies') }}
                    </a>
                </li>
            @endif
            <!-- Candidates Dropdown -->
            @if(userAccess(Auth::guard('admin')->user()->id,'nomination_management'))
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('admin/candidates*') ? 'active' : 'collapsed' }}"
                    data-bs-toggle="collapse"
                    href="#candidateMenu"
                    role="button"
                    aria-expanded="{{ request()->is('admin/candidates*') ? 'true' : 'false' }}"
                    aria-controls="candidateMenu">
                        <span><i class="bi bi-person-badge me-2"></i> Nominations</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->is('admin/candidates*') ? 'show' : '' }}" id="candidateMenu">
                        <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'nomination_view_candidate'))
                                <li class="nav-item mb-1">
                                    <a href="{{ route('admin.candidates.contacts') }}"
                                    class="nav-link small {{ request()->routeIs('admin.candidates.contacts') ? 'active' : '' }}">
                                        <i class="bi bi-people me-2"></i> Candidates
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            <!-- Candidates Dropdown -->
            @if(userAccess(Auth::guard('admin')->user()->id,'campaign_management'))
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center 
                        {{ request()->is('admin/campaign*') ? 'active' : 'collapsed' }}"
                        data-bs-toggle="collapse"
                        href="#campaignMenu"
                        role="button"
                        aria-expanded="{{ request()->is('admin/campaign*') ? 'true' : 'false' }}"
                        aria-controls="campaignMenu">

                        <span><i class="bi bi-megaphone-fill me-2"></i> Campaigns</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->is('admin/campaign*') ? 'show' : '' }}" id="campaignMenu">
                        <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_view_campaign'))
                                <li class="nav-item mb-1">
                                    <a href="{{ route('admin.campaigns') }}"
                                    class="nav-link small {{ request()->routeIs('admin.campaigns') ? 'active' : '' }}">
                                        <i class="bi bi-clipboard-data me-2"></i> List
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="collapse {{ request()->is('admin/campaign*') ? 'show' : '' }}" id="campaignMenu">
                        <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'campaign_view_campaigner'))
                                <li class="nav-item mb-1">
                                    <a href="{{route('admin.campaigns.star-campaigner')}}"
                                    class="nav-link small {{ request()->routeIs('admin.campaigns') ? 'active' : '' }}">
                                        <i class="bi bi-star me-2"></i> Star Campaigner
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if(userAccess(Auth::guard('admin')->user()->id,'mcc_violation'))
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center 
                        {{ request()->is('admin/mcc*') ? 'active' : 'collapsed' }}"
                        data-bs-toggle="collapse"
                        href="#mccMenu"
                        role="button"
                        aria-expanded="{{ request()->is('admin/mcc*') ? 'true' : 'false' }}"
                        aria-controls="mccMenu">

                        <span><i class="bi bi-controller me-2"></i> MCC Violation</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->is('admin/mcc*') ? 'show' : '' }}" id="mccMenu">
                        <ul class="nav flex-column ms-4 border-start ps-2 mt-1">
                            @if(childUserAccess(Auth::guard('admin')->user()->id,'mcc_view_mcc'))
                                <li class="nav-item mb-1">
                                    <a href="{{route('admin.mcc_violation')}}"
                                    class="nav-link small {{ request()->routeIs('admin.mcc_violation') ? 'active' : '' }}">
                                        <i class="bi bi-clipboard-data me-2"></i> List
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
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
                            <a class="dropdown-item" href="{{route('admin.update.profile')}}">{{ __('admin/sidebar.profile') }}</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"></script>
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
