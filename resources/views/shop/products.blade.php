@extends('shop.layouts.app')

@section('title', $shopDetail->name . ' - ' . __('messages.products'))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="filter-sidebar p-3 border rounded bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="filter-title mb-0 fw-semibold"><i class="fas fa-filter me-2"></i>Filters</h5>
                        {{-- Added clear all filters button in header --}}
                        <a href="{{ route('shop.products') }}" class="btn btn-sm btn-outline-secondary" title="Clear all filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <form id="filterForm" action="{{ route('shop.products') }}" method="GET">
                        {{-- Improved categories section with better accessibility --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Categories</h6>
                            @foreach ($categories as $name => $category)
                                <div class="filter-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category }}"
                                            id="category-{{ \Illuminate\Support\Str::slug($category) }}"
                                            {{ in_array($category, request()->input('category', [])) ? 'checked' : '' }}
                                            onchange="submitFormWithDelay();"
                                            aria-describedby="category-help">
                                        <label class="form-check-label" for="category-{{ \Illuminate\Support\Str::slug($category) }}">{{ ucfirst($category) }}</label>
                                    </div>
                                </div>
                            @endforeach
                            <small id="category-help" class="form-text text-muted">Select one or more categories</small>
                        </div>

                        {{-- Fixed brand image paths and improved error handling --}}
                        <div class="filter-group mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="filter-group-title fw-semibold mb-0">Brands</h6>
                                
                                <div class="btn-group btn-group-sm" role="group" aria-label="Brand view options">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="switchBrandView('dropdown')" id="dropdownViewBtn"
                                            aria-pressed="false">
                                        <i class="fas fa-list me-1"></i>List
                                    </button>
                                    <button type="button" class="btn btn-secondary" 
                                            onclick="switchBrandView('grid')" id="gridViewBtn"
                                            aria-pressed="true">
                                        <i class="fas fa-th me-1"></i>Grid
                                    </button>
                                </div>
                            </div>
                            
                            <div class="brand-dropdown-container" id="brandDropdownView" style="display: none;">
                                <button type="button" class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center" 
                                        id="brandDropdownToggle" onclick="toggleBrandDropdown()"
                                        aria-expanded="false" aria-haspopup="true">
                                    <span id="brandDropdownText">
                                        @if(request()->filled('brand'))
                                            {{ count(request()->input('brand', [])) }} brand(s) selected
                                        @else
                                            Select brands
                                        @endif
                                    </span>
                                    <i class="fas fa-chevron-down transition-all" id="brandDropdownIcon"></i>
                                </button>
                                
                                <div class="brand-dropdown-menu position-absolute w-100 bg-white border rounded shadow-sm mt-1 d-none" 
                                     id="brandDropdownMenu" style="z-index: 1000; max-height: 300px; overflow-y: auto;"
                                     role="listbox" aria-label="Brand selection">
                                    @foreach ($brands as $brand)
                                        <div class="brand-option p-2 d-flex align-items-center" 
                                             onclick="toggleBrandSelection('{{ $brand->name }}', this)"
                                             role="option" tabindex="0"
                                             onkeypress="if(event.key==='Enter'||event.key===' ') toggleBrandSelection('{{ $brand->name }}', this)">
                                            <input type="checkbox" name="brand[]" value="{{ $brand->name }}" 
                                                   class="form-check-input me-2 brand-checkbox" 
                                                   id="brand-dropdown-{{ \Illuminate\Support\Str::slug($brand->name) }}"
                                                   {{ in_array($brand->name, request()->input('brand', [])) ? 'checked' : '' }}>
                                            
                                            {{-- Standardized image path and improved fallback --}}
                                            <img src="{{ asset('upload/image/' . strtolower($brand->image)) }}" 
                                                 alt="{{ $brand->name }} logo" class="brand-logo me-2" 
                                                 style="width: 24px; height: 24px; object-fit: contain;"
                                                 onerror="this.src='{{ asset('images/placeholder-brand.svg') }}'; this.onerror=null;">
                                            
                                            <label class="form-check-label mb-0 flex-grow-1 cursor-pointer" 
                                                   for="brand-dropdown-{{ \Illuminate\Support\Str::slug($brand->name) }}">
                                                {{ ucfirst($brand->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="brand-grid d-flex flex-wrap gap-2" id="brandGridView">
                                @foreach ($brands as $brand)
                                    <div class="brand-card border rounded-3 p-3 text-center position-relative {{ in_array($brand->name, request()->input('brand', [])) ? 'border-primary bg-primary bg-opacity-10' : 'border-light' }}" 
                                         style="width: 90px; cursor: pointer; transition: all 0.3s ease;" 
                                         onclick="toggleBrandCard(this, '{{ $brand->name }}')"
                                         role="button" tabindex="0" aria-pressed="{{ in_array($brand->name, request()->input('brand', [])) ? 'true' : 'false' }}"
                                         onkeypress="if(event.key==='Enter'||event.key===' ') toggleBrandCard(this, '{{ $brand->name }}')">
                                        
                                        <input type="checkbox" name="brand[]" value="{{ $brand->name }}" 
                                               class="form-check-input position-absolute brand-grid-checkbox d-none" 
                                               id="brand-grid-{{ \Illuminate\Support\Str::slug($brand->name) }}"
                                               {{ in_array($brand->name, request()->input('brand', [])) ? 'checked' : '' }}>
                                        
                                        {{-- Consistent image path and better error handling --}}
                                        <img src="{{ asset('upload/image/' . strtolower($brand->image)) }}" 
                                             alt="{{ $brand->name }} logo" class="brand-logo-large mb-2" 
                                             style="width: 40px; height: 40px; object-fit: contain; transition: transform 0.2s ease;"
                                             onerror="this.src='{{ asset('images/placeholder-brand.svg') }}'; this.onerror=null;">
                                        
                                        <small class="d-block text-truncate fw-medium">{{ ucfirst($brand->name) }}</small>
                                        
                                        <div class="selection-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-3 {{ in_array($brand->name, request()->input('brand', [])) ? '' : 'd-none' }}" 
                                             style="background: rgba(13, 110, 253, 0.15); backdrop-filter: blur(1px);">
                                            <i class="fas fa-check-circle text-primary" style="font-size: 1.5rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(request()->filled('brand'))
                                <div class="mt-3 p-2 bg-light rounded-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-filter text-primary me-2"></i>
                                        <small class="fw-semibold text-muted">Selected Brands ({{ count(request()->input('brand', [])) }})</small>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach (request()->input('brand', []) as $brand)
                                            <span class="badge bg-primary d-inline-flex align-items-center py-1 px-2">
                                                {{-- Fixed image path consistency --}}
                                                <img src="{{ asset('upload/image/' . strtolower($brand) . '.png') }}" 
                                                     alt="{{ $brand }}" class="me-1" 
                                                     style="width: 14px; height: 14px; object-fit: contain;"
                                                     onerror="this.style.display='none'">
                                                {{ ucfirst($brand) }}
                                                <button type="button" class="btn-close btn-close-white ms-1" 
                                                        style="font-size: 0.6em;" 
                                                        onclick="removeBrandFilter('{{ $brand }}')"
                                                        title="Remove {{ $brand }}"
                                                        aria-label="Remove {{ $brand }} filter"></button>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Improved price range with better UX --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Price Range</h6>
                            <div class="price-slider">
                                <input type="range" class="form-range" min="0" max="15000" step="10"
                                name="max_price" id="priceRange" value="{{ request()->input('max_price', 15000) }}" 
                                oninput="updatePriceDisplay(this.value)"
                                onchange="submitFormWithDelay()"
                                aria-describedby="price-help">
                                <div class="d-flex justify-content-between mt-2 small text-muted">
                                    <span>$0</span>
                                    <span id="maxPrice" class="fw-semibold text-primary">${{ number_format(request()->input('max_price',15000), 0) }}</span>
                                    <span>$15,000</span>
                                </div>
                                <small id="price-help" class="form-text text-muted">Drag to set maximum price</small>
                            </div>
                        </div>

                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Colors</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($colors as $color)
                                    {{-- The 'active' class and check-icon display are initially set by Blade --}}
                                    <span class="color-option rounded-circle border {{ in_array($color, request()->input('color', [])) ? 'active' : '' }}"
                                        style="width: 30px; height: 30px; background: {{ $color }}; cursor: pointer; position: relative;"
                                        data-color="{{ $color }}"
                                        title="{{ ucfirst($color) }}"
                                        onclick="toggleColorFilter(this, '{{ $color }}')">
                                        <span class="check-icon position-absolute top-50 start-50 translate-middle"
                                            style="display: {{ in_array($color, request()->input('color', [])) ? 'block' : 'none' }};">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-check" viewBox="0 0 16 16">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                            </svg>
                                        </span>
                                    </span>
                                @endforeach
                            </div>
                            <div id="selected-colors">
                                {{-- These hidden inputs are initially rendered by Blade based on the current request.
                                    They will be *removed* by JS and re-added based on the currently selected colors.--}}
                                {{-- @foreach (request()->input('color', []) as $color)
                                    <input type="hidden" name="color[]" value="{{ $color }}" data-color="{{ $color }}">
                                @endforeach --}}
                                {{-- We will let JS manage ALL hidden color inputs after initial load --}}
                            </div>
                            @if(request()->filled('color'))
                                <div class="mt-2 small">
                                    <strong>Selected:</strong>
                                    @foreach (request()->input('color', []) as $color)
                                        <span class="badge bg-secondary me-1">{{ ucfirst($color) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Rating</h6>
                            <div class="filter-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="0" id="ratingAll"
                                        {{ !request()->has('rating') || request()->input('rating') == '0' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit();">
                                    <label class="form-check-label" for="ratingAll">Show All</label>
                                </div>
                            </div>
                            @for ($i = 4; $i >= 3; $i--)
                                <div class="filter-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}"
                                            {{ request()->input('rating') == $i ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit();">
                                        <label class="form-check-label" for="rating{{ $i }}">
                                            @for ($j = 1; $j <= 5; $j++)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="{{ $j <= $i ? 'text-warning' : 'text-secondary' }} bi bi-star{{ $j <= $i ? '-fill' : '' }}"
                                                    viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                </svg>
                                            @endfor
                                            <span class="ms-1">& up</span>
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        {{-- Improved availability section --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Availability</h6>
                            <div class="filter-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="in_stock" id="inStock"
                                        {{ in_array('in_stock', request()->input('availability', [])) ? 'checked' : '' }} 
                                        onchange="submitFormWithDelay();">
                                    <label class="form-check-label" for="inStock">
                                        <i class="fas fa-check-circle text-success me-1"></i>In Stock
                                    </label>
                                </div>
                            </div>
                            <div class="filter-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="out_of_stock" id="outOfStock"
                                        {{ in_array('out_of_stock', request()->input('availability', [])) ? 'checked' : '' }}
                                        onchange="submitFormWithDelay();">
                                    <label class="form-check-label" for="outOfStock">
                                        <i class="fas fa-times-circle text-danger me-1"></i>Out of Stock
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="sort" value="{{ request()->input('sort', 'default') }}">

                        {{-- Improved filter action buttons --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="applyFiltersBtn">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh me-2"></i>Clear All Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
                    </div>
                    <form id="sortForm" action="{{ route('shop.products') }}" method="GET">
                        <select class="form-select w-auto" name="sort" onchange="this.form.submit()">
                            <option value="default" {{ request()->input('sort') == 'default' ? 'selected' : '' }}>Sort by</option>
                            <option value="price-low" {{ request()->input('sort') == 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price-high" {{ request()->input('sort') == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request()->input('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="newest" {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                        @foreach (request()->except(['sort', 'page']) as $key => $value)
                            @if (is_array($value) && !empty($value))
                                @foreach ($value as $item)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                @endforeach
                            @elseif (!is_array($value) && !is_null($value))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                    </form>
                </div>

                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm product-card">
                                <div class="position-relative product-image-container">
                                    <img src="{{ $product['image'] }}" class="card-img-top product-image" alt="{{ $product['name'] }}"
                                        onclick="window.location.href='{{ route('shop.productDetail', $product['id']) }}'">
                                    @if (isset($product['badge']) && $product['badge'])
                                        <span class="badge {{ $product['badge_class'] ?? 'bg-info' }} position-absolute top-0 start-0 m-2">{{ $product['badge'] }}</span>
                                    @endif
                                    @if (isset($product['old_price']) && $product['old_price'])
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}% Off</span>
                                    @endif
                                    <div class="product-actions">
                                        <button class="btn btn-sm btn-light rounded-circle action-btn" onclick="toggleFavorite({{ $product['id'] }})" title="Add to Favorites">
                                            <i class="far fa-heart favorite-icon" id="fav-{{ $product['id'] }}"></i>
                                        </button>
                                        <a href="{{ route('shop.productDetail', $product['id']) }}" class="btn btn-sm btn-light rounded-circle action-btn" title="Quick View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-semibold">
                                        <a href="{{ route('shop.productDetail', $product['id']) }}" class="text-decoration-none text-dark">{{ $product['name'] }}</a>
                                    </h6>
                                    <!-- <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($product['description'], 60) }}</p> -->
                                    <div class="mb-2 text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $product['rating'] ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                        <small class="text-muted ms-1">({{ $product['rating'] }}/5)</small>
                                    </div>
                                    <div class="mb-3">
                                        <span class="h5 fw-bold text-primary">${{ number_format($product['price'], 2) }}</span>
                                        @if (isset($product['old_price']) && $product['old_price'])
                                            <del class="text-muted small ms-2">${{ number_format($product['old_price'], 2) }}</del>
                                        @endif
                                    </div>
                                    <div class="mt-auto d-flex gap-2">
                                        <button class="btn btn-primary flex-fill add-to-cart-btn" onclick="addToCart({{ json_encode($product) }})">
                                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                        </button>
                                        <a href="{{ route('shop.productDetail', $product['id']) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@push('style')
<style>
    .brand-option {
    cursor: pointer;
    transition: background-color 0.2s ease;
    border-radius: 0.375rem;
    margin: 2px;
}

.brand-option:hover {
    background-color: #f8f9fa !important;
}

.brand-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.brand-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.brand-card:hover .brand-logo-large {
    transform: scale(1.1) !important;
}

.selection-overlay {
    transition: all 0.3s ease;
}

.cursor-pointer {
    cursor: pointer;
}

.transition-all {
    transition: all 0.2s ease;
}

#brandDropdownIcon {
    transition: transform 0.2s ease;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.badge {
    transition: all 0.2s ease;
}

.badge:hover {
    transform: scale(1.05);
}
</style>
@endpush

    @push('scripts')
        <script>
            // Price range slider update
            const priceRange = document.getElementById('priceRange');
            const maxPrice = document.getElementById('maxPrice');
            if (priceRange && maxPrice) {
                priceRange.addEventListener('input', function () {
                    maxPrice.textContent = '$' + this.value;
                });
            }

            // Global array to keep track of selected colors
            let selectedColors = [];

            // Initialize selectedColors array from URL parameters on page load
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const colorsFromUrl = urlParams.getAll('color[]'); // Get all instances of 'color[]'
                selectedColors = [...new Set(colorsFromUrl)]; // Ensure uniqueness

                // Visually update color options based on selectedColors
                document.querySelectorAll('.color-option').forEach(optionElement => {
                    const colorValue = optionElement.dataset.color;
                    const checkIcon = optionElement.querySelector('.check-icon');

                    if (selectedColors.includes(colorValue)) {
                        optionElement.classList.add('active');
                        if (checkIcon) checkIcon.style.display = 'block';
                    } else {
                        optionElement.classList.remove('active');
                        if (checkIcon) checkIcon.style.display = 'none';
                    }
                });

                // Set initial price range display
                if (priceRange && maxPrice) {
                    maxPrice.textContent = '$' + priceRange.value;
                }
            });

            // Toggle color filter
            function toggleColorFilter(element, color) {
                const selectedColorsDiv = document.getElementById('selected-colors');
                const checkIcon = element.querySelector('.check-icon');

                if (element.classList.contains('active')) {
                    // Deactivate color: remove from array and update visual
                    element.classList.remove('active');
                    if (checkIcon) checkIcon.style.display = 'none';
                    selectedColors = selectedColors.filter(c => c !== color); // Remove this color
                } else {
                    // Activate color: add to array and update visual
                    element.classList.add('active');
                    if (checkIcon) checkIcon.style.display = 'block';
                    if (!selectedColors.includes(color)) { // Prevent adding duplicate to array
                        selectedColors.push(color);
                    }
                }

                // Clear all existing hidden color inputs from the DOM
                selectedColorsDiv.innerHTML = '';

                // Add hidden inputs for all currently selected colors
                selectedColors.forEach(c => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'color[]';
                    input.value = c;
                    input.dataset.color = c; // For consistency, though not strictly needed here anymore
                    selectedColorsDiv.appendChild(input);
                });

                // Auto-submit form to update filters immediately
                document.getElementById('filterForm').submit();
            }


let isSubmitting = false;

function toggleBrandDropdown() {
    const menu = document.getElementById('brandDropdownMenu');
    const icon = document.getElementById('brandDropdownIcon');
    
    menu.classList.toggle('d-none');
    icon.classList.toggle('fa-chevron-down');
    icon.classList.toggle('fa-chevron-up');
}

function toggleBrandSelection(brandName, element) {
    if (isSubmitting) return;
    
    const checkbox = element.querySelector('.brand-checkbox');
    checkbox.checked = !checkbox.checked;
    
    updateBrandDropdownText();
    submitFormWithDelay();
}

function toggleBrandCard(cardElement, brandName) {
    if (isSubmitting) return;
    
    const checkbox = cardElement.querySelector('.brand-grid-checkbox');
    const overlay = cardElement.querySelector('.selection-overlay');
    const img = cardElement.querySelector('.brand-logo-large');
    
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        cardElement.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        cardElement.classList.remove('border-light');
        overlay.classList.remove('d-none');
        img.style.transform = 'scale(1.1)';
    } else {
        cardElement.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        cardElement.classList.add('border-light');
        overlay.classList.add('d-none');
        img.style.transform = 'scale(1)';
    }
    
    submitFormWithDelay();
}

function updateBrandDropdownText() {
    const checkedBoxes = document.querySelectorAll('.brand-checkbox:checked');
    const dropdownText = document.getElementById('brandDropdownText');
    
    dropdownText.textContent = checkedBoxes.length === 0 ? 
        'Select brands' : `${checkedBoxes.length} brand(s) selected`;
}

function removeBrandFilter(brandName) {
    if (isSubmitting) return;
    
    const checkboxes = document.querySelectorAll(`input[name="brand[]"][value="${brandName}"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
        
        const card = checkbox.closest('.brand-card');
        if (card) {
            card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
            card.classList.add('border-light');
            const overlay = card.querySelector('.selection-overlay');
            const img = card.querySelector('.brand-logo-large');
            if (overlay) overlay.classList.add('d-none');
            if (img) img.style.transform = 'scale(1)';
        }
    });
    
    updateBrandDropdownText();
    submitFormWithDelay();
}

function switchBrandView(viewType) {
    const dropdownBtn = document.getElementById('dropdownViewBtn');
    const gridBtn = document.getElementById('gridViewBtn');
    const dropdownView = document.getElementById('brandDropdownView');
    const gridView = document.getElementById('brandGridView');
    
    if (viewType === 'dropdown') {
        dropdownBtn.classList.remove('btn-outline-secondary');
        dropdownBtn.classList.add('btn-secondary');
        gridBtn.classList.remove('btn-secondary');
        gridBtn.classList.add('btn-outline-secondary');
        
        dropdownView.style.display = 'block';
        gridView.style.display = 'none';
    } else {
        gridBtn.classList.remove('btn-outline-secondary');
        gridBtn.classList.add('btn-secondary');
        dropdownBtn.classList.remove('btn-secondary');
        dropdownBtn.classList.add('btn-outline-secondary');
        
        dropdownView.style.display = 'none';
        gridView.style.display = 'flex';
    }
    
    localStorage.setItem('brandViewPreference', viewType);
}

function submitFormWithDelay() {
    if (isSubmitting) return;
    
    isSubmitting = true;
    setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 300);
}

// Event listeners
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('brandDropdownToggle');
    const menu = document.getElementById('brandDropdownMenu');
    
    if (dropdown && menu && !dropdown.contains(event.target) && !menu.contains(event.target)) {
        menu.classList.add('d-none');
        const icon = document.getElementById('brandDropdownIcon');
        if (icon) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    updateBrandDropdownText();
    
    const savedView = localStorage.getItem('brandViewPreference') || 'grid';
    switchBrandView(savedView);
});
        </script>
    @endpush
@endsection
