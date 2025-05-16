@extends('shop.layouts.app')

@section('title','content'))

@section('content')

    <!-- Hero Section -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active hero-section" style="background-image: url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content col-md-6">
                        <h1 class="display-4 fw-bold">Summer Collection 2023</h1>
                        <p class="lead">Discover the latest trends and styles for the summer season.</p>
                        <button class="btn btn-primary btn-lg mt-3">Shop Now</button>
                    </div>
                </div>
            </div>
            <div class="carousel-item hero-section" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content col-md-6">
                        <h1 class="display-4 fw-bold">New Arrivals</h1>
                        <p class="lead">Check out our latest products and exclusive deals.</p>
                        <button class="btn btn-primary btn-lg mt-3">Explore</button>
                    </div>
                </div>
            </div>
            <div class="carousel-item hero-section" style="background-image: url('https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80');">
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content col-md-6">
                        <h1 class="display-4 fw-bold">Special Offers</h1>
                        <p class="lead">Up to 50% off on selected items. Limited time only!</p>
                        <button class="btn btn-primary btn-lg mt-3">View Offers</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <section class="py-5" id="categories">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-2" data-aos="fade-up">Shop by Category</h2>
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Browse our wide range of products
                        by category</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                            alt="Clothing">
                        <div class="category-overlay">
                            <h3>Clothing</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2025&q=80"
                            alt="Shoes">
                        <div class="category-overlay">
                            <h3>Shoes</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1523293182086-7651a899d37f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2025&q=80"
                            alt="Accessories">
                        <div class="category-overlay">
                            <h3>Accessories</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5 bg-light" id="products">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-2" data-aos="fade-up">Our Products</h2>
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Discover our wide range of
                        high-quality products</p>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-center flex-wrap gap-2" data-aos="fade-up"
                    data-aos-delay="200">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="clothing">Clothing</button>
                    <button class="filter-btn" data-filter="shoes">Shoes</button>
                    <button class="filter-btn" data-filter="accessories">Accessories</button>
                    <button class="filter-btn" data-filter="sale">On Sale</button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=705&q=80"
                                alt="Summer T-Shirt">
                            <span class="product-badge new">New</span>
                            <div class="product-actions">
                                <div class="action-btn" data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="action-btn add-to-wishlist">
                                    <i class="far fa-heart"></i>
                                </div>
                                <div class="action-btn add-to-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Summer T-Shirt</h3>
                            <p class="product-category">Clothing</p>
                            <div class="product-price">
                                <span class="current-price">$29.99</span>
                            </div>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="rating-count">(42)</span>
                            </div>
                            <button class="btn btn-primary-custom w-100 add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-3 product-item" data-category="shoes" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                alt="Running Shoes">
                            <div class="product-actions">
                                <div class="action-btn" data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="action-btn add-to-wishlist">
                                    <i class="far fa-heart"></i>
                                </div>
                                <div class="action-btn add-to-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Running Shoes</h3>
                            <p class="product-category">Shoes</p>
                            <div class="product-price">
                                <span class="current-price">$89.99</span>
                            </div>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-count">(28)</span>
                            </div>
                            <button class="btn btn-primary-custom w-100 add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-3 product-item" data-category="accessories sale" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1523206489230-c012c64b2b48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                                alt="Smart Watch">
                            <span class="product-badge sale">Sale</span>
                            <div class="product-actions">
                                <div class="action-btn" data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="action-btn add-to-wishlist">
                                    <i class="far fa-heart"></i>
                                </div>
                                <div class="action-btn add-to-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Smart Watch</h3>
                            <p class="product-category">Accessories</p>
                            <div class="product-price">
                                <span class="current-price">$149.99</span>
                                <span class="old-price">$199.99</span>
                            </div>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count">(56)</span>
                            </div>
                            <button class="btn btn-primary-custom w-100 add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up"
                    data-aos-delay="400">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=736&q=80"
                                alt="Casual Jacket">
                            <div class="product-actions">
                                <div class="action-btn" data-bs-toggle="modal" data-bs-target="#productModal">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="action-btn add-to-wishlist">
                                    <i class="far fa-heart"></i>
                                </div>
                                <div class="action-btn add-to-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Casual Jacket</h3>
                            <p class="product-category">Clothing</p>
                            <div class="product-price">
                                <span class="current-price">$79.99</span>
                            </div>
                            <div class="product-rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-count">(19)</span>
                            </div>
                            <button class="btn btn-primary-custom w-100 add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-primary-custom btn-lg">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Featured Product Section -->
    <section class="py-5" id="featured">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-2" data-aos="fade-up">Featured Product</h2>
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Check out our featured product of
                        the month</p>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="featured-product">
                        <div class="featured-product-img">
                            <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80"
                                alt="Premium Leather Jacket">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="featured-product-info">
                        <h3 class="featured-product-title">Premium Leather Jacket</h3>
                        <div class="product-rating mb-3">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(78 reviews)</span>
                        </div>
                        <div class="product-price mb-4">
                            <span class="current-price">$199.99</span>
                            <span class="old-price">$249.99</span>
                        </div>
                        <p class="featured-product-desc">This premium leather jacket is crafted from the finest
                            materials for ultimate comfort and style. Perfect for any occasion, it features a sleek
                            design, durable construction, and a comfortable fit. Available in multiple sizes and colors.
                        </p>

                        <div class="product-colors mb-4">
                            <h5 class="color-title">Colors:</h5>
                            <div class="color-options">
                                <div class="color-option active" style="background-color: #1a1a1a;"></div>
                                <div class="color-option" style="background-color: #7b3f00;"></div>
                                <div class="color-option" style="background-color: #8b0000;"></div>
                            </div>
                        </div>

                        <div class="product-sizes mb-4">
                            <h5 class="size-title">Sizes:</h5>
                            <div class="size-options">
                                <div class="size-option">S</div>
                                <div class="size-option active">M</div>
                                <div class="size-option">L</div>
                                <div class="size-option">XL</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="input-group quantity-input me-3">
                                <button class="btn btn-outline-secondary" type="button"
                                    id="decrementQuantity">-</button>
                                <input type="text" class="form-control text-center" value="1"
                                    id="productQuantity">
                                <button class="btn btn-outline-secondary" type="button"
                                    id="incrementQuantity">+</button>
                            </div>
                            <button class="btn btn-primary-custom flex-grow-1 add-to-cart-btn">Add to Cart</button>
                        </div>

                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary-custom me-3"><i class="far fa-heart me-2"></i> Add
                                to Wishlist</button>
                            <button class="btn btn-outline-primary-custom"><i class="fas fa-share-alt me-2"></i>
                                Share</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3" data-aos="fade-up">Subscribe to Our Newsletter</h2>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Get the latest updates, offers and
                        special announcements delivered directly to your inbox.</p>
                    <form class="newsletter-form" data-aos="fade-up" data-aos-delay="200">
                        <div class="input-group">
                            <input type="email" class="form-control newsletter-input"
                                placeholder="Enter your email">
                            <button class="btn newsletter-btn" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection
