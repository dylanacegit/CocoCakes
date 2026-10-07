<nav class="navbar navbar-expand-xl site-navbar" data-bs-theme="light">
    <div class="container py-2 py-xl-3">
        <a class="navbar-brand brand me-xl-4" href="{{ route('home') }}">
            Coco Cakes
        </a>

        <button class="navbar-toggler ms-auto" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavigation"
            aria-controls="mainNavigation"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav main-navigation me-auto align-items-xl-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu*') ? 'active' : '' }}"
                        href="{{ route('menu') }}">
                        Menu
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        Contact
                    </a>
                </li>

                @if (! auth()->check() || auth()->user()->role === 'user')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                            href="{{ route('order.create') }}">
                            Order
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav authentication-navigation ms-xl-auto align-items-xl-center gap-xl-2">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Log in
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn register-button"
                            href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                Products
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                                href="{{ route('admin.orders.index') }}">
                                Orders
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'user')
                        <li class="nav-item dropdown">
                            <a class="nav-link
                                {{ request()->routeIs('customer.*') ? 'active' : '' }}"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                My Account
                            </a>

                            <ul class="dropdown-menu shadow-sm">
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.requests') }}">
                                        My Cake Requests
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.favorites') }}">
                                        Saved Cakes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.pets') }}">
                                        My Pets
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth            


                @auth
                    <li class="nav-item dropdown">
                        <button class="btn user-menu-button dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="dropdown-header">
                                {{ Auth::user()->email }}
                            </li>

                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('profile.edit') }}">
                                    Profile
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button class="dropdown-item" type="submit">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
