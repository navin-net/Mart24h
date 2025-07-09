@extends('shop.layouts.app')

@section('title', 'Product List')

@section('content')


    <div class="contact-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">{{__('Product List')}}</h1>
            <p class="lead">We'd love to hear from you. Get in touch with our team.</p>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <!-- Filters -->
            <div class="col-lg-3 mb-4">
                <div class="p-3 border rounded bg-light filter-card">
                    <h5 class="fw-semibold mb-3"><i class="fas fa-filter me-2"></i>Filters</h5>

                    <!-- Categories -->
                    <div class="mb-4">
                        <h6>Categories</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="electronics" value="electronics" data-filter="category">
                            <label class="form-check-label" for="electronics">Electronics</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="clothing" value="clothing" data-filter="category">
                            <label class="form-check-label" for="clothing">Clothing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="home" value="home" data-filter="category">
                            <label class="form-check-label" for="home">Home & Living</label>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <h6>Price Range</h6>
                        <input type="range" class="form-range" min="0" max="2000" id="priceRange" value="2000">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>$0</span><span id="maxPrice">$2000</span>
                        </div>
                    </div>

                    <!-- Colors -->
                    <div class="mb-4">
                        <h6>Colors</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="color-filter rounded-circle border" style="width:25px; height:25px; background:black;" data-color="black" title="Black"></span>
                            <span class="color-filter rounded-circle border" style="width:25px; height:25px; background:red;" data-color="red" title="Red"></span>
                            <span class="color-filter rounded-circle border" style="width:25px; height:25px; background:blue;" data-color="blue" title="Blue"></span>
                            <span class="color-filter rounded-circle border" style="width:25px; height:25px; background:green;" data-color="green" title="Green"></span>
                            <span class="color-filter rounded-circle border" style="width:25px; height:25px; background:white;" data-color="white" title="White"></span>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <h6>Rating</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rating" value="0" id="ratingAll" checked>
                            <label class="form-check-label" for="ratingAll">Show All</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rating" value="4" id="rating4">
                            <label class="form-check-label" for="rating4">★★★★☆ & up</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rating" value="3" id="rating3">
                            <label class="form-check-label" for="rating3">★★★☆☆ & up</label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mb-2" id="applyFilters">Apply Filters</button>
                    <button class="btn btn-outline-secondary w-100" id="clearFilters">Clear All</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted" id="productCount">Showing {{ count($products) }} of {{ count($products) }} products</div>
                    <select class="form-select w-auto" id="sortSelect">
                        <option value="default">Sort by</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                        <option value="newest">Newest</option>
                    </select>
                </div>

                <div class="row g-4" id="productsGrid">
                    @foreach ($products as $product)
                        <div class="col-md-4 col-sm-6 product-item" data-category="{{ $product['category'] ?? 'general' }}" data-price="{{ $product['price'] }}" data-rating="{{ $product['rating'] }}">
                            <div class="card h-100 shadow-sm product-card">
                                <div class="position-relative product-image-container">
                                    <img src="{{ $product['image'] ?? 'https://via.placeholder.com/300x200?text=No+Image' }}" class="card-img-top product-image" alt="{{ $product['name'] }}" onclick="window.location.href='{{ route('shop.productDetail', $product['id']) }}'">

                                    @if ($product['badge'] ?? false)
                                        <span class="badge {{ $product['badge_class'] }} position-absolute top-0 start-0 m-2">{{ $product['badge'] }}</span>
                                    @endif

                                    @if (isset($product['old_price']) && $product['old_price'])
                                        @php
                                            $discount = round((($product['old_price'] - $product['price']) / $product['old_price']) * 100);
                                        @endphp
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ $discount }}%</span>
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

                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($product['description'] ?? 'High quality product with excellent features.', 60) }}
                                    </p>

                                    <div class="mb-2 text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $product['rating'])
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted ms-1">({{ $product['rating'] }}/5)</small>
                                    </div>

                                    <div class="mb-3">
                                        <span class="h5 fw-bold text-primary">${{ number_format($product['price'], 2) }}</span>
                                        @if ($product['old_price'] ?? false)
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled"><span class="page-link">«</span></li>
                            <li class="page-item active"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">
                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart (<span id="cartItemCount">0</span>)
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="cartItems">
                <div class="text-center text-muted py-5">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <p>Your cart is empty</p>
                </div>
            </div>
            <div class="cart-footer mt-auto">
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total: <span id="cartTotal">$0.00</span></strong>
                </div>
                <button class="btn btn-primary w-100 mb-2" id="checkoutBtn">Proceed to Checkout</button>
                <button class="btn btn-outline-primary w-100" data-bs-dismiss="offcanvas">Continue Shopping</button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Product added to cart!
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Product data from PHP
        const allProducts = @json($products);

        // Cart and favorites storage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        // Utility: Render star rating HTML
        function getStarRatingHtml(rating) {
            return [...Array(5)].map((_, i) => `<i class="${i < rating ? 'fas' : 'far'} fa-star"></i>`).join('');
        }

        // Utility: Show toast notification
        function showToast(message, type = 'success') {
            const toastElement = document.getElementById('cartToast');
            const toastMessageElement = document.getElementById('toastMessage');
            const toastHeaderIcon = toastElement.querySelector('.toast-header i');

            toastMessageElement.textContent = message;
            toastHeaderIcon.className = `fas fa-${type === 'success' ? 'check' : 'info'}-circle text-${type} me-2`;

            const toast = window.bootstrap?.Toast || bootstrap.Toast;
            new toast(toastElement).show();
        }

        // Cart: Update cart UI
        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartItemCount = document.getElementById('cartItemCount');
            const cartTotal = document.getElementById('cartTotal');

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>Your cart is empty</p>
                    </div>`;
                cartItemCount.textContent = '0';
                cartTotal.textContent = '$0.00';
                return;
            }

            let total = 0;
            cartItems.innerHTML = cart.map(item => {
                total += item.price * (item.quantity || 1);
                return `
                    <div class="d-flex mb-3 border-bottom pb-3">
                        <img src="${item.image || 'https://via.placeholder.com/50'}" class="me-3" style="width:50px; height:50px; object-fit:cover;" alt="${item.name}">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${item.name}</h6>
                            <p class="mb-0 small text-muted">$${item.price.toFixed(2)} x ${item.quantity || 1}</p>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`;
            }).join('');

            cartItemCount.textContent = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            cartTotal.textContent = `$${total.toFixed(2)}`;
        }

        // Cart: Add to cart
        function addToCart(product) {
            const existing = cart.find(item => item.id === product.id);
            if (existing) {
                existing.quantity = (existing.quantity || 0) + 1;
            } else {
                cart.push({ ...product, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
            showToast(`${product.name} added to cart!`, 'success');
        }

        // Cart: Remove from cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
            showToast('Product removed from cart.', 'success');
        }

        // Favorite: Toggle favorite
        function toggleFavorite(productId) {
            const icon = document.getElementById(`fav-${productId}`);
            if (favorites.includes(productId)) {
                favorites = favorites.filter(id => id !== productId);
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('Removed from favorites.', 'info');
            } else {
                favorites.push(productId);
                icon.classList.remove('far');
                icon.classList.add('fas');
                showToast('Added to favorites!', 'success');
            }
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }

        // Favorite: Initialize favorites
        function initializeFavorites() {
            favorites.forEach(productId => {
                const icon = document.getElementById(`fav-${productId}`);
                if (icon) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                }
            });
        }

        // // Filters: Render products based on filters and sort
        // function applyFiltersAndSort() {
        //     const selectedCategories = Array.from(document.querySelectorAll('input[data-filter="category"]:checked')).map(input => input.value);
        //     const maxPrice = parseFloat(document.getElementById('priceRange').value);
        //     const selectedRating = parseInt(document.querySelector('input[name="rating"]:checked')?.value || 0);
        //     const selectedColor = document.querySelector('.color-filter.selected')?.dataset.color || null;
        //     const sortOption = document.getElementById('sortSelect').value;

        //     let filteredProducts = allProducts.filter(product => {
        //         const categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(product.category);
        //         const priceMatch = product.price <= maxPrice;
        //         const ratingMatch = product.rating >= selectedRating;
        //         return categoryMatch && priceMatch && ratingMatch;
        //     });

        //     // Sort products
        //     filteredProducts.sort((a, b) => {
        //         if (sortOption === 'price-low') return a.price - b.price;
        //         if (sortOption === 'price-high') return b.price - a.price;
        //         if (sortOption === 'rating') return b.rating - a.rating;
        //         if (sortOption === 'newest') return b.id - a.id;
        //         return 0;
        //     });

        //     // Update DOM
        //     const productsGrid = document.getElementById('productsGrid');
        //     productsGrid.innerHTML = '';
        //     filteredProducts.forEach(product => {
        //         const discount = product.old_price ? Math.round(((product.old_price - product.price) / product.old_price) * 100) : null;
        //         productsGrid.innerHTML += `
        //             <div class="col-md-4 col-sm-6 product-item" data-category="${product.category || 'general'}" data-price="${product.price}" data-rating="${product.rating}">
        //                 <div class="card h-100 shadow-sm product-card">
        //                     <div class="position-relative product-image-container">
        //                         <img src="${product.image || 'https://via.placeholder.com/300x200?text=No+Image'}" class="card-img-top product-image" alt="${product.name}" onclick="window.location.href='/product-detail/${product.id}'">
        //                         ${product.badge ? `<span class="badge ${product.badge_class} position-absolute top-0 start-0 m-2">${product.badge}</span>` : ''}
        //                         ${discount ? `<span class="badge bg-danger position-absolute top-0 end-0 m-2">-${discount}%</span>` : ''}
        //                         <div class="product-actions">
        //                             <button class="btn btn-sm btn-light rounded-circle action-btn" onclick="toggleFavorite(${product.id})" title="Toggle Favorite">
        //                                 <i class="${favorites.includes(product.id) ? 'fas' : 'far'} fa-heart favorite-icon" id="fav-${product.id}"></i>
        //                             </button>
        //                             <a href="/product-detail/${product.id}" class="btn btn-sm btn-light rounded-circle action-btn" title="Quick View">
        //                                 <i class="fas fa-eye"></i>
        //                             </a>
        //                         </div>
        //                     </div>
        //                     <div class="card-body d-flex flex-column">
        //                         <h6 class="card-title fw-semibold">
        //                             <a href="/product-detail/${product.id}" class="text-decoration-none text-dark">${product.name}</a>
        //                         </h6>
        //                         <p class="text-muted small mb-2">
        //                             ${product.description ? product.description.slice(0, 60) + (product.description.length > 60 ? '...' : '') : 'High quality product with excellent features.'}
        //                         </p>
        //                         <div class="mb-2 text-warning">
        //                             ${getStarRatingHtml(product.rating)}
        //                             <small class="text-muted ms-1">(${product.rating}/5)</small>
        //                         </div>
        //                         <div class="mb-3">
        //                             <span class="h5 fw-bold text-primary">$${product.price.toFixed(2)}</span>
        //                             ${product.old_price ? `<del class="text-muted small ms-2">$${product.old_price.toFixed(2)}</del>` : ''}
        //                         </div>
        //                         <div class="mt-auto d-flex gap-2">
        //                             <button class="btn btn-primary flex-fill" onclick="addToCart(${JSON.stringify(product).replace(/"/g, '&quot;')})">
        //                                 <i class="fas fa-shopping-cart me-2"></i>Add to Cart
        //                             </button>
        //                             <a href="/product-detail/${product.id}" class="btn btn-outline-secondary">
        //                                 <i class="fas fa-info-circle"></i>
        //                             </a>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>`;
        //     });

        //     // Update product count
        //     document.getElementById('productCount').textContent = `Showing ${filteredProducts.length} of ${allProducts.length} products`;
        // }

        // // Event Listeners
        // document.addEventListener('DOMContentLoaded', () => {
        //     // Initialize cart and favorites
        //     updateCart();
        //     initializeFavorites();

        //     // Price range
        //     document.getElementById('priceRange').addEventListener('input', (e) => {
        //         document.getElementById('maxPrice').textContent = `$${e.target.value}`;
        //     });

        //     // Apply filters
        //     document.getElementById('applyFilters').addEventListener('click', applyFiltersAndSort);

        //     // Clear filters
        //     document.getElementById('clearFilters').addEventListener('click', () => {
        //         document.querySelectorAll('input[data-filter="category"]').forEach(input => input.checked = false);
        //         document.querySelectorAll('input[name="rating"]').forEach(radio => radio.checked = false);
        //         document.getElementById('ratingAll').checked = true;
        //         document.getElementById('priceRange').value = '2000';
        //         document.getElementById('maxPrice').textContent = '$2000';
        //         document.getElementById('sortSelect').value = 'default';
        //         document.querySelectorAll('.color-filter').forEach(span => span.classList.remove('selected'));
        //         applyFiltersAndSort();
        //     });

        //     // Sort select
        //     document.getElementById('sortSelect').addEventListener('change', applyFiltersAndSort);

        //     // Color filters
        //     document.querySelectorAll('.color-filter').forEach(span => {
        //         span.addEventListener('click', () => {
        //             const isSelected = span.classList.contains('selected');
        //             document.querySelectorAll('.color-filter').forEach(s => s.classList.remove('selected'));
        //             if (!isSelected) {
        //                 span.classList.add('selected');
        //             }
        //             applyFiltersAndSort();
        //         });
        //     });

        //     // Category and rating filters
        //     document.querySelectorAll('input[data-filter], input[name="rating"]').forEach(input => {
        //         input.addEventListener('change', applyFiltersAndSort);
        //     });
        // });
    </script>
@endpush