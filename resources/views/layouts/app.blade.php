<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page Title -->
    <title>
        @yield('title') {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.svg') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="site">
    <nav class="navigation" id="nav">
        <div class="navigation_inner wrapper">
            <div>
                <a href="{{ url('/') }}" id="logo">
                    @include('partials.logo')
                </a>
            </div>
            <div>
                <div id="mobile_main_nav">
                    <button onclick="mobileNavToggle()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div id="main_nav">
                    <a href="{{ url('/') }}" class="main_nav_item">
                        {{ trans('app.home') }}
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="main_nav_item">
                            {{ trans('app.sign_in') }}
                        </a>
                        <a href="{{ route('register') }}" class="main_nav_item">
                            {{ trans('app.register') }}
                        </a>
                    @endguest
                </div>
            </div>
            <div id="account_nav">
                @auth
                    <div class="dropdown">
                        <button class="dropdown_button">
                            <img src="{{ request()->user()->gravatar }}" class="user_avatar account_nav_avatar"
                                 alt="{{ request()->user()->username }}"/>
                            <i class="fas fa-caret-down account_nav_icon"></i>
                        </button>
                        <div class="dropdown_content">
                            <a href="{{ route('account') }}" title="{{ trans('app.account_settings') }}">
                                <i class="fa fa-user-circle"></i>
                                {{ trans('app.account_settings') }}
                            </a>
                            <a href="{{ route('projects.index') }}" title="{{ trans('app.projects') }}">
                                <i class="fa fa-project-diagram"></i>
                                {{ trans('app.projects') }}
                            </a>
                            @if(request()->user()->isSuperAdmin())
                                <a href="{{ route('admin.stats') }}" title="{{ trans('app.admin_stats') }}">
                                    <i class="fa fa-chart-line"></i>
                                    {{ trans('app.admin_stats') }}
                                </a>
                            @endif
                            <a class="dropdown_content_danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                               title="{{ trans('app.sign_out') }}">
                                <i class="fa fa-sign-out-alt"></i>
                                {{ trans('app.sign_out') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endauth
                @guest
                @endguest
            </div>
        </div>
    </nav>
    <nav id="mobile_main_nav_content">
        <ul>
            <li id="#home">
                <a href="{{ url('/') }}" class="mobile_main_nav_content_item">
                    {{ trans('app.home') }}
                </a>
            </li>
            @guest
                <li id="#login">
                    <a href="{{ route('login') }}" class="mobile_main_nav_content_item">
                        {{ trans('app.login') }}
                    </a>
                </li>
                <li id="#register">
                    <a href="{{ route('register') }}" class="mobile_main_nav_content_item">
                        {{ trans('app.register') }}
                    </a>
                </li>
            @endguest
            @auth
                <li id="#settings">
                    <a href="{{ route('account') }}" class="mobile_main_nav_content_item">
                        {{ trans('app.account_settings') }}
                    </a>
                </li>
                <li id="#projects">
                    <a href="{{ route('projects.index') }}" class="mobile_main_nav_content_item">
                        {{ trans('app.projects') }}
                    </a>
                </li>
            @if(request()->user()->isSuperAdmin())
                    <li id="#admin_stats">
                        <a href="{{ route('admin.stats') }}" class="mobile_main_nav_content_item">
                            {{ trans('app.admin_stats') }}
                        </a>
                    </li>
                @endif
                <li id="#logout">
                    <a href="{{ route('logout') }}" class="mobile_main_nav_content_item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ trans('app.sign_out') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            @endauth
        </ul>
    </nav>
    <main>
        <div class="wrapper">
            <!-- Breadcrumb -->
            {{ Breadcrumbs::render() }}
            @include('partials.flash_messages')
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="footer_inner">
            <div>
                {{ config('app.name', 'Laravel') . ' © '. date('Y') }}
            </div>
            <div>
                <ul class="footer_links">
                    <li class="footer_link">
                        <a href="/privacy-policy" target="_blank" title="{{ trans('app.privacy_policy') }}">
                            {{ trans('app.privacy_policy') }}
                        </a>
                    </li>
                    <li class="footer_link">
                        <a href="{{ config('app.twitter_url') }}" target="_blank" title="{{ trans('app.twitter') }}">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="footer_link">
                        <a href="{{ config('app.github_url') }}" target="_blank" title="{{ trans('app.github') }}">
                            <i class="fab fa-github-alt"></i>
                        </a>
                    </li>
                    <li class="footer_link">
                        <a href="{{ config('app.discord_url') }}" target="_blank" title="{{ trans('app.discord') }}">
                            <i class="fab fa-discord"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</div>
<script>
    function mobileNavToggle() {
        const x = document.getElementById("mobile_main_nav_content");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
</script>
</body>
@stack('scripts')
<script>
    MicroModal.init();
</script>
</html>
