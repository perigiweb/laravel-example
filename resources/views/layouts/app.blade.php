<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ ($pageTitle ?? '') . ' - ' . config('app.name') }}</title>
        <meta name="description" content="{{ $meta_desc ?? '' }}" />
        @stack('head')
        @vite('resources/js/app.js')
    </head>
    <body>
        <div class="d-flex flex-column min-vh-100">
            <header class="navbar navbar-expand fixed-top border-bottom bg-body-tertiary">
                <div class="container-md">
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="/" class="navbar-brand d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke="currentColor" stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                        <div class="d-none d-md-block fw-bold">{{ config('app.name') }}</div>
                    </a>
                    @if (Route::has('login'))
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <nav class="navbar-nav ms-auto nav-underline align-items-center" role="navigation">
                            @auth
                            <a class="btn btn-primary btn-sm" href="{{ route('post.create') }}">+ Create Post</a>
                            <a class="nav-link @if (request()->routeIs('post.*')) active @endif" href="{{ route(auth()->user()->is_admin ? 'post.index':'post.me') }}">{{ auth()->user()->is_admin ? 'All':'My' }} Posts</a>
                            @if (auth()->user()->is_admin)
                            <a class="nav-link @if (request()->routeIs('user.*')) active @endif" href="{{ route('user.index') }}">Users</a>
                            @endif

                            @else
                            <a class="nav-link" href="{{ route('login') }}">Login</a> or
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                            @endauth
                        </nav>
                    </div>
                    @endif
                    @auth
                    <div class="navbar-nav flex-row ms-3">
                        <div class="nav-item dropdown">
                            <a class="nav-link d-flex gap-1 align-items-center p-0" data-bs-toggle="dropdown" aria-label="Open User Menu"
                                aria-expanded="false" href="#">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" /><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /><path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" /></svg>
                                <div class="d-none d-sm-block fw-bold">{{ auth()->user()->name }}</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-item fw-bold">{{ auth()->user()->name }}</div>
                                <a class="dropdown-item" href="{{ route('user.me') }}">Edit Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>
            <main class="main-wrapper flex-fill py-4">
                <div class="container-md">
                    @yield('content')
                </div>
            </main>
            <footer class="bg-secondary text-light py-3">
                <div class="container-md d-flex flex-column flex-sm-row justify-content-between align-items-center gap-sm-2">
                    <div>&copy; 2024. <a href="https://perigi.my.id" class="text-light">PerigiWeb</a></div>
                    <div class="small">Built With Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</div>
                </div>
            </footer>
        </div>
        <div class="modal modal-blur fade" id="modal-alert" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content translate-middle-y">
                    <div class="modal-body lh-sm"></div>
                    <div class="modal-footer justify-content-center p-1"></div>
                </div>
            </div>
        </div>
    </body>
    @stack('scripts')
</html>