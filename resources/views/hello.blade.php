<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase - Modern E-commerce Store</title>
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

        .filter-btn:hover, .filter-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">ShopEase</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured">Featured</a>
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
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Browse our wide range of products by category</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Clothing">
                        <div class="category-overlay">
                            <h3>Clothing</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2025&q=80" alt="Shoes">
                        <div class="category-overlay">
                            <h3>Shoes</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1523293182086-7651a899d37f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2025&q=80" alt="Accessories">
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
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Discover our wide range of high-quality products</p>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-center flex-wrap gap-2" data-aos="fade-up" data-aos-delay="200">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=705&q=80" alt="Summer T-Shirt">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="shoes" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Running Shoes">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="accessories sale" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1523206489230-c012c64b2b48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Smart Watch">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up" data-aos-delay="400">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=736&q=80" alt="Casual Jacket">
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
                    <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Check out our featured product of the month</p>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="featured-product">
                        <div class="featured-product-img">
                            <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80" alt="Premium Leather Jacket">
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
                        <p class="featured-product-desc">This premium leather jacket is crafted from the finest materials for ultimate comfort and style. Perfect for any occasion, it features a sleek design, durable construction, and a comfortable fit. Available in multiple sizes and colors.</p>

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
                                <button class="btn btn-outline-secondary" type="button" id="decrementQuantity">-</button>
                                <input type="text" class="form-control text-center" value="1" id="productQuantity">
                                <button class="btn btn-outline-secondary" type="button" id="incrementQuantity">+</button>
                            </div>
                            <button class="btn btn-primary-custom flex-grow-1 add-to-cart-btn">Add to Cart</button>
                        </div>

                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary-custom me-3"><i class="far fa-heart me-2"></i> Add to Wishlist</button>
                            <button class="btn btn-outline-primary-custom"><i class="fas fa-share-alt me-2"></i> Share</button>
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
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Get the latest updates, offers and special announcements delivered directly to your inbox.</p>
                    <form class="newsletter-form" data-aos="fade-up" data-aos-delay="200">
                        <div class="input-group">
                            <input type="email" class="form-control newsletter-input" placeholder="Enter your email">
                            <button class="btn newsletter-btn" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
</body>
</html>
