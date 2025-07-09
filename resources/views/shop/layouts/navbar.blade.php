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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('shop.products') || request()->routeIs('shop.categories') || request()->routeIs('shop.featured') || request()->routeIs('shop.offers') ? 'active' : '' }}"
                        href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu col-12 products-dropdown" aria-labelledby="productsDropdown">
                        <div class="row">
                            <div class="col-4">
                                <a class="dropdown-item" href="{{ route('shop.products') }}">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2603/2603910.png" alt="Categories" class="dropdown-item-img">
                                    All Product
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="dropdown-item" href="#">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2603/2603910.png" alt="Categories" class="dropdown-item-img">
                                    Categories
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="dropdown-item" href="#">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2603/2603910.png" alt="Featured" class="dropdown-item-img">
                                    Featured
                                </a>
                            </div>
                            <div class="col-4">
                                <a class="dropdown-item" href="#">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2603/2603910.png" alt="Special Offers" class="dropdown-item-img">
                                    Special Offers
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.new-arrivals') ? 'active' : '' }}"
                        href="{{ route('shop.new-arrivals') }}">New Arrivals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.about') ? 'active' : '' }}"
                        href="{{ route('shop.about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shop.contact') ? 'active' : '' }}"
                        href="{{ route('shop.contact') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <div class="me-3">
                    <a href="#" class="text-dark"><i class="fas fa-search"></i></a>
                </div>
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
