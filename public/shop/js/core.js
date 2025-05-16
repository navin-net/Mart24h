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
    btn.addEventListener('click', function () {
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
    btn.addEventListener('click', function () {
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
    btn.addEventListener('click', function () {
        const quantitySpan = this.nextElementSibling;
        let quantity = parseInt(quantitySpan.textContent);

        if (quantity > 1) {
            quantitySpan.textContent = quantity - 1;
            updateCartTotal();
        }
    });
});

incrementBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        const quantitySpan = this.previousElementSibling;
        let quantity = parseInt(quantitySpan.textContent);

        quantitySpan.textContent = quantity + 1;
        updateCartTotal();
    });
});

// Remove Cart Item
const removeItemBtns = document.querySelectorAll('.cart-item-remove');

removeItemBtns.forEach(btn => {
    btn.addEventListener('click', function () {
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
    anchor.addEventListener('click', function (e) {
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

