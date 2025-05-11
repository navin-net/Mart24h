<aside class="sidebar">
    <div class="sidebar-user">
        <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle me-2" width="40" height="40">
            <div>
                <h6 class="mb-0">admin</h6>
                <small class="text-muted">Administrator</small>
            </div>
        </div>
        <div class="dropdown mb-3 w-100">
            <button class="btn btn-outline-custom dropdown-toggle d-flex align-items-center justify-content-between w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div>
                    <i class="bi bi-translate me-2"></i>
                    <span>{{ app()->getLocale() == 'en' ? 'English' : 'Khmer' }}</span>
                </div>
            </button>
            <ul class="dropdown-menu w-100">
                <li>
                    <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ url('/language/en') }}">
                        <i class="bi bi-flag me-2"></i>{{ __('messages.english') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ app()->getLocale() == 'km' ? 'active' : '' }}" href="{{ url('/language/km') }}">
                        <i class="bi bi-flag me-2"></i>{{ __('messages.khmer') }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-end-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control bg-transparent border-start-0" placeholder="Search...">
        </div>
    </div>
    <div class="p-3">
        <a href="{{ url('/dashboard') }}" class="nav-link d-flex align-items-center {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>{{ __('messages.dashboard') }}</span>
        </a>
        <a href="{{ url('/products') }}" class="nav-link d-flex align-items-center {{ request()->is('products') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i>
            <span>{{ __('messages.products') }}</span>
        </a>
        <a href="{{ url('/sales') }}" class="nav-link d-flex align-items-center {{ request()->is('sales') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>{{ __('messages.sales') }}</span>
        </a>
        <a href="{{ url('/purchases') }}" class="nav-link d-flex align-items-center {{ request()->is('purchases') ? 'active' : '' }}">
            <i class="bi bi-cart4"></i>
            <span>{{ __('messages.purchases') }}</span>
        </a>
        <div class="settings-heading">{{ __('messages.settings') }}</div>
        <div class="mb-2">
            <a class="nav-link d-flex align-items-center justify-content-between {{ request()->is('brands', 'categories', 'qualitys') ? 'active' : '' }}"
                data-bs-toggle="collapse"
                href="#settings-nav"
                aria-expanded="{{ request()->is('brands', 'categories', 'qualitys') ? 'true' : 'false' }}"
                aria-controls="settings-nav">
                 <div>
                     <i class="bi bi-gear"></i>
                     <span>{{ __('messages.settings_list') }}</span>
                 </div>
                 <i class="bi bi-chevron-down"></i>
             </a>
             <div id="settings-nav" class="collapse {{ request()->is('brands', 'categories', 'qualitys') ? 'show' : '' }} ps-4 mt-1">

                <a href="{{ url('/brands') }}" class="nav-link d-flex align-items-center {{ request()->is('brands') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>{{ __('messages.brands') }}</span>
                </a>
                <a href="{{ url('/qualitys') }}" class="nav-link d-flex align-items-center {{ request()->is('qualitys') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>{{ __('messages.qualitys_list') }}</span>
                </a>
                <a href="{{ url('/categories') }}" class="nav-link d-flex align-items-center {{ request()->is('categories') ? 'active' : '' }}">
                    <i class="bi bi-box"></i>
                    <span>{{ __('messages.categories') }}</span>
                </a>

            </div>
        </div>




        <div class="settings-heading">{{ __('messages.getting_started') }}</div>
                <div class="mb-2">
            <a class="nav-link d-flex align-items-center justify-content-between {{ request()->is('slider') ? 'active' : '' }}"
                data-bs-toggle="collapse"
                href="#shop-nav"
                aria-expanded="{{ request()->is( 'slider') ? 'true' : 'false' }}"
                aria-controls="shop-nav">
                 <div>
                     <i class="bi bi-shop"></i>
                     <span>{{ __('messages.shop_settings') }}</span>
                 </div>
                 <i class="bi bi-chevron-down"></i>
             </a>
             <div id="shop-nav" class="collapse {{ request()->is('slider') ? 'show' : '' }} ps-4 mt-1">

                <a href="{{ url('/slider') }}" class="nav-link d-flex align-items-center {{ request()->is('slider') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>{{ __('messages.slider') }}</span>
                </a>

            </div>
        </div>
        <a href="{{ url('/documentation') }}" class="nav-link d-flex align-items-center {{ request()->is('documentation') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>{{ __('messages.documentation') }}</span>
        </a>
        <a href="{{ url('/help') }}" class="nav-link d-flex align-items-center {{ request()->is('help') ? 'active' : '' }}">
            <i class="bi bi-question-circle"></i>
            <span>{{ __('messages.help_support') }}</span>
        </a>
        <div class="d-block d-lg-none mt-3">
            <div class="settings-heading">{{ __('messages.account') }}</div>
            <a href="{{ url('/profile') }}" class="nav-link d-flex align-items-center {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                <span>{{ __('messages.profile') }}</span>
            </a>
            <a href="{{ url('/profile') }}" class="nav-link d-flex align-items-center {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>{{ __('messages.account_settings') }}</span>
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link d-flex align-items-center">
                <i class="bi bi-box-arrow-right"></i>
                <span>{{ __('messages.logout') }}</span>
            </a>
        </div>
    </div>
</aside>
