<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Stock Management')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('shop/css/style.css') }}" rel="stylesheet">
    <style>
    .contact-header {
    background: linear-gradient(135deg, #3a86ff 0%, #ff3a5e 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 2rem;
    animation: fadeIn 0.8s ease-out;
    }
    </style>
    @stack('style')
</head>

<body>
    @include('shop.layouts.navbar')

    @yield('content')

    @include('shop.layouts.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@stack('scripts')
    <script>
        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Cart Sidebar
        const cartIcon = document.getElementById('cartIcon');
        const cartSidebar = document.getElementById('cartSidebar');
        const closeCart = document.getElementById('closeCart');
        const overlay = document.getElementById('overlay');

        if (cartIcon && cartSidebar && closeCart && overlay) {
            cartIcon.addEventListener('click', (e) => {
                e.preventDefault();
                cartSidebar.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            const closeSidebar = () => {
                cartSidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            };

            closeCart.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
        }

        // Product Quantity Controls
        const setupQuantityControl = (decrementId, incrementId, quantityId) => {
            const dec = document.getElementById(decrementId);
            const inc = document.getElementById(incrementId);
            const input = document.getElementById(quantityId);

            if (dec && inc && input) {
                dec.addEventListener('click', () => {
                    let q = parseInt(input.value);
                    if (q > 1) input.value = q - 1;
                });

                inc.addEventListener('click', () => {
                    let q = parseInt(input.value);
                    input.value = q + 1;
                });
            }
        };

        setupQuantityControl('decrementQuantity', 'incrementQuantity', 'productQuantity');
        setupQuantityControl('modalDecrementQuantity', 'modalIncrementQuantity', 'modalProductQuantity');

        // Color & Size Options
        const toggleActive = (selector) => {
            const options = document.querySelectorAll(selector);
            options.forEach(option => {
                option.addEventListener('click', () => {
                    options.forEach(o => o.classList.remove('active'));
                    option.classList.add('active');
                });
            });
        };

        toggleActive('.color-option');
        toggleActive('.size-option');

        // Product Filtering
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productItems = document.querySelectorAll('.product-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const value = btn.getAttribute('data-filter');
                productItems.forEach(item => {
                    item.style.display = value === 'all' || item.getAttribute('data-category').includes(value) ? 'block' : 'none';
                });
            });
        });

        // Add to Cart Animation
        const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                this.classList.add('pulse');
                const cartBadge = document.querySelector('.cart-badge');
                let count = parseInt(cartBadge.textContent) || 0;
                cartBadge.textContent = count + 1;
                setTimeout(() => this.classList.remove('pulse'), 1000);

                if (cartSidebar && overlay) {
                    cartSidebar.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        // Wishlist Button
        const wishlistBtns = document.querySelectorAll('.add-to-wishlist');
        wishlistBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.style.color = icon.classList.contains('fas') ? '#ef4444' : '';
                this.classList.add('pulse');
                setTimeout(() => this.classList.remove('pulse'), 1000);
            });
        });

        // Cart Item Quantity
        const updateCartTotal = () => {
            const cartItems = document.querySelectorAll('.cart-item');
            let total = 0;
            cartItems.forEach(item => {
                const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('$', '')) || 0;
                const quantity = parseInt(item.querySelector('.cart-item-quantity span').textContent) || 1;
                total += price * quantity;
            });
            const cartTotalPrice = document.querySelector('.cart-total-price');
            if (cartTotalPrice) cartTotalPrice.textContent = `$${total.toFixed(2)}`;
        };

        document.querySelectorAll('.decrement-quantity').forEach(btn => {
            btn.addEventListener('click', function () {
                const span = this.nextElementSibling;
                let q = parseInt(span.textContent);
                if (q > 1) span.textContent = q - 1;
                updateCartTotal();
            });
        });

        document.querySelectorAll('.increment-quantity').forEach(btn => {
            btn.addEventListener('click', function () {
                const span = this.previousElementSibling;
                span.textContent = parseInt(span.textContent) + 1;
                updateCartTotal();
            });
        });

        document.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.parentElement;
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    item.remove();
                    updateCartTotal();
                    const cartBadge = document.querySelector('.cart-badge');
                    let count = parseInt(cartBadge.textContent);
                    cartBadge.textContent = count - 1;
                    const cartTitle = document.querySelector('.cart-title');
                    if (cartTitle) cartTitle.textContent = `Your Cart (${count - 1})`;
                }, 300);
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                }
            });
        });

        // Image Swapping & Modal Preview
        function changeMainImage(mainImageId, newSrc, randomId) {
            const mainImage = document.getElementById(mainImageId);
            const thumbnails = mainImage.parentElement.parentElement.querySelectorAll('.thumb-image');
            const highResSrc = newSrc.replace('150/150', '600/400').replace('100/100', '400/300');
            mainImage.src = highResSrc;
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            event.target.classList.add('active');
            updateModalCarousel(randomId);
        }

        function updateModalCarousel(startId) {
            const carouselItems = document.querySelectorAll('#productCarousel .carousel-item img');
            carouselItems.forEach((img, index) => {
                img.src = `https://picsum.photos/800/600?random=${startId + index}`;
            });
        }

        document.getElementById('imageModal')?.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const imgSrc = trigger?.src;
            const firstCarouselImg = document.querySelector('#productCarousel .carousel-item.active img');
            if (firstCarouselImg) {
                firstCarouselImg.src = imgSrc.replace(/(600|400)\/(400|300)/, '800/600');
            }
        });

        // Tooltips
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Handle submenu toggle
            document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const submenu = this.nextElementSibling;
                    submenu.classList.toggle('show');
                });
            });

            // Close submenus when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown-submenu')) {
                    document.querySelectorAll('.dropdown-submenu .dropdown-menu').forEach(function (submenu) {
                        submenu.classList.remove('show');
                    });
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Price range slider
            // const priceRange = document.getElementById('priceRange');
            // const maxPriceDisplay = document.getElementById('maxPrice');
            // priceRange.addEventListener('input', function () {
            //     maxPriceDisplay.textContent = '$' + parseInt(this.value).toLocaleString();
            // });

            // Color filter toggle
            window.toggleColorFilter = function (element, color) {
                const container = document.getElementById('selected-colors');
                const isSelected = element.classList.contains('selected');
                
                if (isSelected) {
                    // Remove selection
                    element.classList.remove('selected');
                    const input = container.querySelector(`input[data-color="${color}"]`);
                    if (input) input.remove();
                } else {
                    // Add selection
                    element.classList.add('selected');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'color[]';
                    input.value = color;
                    input.setAttribute('data-color', color);
                    container.appendChild(input);
                }
                
                // Submit form to apply filter
                document.getElementById('filterForm').submit();
            };

            // Add to cart
            window.addToCart = function (product) {
                console.log('Add to cart:', product);
                // Implement actual cart logic here
            };

            // Toggle favorite
            window.toggleFavorite = function (id) {
                const icon = document.getElementById(`fav-${id}`);
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
            };
        });
        // Uncomment if AOS is enabled
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        // Image Gallery
        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image
                const mainImage = document.getElementById('mainImage');
                mainImage.src = this.getAttribute('data-src');
                
                // Update active thumb
                document.querySelectorAll('.gallery-thumb').forEach(t => {
                    t.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Color Selection
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function() {
                // Update active color
                document.querySelectorAll('.color-option').forEach(o => {
                    o.classList.remove('active');
                });
                this.classList.add('active');
                
                // Update selected color text
                document.getElementById('selectedColor').textContent = this.getAttribute('data-color');
            });
        });

        // Quantity Selector
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const quantitySpan = this.parentElement.querySelector('span');
                let quantity = parseInt(quantitySpan.textContent);
                if (this.classList.contains('increment-quantity')) {
                    quantity++;
                } else if (this.classList.contains('decrement-quantity') && quantity > 1) {
                    quantity--;
                }
                quantitySpan.textContent = quantity;
            });
        });

        // Add to Cart Button (shows alert, replace with AJAX as needed)
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productInfo = this.closest('.product-info');
                let quantity = 1;
                let color = '';
                if (productInfo) {
                    const quantitySpan = productInfo.querySelector('.cart-item-quantity span');
                    if (quantitySpan) quantity = quantitySpan.textContent;
                    const colorOption = productInfo.querySelector('.color-option.active');
                    if (colorOption) color = colorOption.getAttribute('data-color');
                }
                alert('Added to cart!\nQuantity: ' + quantity + '\nColor: ' + color);
                // Replace alert with AJAX call to add to cart if needed
            });
        });

        // Initialize tooltips (Bootstrap 5)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>

</body>

</html>