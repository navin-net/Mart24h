    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #f59e0b;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --success: #10b981;
            --danger: #ef4444;
            --body-bg: #f3f4f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
        }

        /* Utility Classes */
        .bg-primary-custom {
            background-color: var(--primary);
        }

        .bg-secondary-custom {
            background-color: var(--secondary);
        }

        .text-primary-custom {
            color: var(--primary);
        }

        .text-secondary-custom {
            color: var(--secondary);
        }

        .btn-primary-custom {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary-custom {
            border-color: var(--primary);
            color: var(--primary);
            transition: all 0.3s ease;
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary-custom {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background-color: #e69009;
            border-color: #e69009;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Navbar */
        .navbar {
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar.scrolled {
            background-color: white !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            margin: 0 0.5rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            bottom: -3px;
            left: 0;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .cart-icon {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center/cover;
            min-height: 80vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
        }

        /* Categories */
        .category-card {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            height: 200px;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .category-overlay h3 {
            color: white;
            margin-bottom: 0;
            font-weight: 600;
        }

        /* Products */
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-img-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .product-card:hover .product-img-container img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-badge.sale {
            background-color: var(--danger);
            color: white;
        }

        .product-badge.new {
            background-color: var(--success);
            color: white;
        }

        .product-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            background-color: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .product-info {
            padding: 1rem;
        }

        .product-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .product-category {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .current-price {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        .old-price {
            text-decoration: line-through;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .stars {
            color: var(--secondary);
        }

        .rating-count {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Featured Products */
        .featured-product {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .featured-product:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .featured-product-img {
            height: 400px;
            overflow: hidden;
        }

        .featured-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .featured-product:hover .featured-product-img img {
            transform: scale(1.1);
        }

        .featured-product-info {
            padding: 2rem;
        }

        .featured-product-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .featured-product-desc {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        /* Newsletter */
        .newsletter {
            background-color: var(--primary);
            color: white;
            padding: 4rem 0;
        }

        .newsletter-form {
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            border-radius: 50px 0 0 50px;
            padding: 0.75rem 1.5rem;
            border: none;
        }

        .newsletter-btn {
            border-radius: 0 50px 50px 0;
            background-color: var(--secondary);
            border-color: var(--secondary);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .newsletter-btn:hover {
            background-color: #e69009;
            border-color: #e69009;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
            bottom: -10px;
            left: 0;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: var(--primary);
            transform: translateY(-5px);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            margin-top: 3rem;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background-color: white;
            z-index: 1050;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .close-cart {
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .close-cart:hover {
            color: var(--danger);
        }

        .cart-items {
            padding: 1.5rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            overflow: hidden;
        }

        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 25px;
            height: 25px;
            border-radius: 5px;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background-color: #e5e7eb;
        }

        .cart-item-remove {
            color: var(--danger);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cart-item-remove:hover {
            transform: scale(1.1);
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .cart-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .cart-total-title {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .cart-total-price {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        /* Product Modal */
        .product-modal .modal-content {
            border-radius: 10px;
            overflow: hidden;
        }

        .product-modal .modal-body {
            padding: 0;
        }

        .modal-product-img {
            height: 400px;
        }

        .modal-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-product-info {
            padding: 2rem;
        }

        .modal-product-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .modal-product-price {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .modal-current-price {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .modal-old-price {
            text-decoration: line-through;
            color: var(--gray);
            font-size: 1.1rem;
        }

        .modal-product-desc {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .product-colors {
            margin-bottom: 1.5rem;
        }

        .color-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .color-options {
            display: flex;
            gap: 0.5rem;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-option.active {
            transform: scale(1.2);
            box-shadow: 0 0 0 2px white, 0 0 0 4px var(--primary);
        }

        .product-sizes {
            margin-bottom: 1.5rem;
        }

        .size-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .size-options {
            display: flex;
            gap: 0.5rem;
        }

        .size-option {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .size-option.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .modal-product-quantity {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .quantity-input {
            width: 100px;
        }

        .hero-section {
            height: 500px;
            background-size: cover;
            background-position: center;
            position: relative;
            animation: fadeIn 1s ease-out;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 8px;
            padding: 2rem;
            animation: slideInRight 0.8s ease-out;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease forwards;
        }

        .slide-in-right {
            animation: slideInRight 1s ease forwards;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .cart-sidebar {
                width: 350px;
            }
        }

        @media (max-width: 767.98px) {
            .hero h1 {
                font-size: 2rem;
            }

            .cart-sidebar {
                width: 300px;
            }

            .featured-product-img {
                height: 300px;
            }
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Filter */
        .filter-btn {
            border: 1px solid #e5e7eb;
            background-color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
    </style>

    <body>


        @include('shop.layout.header')

        @include('shop.layout.slider')

        @yield('content')



















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
    </body>

    </html>
