<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.products') ? 'active' : '' }}"
                        href="{{ route('shop.products') }}">Products</a>
                </li>

                {{-- Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('shop.about') || request()->routeIs('shop.contact') ? 'active' : '' }}"
                        href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="moreDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('shop.about') ? 'active' : '' }}"
                                href="{{ route('shop.about') }}">About</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('shop.contact') ? 'active' : '' }}"
                                href="{{ route('shop.contact') }}">Contact</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <div class="d-flex align-items-center">
                {{-- <div class="me-3">
                    <a href="#" class="text-dark"><i class="fas fa-search"></i></a>
                </div> --}}
                <div class="me-3">
                    <a href="#" class="text-dark"><i class="fas fa-user"></i></a>
                </div>
                <div class="cart-icon" id="cartIcon">
                    <a href="#" class="text-dark"><i class="fas fa-shopping-cart"></i></a>
                    <span class="cart-badge">3</span>
                </div>
            </div>
        </div>
    </div>
</nav>
