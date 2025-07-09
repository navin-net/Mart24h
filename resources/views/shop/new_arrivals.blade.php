@extends('shop.layouts.app')
@section('title', 'New Arrivals')
@section('content')
@push('style')
<style>
    .countdown-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 0.8rem;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .product-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        animation: slideInUp 0.8s ease-out;
        animation-fill-mode: both;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .product-card:nth-child(2) { animation-delay: 0.1s; }
    .product-card:nth-child(3) { animation-delay: 0.2s; }
    .product-card:nth-child(4) { animation-delay: 0.3s; }
    .product-card:nth-child(5) { animation-delay: 0.4s; }
    .product-card:nth-child(6) { animation-delay: 0.5s; }
    .product-card:nth-child(7) { animation-delay: 0.6s; }
    .product-card:nth-child(8) { animation-delay: 0.7s; }

    .product-img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .product-title { font-weight: 600; margin-bottom: 0.5rem; color: #212529; }
    .product-price { font-weight: 700; color: #3a86ff; margin-bottom: 0.5rem; }
    .product-original-price { text-decoration: line-through; color: #6c757d; font-size: 0.9rem; }
    .product-discount { color: #ff3a5e; font-weight: 600; font-size: 0.9rem; }
    .product-rating { color: #ffc107; margin-bottom: 0.75rem; }
    .product-rating-count { color: #6c757d; font-size: 0.8rem; }

    /* Redesigned Featured New Arrival section */
    .featured-new {
        background: linear-gradient(to right, #f0f7ff 0%, #f0f7ff 50%, #e6f0ff 50%, #e6f0ff 100%);
        border-radius: 15px;
        margin-bottom: 3rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(58, 134, 255, 0.1);
        position: relative;
    }

    .featured-new::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(58, 134, 255, 0.1);
        z-index: 0;
    }

    .featured-new::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 58, 94, 0.1);
        z-index: 0;
    }

    .featured-new-img-container {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        z-index: 1;
    }

    .featured-new-img {
        max-height: 350px;
        object-fit: contain;
        animation: float 6s ease-in-out infinite;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        transition: all 0.5s ease;
    }

    .featured-new-img:hover {
        transform: scale(1.05);
    }

    .featured-new-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 3rem 2rem;
        position: relative;
        z-index: 1;
        animation: slideInRight 0.8s ease-out;
    }

    .featured-badge {
        display: inline-block;
        background: linear-gradient(135deg, #ff3a5e 0%, #ff6b3d 100%);
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(255, 58, 94, 0.3);
        animation: pulse 2s infinite;
    }

    .featured-new-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #3a86ff 0%, #2a75e0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
    }

    .featured-new-desc { margin-bottom: 1.5rem; color: #495057; font-size: 1.1rem; line-height: 1.6; }
    .featured-new-price { font-size: 2rem; font-weight: 800; color: #3a86ff; margin-bottom: 1.5rem; display: flex; align-items: center; }
    .featured-new-original-price { text-decoration: line-through; color: #6c757d; font-size: 1.2rem; font-weight: 400; margin-left: 1rem; }
    .featured-new-discount { background-color: #ff3a5e; color: white; font-size: 0.9rem; font-weight: 700; padding: 0.3rem 0.8rem; border-radius: 20px; margin-left: 1rem; }
    .featured-new-specs { display: flex; flex-wrap: wrap; margin-bottom: 1.5rem; gap: 1rem; }
    .spec-item { display: flex; align-items: center; background-color: white; padding: 0.5rem 1rem; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); font-size: 0.9rem; font-weight: 500; color: #495057; }
    .spec-item i { color: #3a86ff; margin-right: 0.5rem; }
    .featured-new-actions { display: flex; gap: 1rem; margin-top: 1rem; }
    .btn-shop-now { padding: 0.8rem 2rem; font-weight: 600; border-radius: 30px; box-shadow: 0 5px 15px rgba(58, 134, 255, 0.3); transition: all 0.3s ease; }
    .btn-shop-now:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(58, 134, 255, 0.4); }
    .btn-wishlist { padding: 0.8rem 1.5rem; font-weight: 600; border-radius: 30px; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; }
    .btn-wishlist:hover { background-color: #f0f7ff; color: #3a86ff; border-color: #3a86ff; }
    .featured-new-timer { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .timer-item { display: flex; flex-direction: column; align-items: center; background: white; padding: 0.8rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); min-width: 70px; }
    .timer-number { font-size: 1.5rem; font-weight: 700; color: #3a86ff; }
    .timer-label { font-size: 0.8rem; color: #6c757d; text-transform: uppercase; }
    .timer-title { font-size: 0.9rem; font-weight: 600; color: #495057; margin-right: 0.5rem; align-self: center; }
    .category-filter { margin-bottom: 2rem; }
    .category-btn { margin-right: 0.5rem; margin-bottom: 0.5rem; border-radius: 20px; padding: 0.5rem 1rem; transition: all 0.3s ease; }
    .category-btn.active { background-color: #3a86ff; color: white; }

    /* Animation Keyframes */
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>
@endpush

    <div class="contact-header">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">{{ __('New Arrivals') }}</h1>
            <p class="lead">We'd love to hear from you. Get in touch with our team.</p>
        </div>
    </div>
    <div class="container">
        <!-- Redesigned Featured New Arrival -->
        <div class="featured-new">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="featured-new-img-container">
                        <img src="https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Ultrabook Pro 15 - 2023 Edition" class="featured-new-img">
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                    <div class="featured-new-content">
                        <span class="featured-badge">
                            <i class="fas fa-bolt me-1"></i> Just Arrived
                        </span>
                        <h2 class="featured-new-title">Ultrabook Pro 15" - 2023 Edition</h2>
                        <p class="featured-new-desc">Experience unparalleled performance with our thinnest and most powerful laptop yet. Featuring the latest processor, stunning display, and all-day battery life.</p>

                        <div class="featured-new-specs">
                            <div class="spec-item">
                                <i class="fas fa-microchip"></i> Intel i9 Processor
                            </div>
                            <div class="spec-item">
                                <i class="fas fa-memory"></i> 32GB RAM
                            </div>
                            <div class="spec-item">
                                <i class="fas fa-hdd"></i> 1TB SSD
                            </div>
                            <div class="spec-item">
                                <i class="fas fa-battery-full"></i> 15hr Battery
                            </div>
                        </div>

                        <div class="featured-new-price">
                            $1,299.99
                            <span class="featured-new-original-price">$1,499.99</span>
                            <span class="featured-new-discount">Save 13%</span>
                        </div>

                        <div class="featured-new-timer">
                            <span class="timer-title">Limited Time Offer:</span>
                            <div class="timer-item">
                                <span class="timer-number" data-end-time="2025-07-02T23:59:59+07:00"></span>
                                <span class="timer-label">Days</span>
                            </div>
                            <div class="timer-item">
                                <span class="timer-number" data-end-time="2025-07-02T23:59:59+07:00"></span>
                                <span class="timer-label">Hours</span>
                            </div>
                            <div class="timer-item">
                                <span class="timer-number" data-end-time="2025-07-02T23:59:59+07:00"></span>
                                <span class="timer-label">Mins</span>
                            </div>
                            <div class="timer-item">
                                <span class="timer-number" data-end-time="2025-07-02T23:59:59+07:00"></span>
                                <span class="timer-label">Secs</span>
                            </div>
                        </div>

                        <div class="featured-new-actions">
                            <a href="#" class="btn btn-primary btn-shop-now">
                                <i class="fas fa-shopping-cart me-2"></i> Shop Now
                            </a>
                            <button class="btn btn-outline-primary btn-wishlist">
                                <i class="fas fa-heart"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="text-center mt-4">
        <button id="loadMoreBtn" class="btn btn-outline-primary">Load More</button>
    </div>
        </div>
    </section>

    <!-- Load More Button -->

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Category Filter Functionality
        const categoryButtons = document.querySelectorAll('.category-btn');
        const productCards = document.querySelectorAll('.product-card');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                productCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Load More Button Functionality
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                this.disabled = true;

                // Simulate loading delay
                setTimeout(() => {
                    this.innerHTML = 'No More Products';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-secondary');
                }, 1500);
            });
        }

        // Countdown Timer Functionality
        function updateTimer() {
            const endTime = new Date('2025-07-02T23:59:59+07:00').getTime();
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                document.querySelectorAll('.timer-item').forEach(item => {
                    item.querySelector('.timer-number').textContent = '00';
                });
                clearInterval(timerInterval);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.querySelectorAll('.timer-number').forEach((el, index) => {
                if (index === 0) el.textContent = String(days).padStart(2, '0');
                if (index === 1) el.textContent = String(hours).padStart(2, '0');
                if (index === 2) el.textContent = String(minutes).padStart(2, '0');
                if (index === 3) el.textContent = String(seconds).padStart(2, '0');
            });
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Initial call
    });
</script>
@endpush