    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h3 class="footer-title">ShopEase</h3>
                    <p>Your one-stop shop for all your fashion needs. We provide high-quality products at affordable prices.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#categories">Categories</a></li>
                        <li><a href="#featured">Featured</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h3 class="footer-title">Customer Service</h3>
                    <ul class="footer-links">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Customer Service</a></li>
                        <li><a href="#">Returns/Exchange</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Street, New York, USA</p>
                    <p><i class="fas fa-phone-alt me-2"></i> +1 234 567 8900</p>
                    <p><i class="fas fa-envelope me-2"></i> info@shopease.com</p>
                    <p><i class="fas fa-clock me-2"></i> Mon-Fri: 9AM to 5PM</p>
                </div>
            </div>
            <div class="row copyright text-center">
                <div class="col-12">
                    <p>&copy; 2023 ShopEase. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3 class="cart-title">Your Cart (3)</h3>
            <div class="close-cart" id="closeCart"><i class="fas fa-times"></i></div>
        </div>
        <div class="cart-items">
            <!-- Cart Item 1 -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Summer T-Shirt">
                </div>
                <div class="cart-item-info">
                    <h4 class="cart-item-title">Summer T-Shirt</h4>
                    <p class="cart-item-price">$29.99</p>
                    <div class="cart-item-quantity">
                        <div class="quantity-btn decrement-quantity">-</div>
                        <span>1</span>
                        <div class="quantity-btn increment-quantity">+</div>
                    </div>
                </div>
                <div class="cart-item-remove"><i class="fas fa-trash"></i></div>
            </div>

            <!-- Cart Item 2 -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Running Shoes">
                </div>
                <div class="cart-item-info">
                    <h4 class="cart-item-title">Running Shoes</h4>
                    <p class="cart-item-price">$89.99</p>
                    <div class="cart-item-quantity">
                        <div class="quantity-btn decrement-quantity">-</div>
                        <span>1</span>
                        <div class="quantity-btn increment-quantity">+</div>
                    </div>
                </div>
                <div class="cart-item-remove"><i class="fas fa-trash"></i></div>
            </div>

            <!-- Cart Item 3 -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="https://images.unsplash.com/photo-1523206489230-c012c64b2b48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Smart Watch">
                </div>
                <div class="cart-item-info">
                    <h4 class="cart-item-title">Smart Watch</h4>
                    <p class="cart-item-price">$149.99</p>
                    <div class="cart-item-quantity">
                        <div class="quantity-btn decrement-quantity">-</div>
                        <span>1</span>
                        <div class="quantity-btn increment-quantity">+</div>
                    </div>
                </div>
                <div class="cart-item-remove"><i class="fas fa-trash"></i></div>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <h4 class="cart-total-title">Total:</h4>
                <h4 class="cart-total-price">$269.97</h4>
            </div>
            <a href="#" class="btn btn-primary-custom w-100 mb-3">Checkout</a>
            <a href="#" class="btn btn-outline-primary-custom w-100">View Cart</a>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Product Modal -->
    <div class="modal fade product-modal" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="modal-product-img">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=736&q=80" alt="Casual Jacket">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="modal-product-info">
                                <h2 class="modal-product-title">Casual Jacket</h2>
                                <div class="product-rating mb-3">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-count">(19 reviews)</span>
                                </div>
                                <div class="modal-product-price">
                                    <span class="modal-current-price">$79.99</span>
                                </div>
                                <p class="modal-product-desc">This casual jacket is perfect for everyday wear. Made from high-quality materials, it offers both style and comfort. The versatile design makes it easy to pair with any outfit.</p>

                                <div class="product-colors mb-4">
                                    <h5 class="color-title">Colors:</h5>
                                    <div class="color-options">
                                        <div class="color-option active" style="background-color: #1a1a1a;"></div>
                                        <div class="color-option" style="background-color: #0047ab;"></div>
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

                                <div class="modal-product-quantity mb-4">
                                    <h5 class="mb-2">Quantity:</h5>
                                    <div class="input-group quantity-input">
                                        <button class="btn btn-outline-secondary" type="button" id="modalDecrementQuantity">-</button>
                                        <input type="text" class="form-control text-center" value="1" id="modalProductQuantity">
                                        <button class="btn btn-outline-secondary" type="button" id="modalIncrementQuantity">+</button>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary-custom add-to-cart-btn">Add to Cart</button>
                                    <button class="btn btn-outline-primary-custom"><i class="far fa-heart me-2"></i> Add to Wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Initialize AOS Animation Library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Cart Sidebar
        const cartIcon = document.getElementById('cartIcon');
        const cartSidebar = document.getElementById('cartSidebar');
        const closeCart = document.getElementById('closeCart');
        const overlay = document.getElementById('overlay');

        cartIcon.addEventListener('click', (e) => {
            e.preventDefault();
            cartSidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        closeCart.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        overlay.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        // Product Quantity
        const decrementQuantity = document.getElementById('decrementQuantity');
        const incrementQuantity = document.getElementById('incrementQuantity');
        const productQuantity = document.getElementById('productQuantity');

        if (decrementQuantity && incrementQuantity && productQuantity) {
            decrementQuantity.addEventListener('click', () => {
                let quantity = parseInt(productQuantity.value);
                if (quantity > 1) {
                    productQuantity.value = quantity - 1;
                }
            });

            incrementQuantity.addEventListener('click', () => {
                let quantity = parseInt(productQuantity.value);
                productQuantity.value = quantity + 1;
            });
        }

        // Modal Product Quantity
        const modalDecrementQuantity = document.getElementById('modalDecrementQuantity');
        const modalIncrementQuantity = document.getElementById('modalIncrementQuantity');
        const modalProductQuantity = document.getElementById('modalProductQuantity');

        if (modalDecrementQuantity && modalIncrementQuantity && modalProductQuantity) {
            modalDecrementQuantity.addEventListener('click', () => {
                let quantity = parseInt(modalProductQuantity.value);
                if (quantity > 1) {
                    modalProductQuantity.value = quantity - 1;
                }
            });

            modalIncrementQuantity.addEventListener('click', () => {
                let quantity = parseInt(modalProductQuantity.value);
                modalProductQuantity.value = quantity + 1;
            });
        }

        // Color Options
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Remove active class from all options
                colorOptions.forEach(opt => opt.classList.remove('active'));
                // Add active class to clicked option
                option.classList.add('active');
            });
        });

        // Size Options
        const sizeOptions = document.querySelectorAll('.size-option');
        sizeOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Remove active class from all options
                sizeOptions.forEach(opt => opt.classList.remove('active'));
                // Add active class to clicked option
                option.classList.add('active');
            });
        });

        // Product Filtering
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productItems = document.querySelectorAll('.product-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                productItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.style.display = 'block';
                    } else {
                        if (item.getAttribute('data-category').includes(filterValue)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Add to Cart Animation
        const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');

        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Add animation class
                this.classList.add('pulse');

                // Update cart count
                const cartBadge = document.querySelector('.cart-badge');
                let count = parseInt(cartBadge.textContent);
                cartBadge.textContent = count + 1;

                // Remove animation class after animation completes
                setTimeout(() => {
                    this.classList.remove('pulse');
                }, 1000);

                // Show cart sidebar
                cartSidebar.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Wishlist Animation
        const wishlistBtns = document.querySelectorAll('.add-to-wishlist');

        wishlistBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');

                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.style.color = '#ef4444';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    icon.style.color = '';
                }

                // Add animation
                this.classList.add('pulse');

                // Remove animation class after animation completes
                setTimeout(() => {
                    this.classList.remove('pulse');
                }, 1000);
            });
        });

        // Cart Item Quantity
        const decrementBtns = document.querySelectorAll('.decrement-quantity');
        const incrementBtns = document.querySelectorAll('.increment-quantity');

        decrementBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const quantitySpan = this.nextElementSibling;
                let quantity = parseInt(quantitySpan.textContent);

                if (quantity > 1) {
                    quantitySpan.textContent = quantity - 1;
                    updateCartTotal();
                }
            });
        });

        incrementBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const quantitySpan = this.previousElementSibling;
                let quantity = parseInt(quantitySpan.textContent);

                quantitySpan.textContent = quantity + 1;
                updateCartTotal();
            });
        });

        // Remove Cart Item
        const removeItemBtns = document.querySelectorAll('.cart-item-remove');

        removeItemBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const cartItem = this.parentElement;

                // Add fade-out animation
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(20px)';

                // Remove item after animation completes
                setTimeout(() => {
                    cartItem.remove();
                    updateCartTotal();

                    // Update cart count
                    const cartBadge = document.querySelector('.cart-badge');
                    let count = parseInt(cartBadge.textContent);
                    cartBadge.textContent = count - 1;

                    // Update cart title
                    const cartTitle = document.querySelector('.cart-title');
                    cartTitle.textContent = `Your Cart (${count - 1})`;
                }, 300);
            });
        });

        // Update Cart Total
        function updateCartTotal() {
            const cartItems = document.querySelectorAll('.cart-item');
            let total = 0;

            cartItems.forEach(item => {
                const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('$', ''));
                const quantity = parseInt(item.querySelector('.cart-item-quantity span').textContent);

                total += price * quantity;
            });

            const cartTotalPrice = document.querySelector('.cart-total-price');
            cartTotalPrice.textContent = `$${total.toFixed(2)}`;
        }

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');

                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                }
            });
        });
    </script>
