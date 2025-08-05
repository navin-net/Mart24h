@extends('shop.layouts.app')

@section('title', $shopDetail->name . ' - ' . __('messages.products'))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="filter-sidebar p-3 border rounded bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="filter-title mb-0 fw-semibold"><i class="fas fa-filter me-2"></i>Filters</h5>
                    </div>

                    <form id="filterForm" action="{{ route('shop.products') }}" method="GET">
                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Categories</h6>
                            @foreach ($categories as $name => $category)
                                <div class="filter-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category }}"
                                            id="category-{{ \Illuminate\Support\Str::slug($category) }}"
                                            {{ in_array($category, request()->input('category', [])) ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit();">
                                        <label class="form-check-label" for="category-{{ \Illuminate\Support\Str::slug($category) }}">{{ ucfirst($category) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Brands</h6>
                            @foreach ($brands as $brand)
                                <div class="filter-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" value="{{ $brand->name }}"
                                            id="brand-{{ \Illuminate\Support\Str::slug($brand->name) }}"
                                            {{ in_array($brand->name, request()->input('brand', [])) ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit();">
                                        <label class="form-check-label" for="brand-{{ \Illuminate\Support\Str::slug($brand->name) }}">{{ ucfirst($brand->name) }}</label>
                                    </div>
                                </div>
                            @endforeach
                            @if(request()->filled('brand'))
                                <div class="mt-2 small">
                                    <strong>Selected Brands:</strong>
                                    @foreach (request()->input('brand', []) as $brand)
                                        <span class="badge bg-secondary me-1">{{ ucfirst($brand) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Price Range</h6>
                            <div class="price-slider">
                                <input type="range" class="form-range" min="0" max="2000" step="10"
                                       name="max_price" id="priceRange"
                                       value="{{ request()->input('max_price', 2000) }}"
                                       onmouseup="document.getElementById('filterForm').submit();"
                                       onchange="document.getElementById('filterForm').submit();">
                                <div class="d-flex justify-content-between mt-2 small text-muted">
                                    <span>$0</span>
                                    <span id="maxPrice">${{ number_format(request()->input('max_price', 2000), 0) }}</span>
                                    <span>$2000</span>
                                </div>
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
                                           {{ !request()->has('rating') || request()->input('rating') == '0' ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit();">
                                    <label class="form-check-label" for="ratingAll">Show All</label>
                                </div>
                            </div>
                            @for ($i = 4; $i >= 3; $i--)
                                <div class="filter-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}"
                                               {{ request()->input('rating') == $i ? 'checked' : '' }}
                                               onchange="document.getElementById('filterForm').submit();">
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

                        <div class="filter-group mb-4">
                            <h6 class="filter-group-title fw-semibold">Availability</h6>
                            <div class="filter-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="in_stock" id="inStock"
                                           {{ in_array('in_stock', request()->input('availability', [])) ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit();">
                                    <label class="form-check-label" for="inStock">In Stock</label>
                                </div>
                            </div>
                            <div class="filter-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="out_of_stock" id="outOfStock"
                                           {{ in_array('out_of_stock', request()->input('availability', [])) ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit();">
                                    <label class="form-check-label" for="outOfStock">Out of Stock</label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="sort" value="{{ request()->input('sort', 'default') }}">

                        <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                        <a href="{{ route('shop.products') }}" class="btn btn-secondary w-100 mt-3">Clear All</a>
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
                                    <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($product['description'], 60) }}</p>
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
        </script>
    @endpush
@endsection