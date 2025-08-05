@extends('shop.layouts.app')
@section('title','Shopping Cart')
@section('content')

<style>
    .cart-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
    }
    
    .btn-quantity {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .cart-summary {
        background-color: #f8f9fa;
        border-radius: 10px;
        position: sticky;
        top: 20px;
    }
    
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-cart i {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
    }
    
    .cart-item {
        transition: all 0.3s ease;
    }
    
    .cart-item.removing {
        opacity: 0.5;
        transform: translateX(-20px);
    }
    
    .price-text {
        font-weight: 600;
        color: #198754;
    }
    
    .original-price {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 0.9em;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Shopping Cart</h2>
        </div>
    </div>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div id="cart-items">
                <!-- Cart Item 1 -->
                <div class="card mb-3 cart-item" data-product-id="1">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-3">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Wireless Headphones" class="cart-item-image">
                            </div>
                            <div class="col-md-4 col-9">
                                <h6 class="card-title mb-1">Wireless Bluetooth Headphones</h6>
                                <p class="text-muted small mb-1">Color: Black | Size: Standard</p>
                                <span class="badge bg-success">In Stock</span>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(1, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control quantity-input mx-2" value="2" min="1" onchange="setQuantity(1, this.value)">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(1, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text">${{ number_format(79.99, 2) }}</div>
                                <div class="original-price">${{ number_format(99.99, 2) }}</div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text item-total">${{ number_format(159.98, 2) }}</div>
                                <button class="btn btn-outline-danger btn-sm mt-1" onclick="removeItem(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="card mb-3 cart-item" data-product-id="2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-3">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Smartphone Case" class="cart-item-image">
                            </div>
                            <div class="col-md-4 col-9">
                                <h6 class="card-title mb-1">Premium Smartphone Case</h6>
                                <p class="text-muted small mb-1">Color: Blue | Model: iPhone 14</p>
                                <span class="badge bg-success">In Stock</span>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(2, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control quantity-input mx-2" value="1" min="1" onchange="setQuantity(2, this.value)">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(2, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text">${{ number_format(24.99, 2) }}</div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text item-total">${{ number_format(24.99, 2) }}</div>
                                <button class="btn btn-outline-danger btn-sm mt-1" onclick="removeItem(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="card mb-3 cart-item" data-product-id="3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-3">
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="USB Cable" class="cart-item-image">
                            </div>
                            <div class="col-md-4 col-9">
                                <h6 class="card-title mb-1">USB-C Charging Cable</h6>
                                <p class="text-muted small mb-1">Length: 6ft | Type: USB-C to USB-A</p>
                                <span class="badge bg-warning text-dark">Limited Stock</span>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(3, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control quantity-input mx-2" value="3" min="1" onchange="setQuantity(3, this.value)">
                                    <button class="btn btn-outline-secondary btn-quantity" onclick="updateQuantity(3, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text">${{ number_format(12.99, 2) }}</div>
                            </div>
                            <div class="col-md-2 col-4 text-center">
                                <div class="price-text item-total">${{ number_format(38.97, 2) }}</div>
                                <button class="btn btn-outline-danger btn-sm mt-1" onclick="removeItem(3)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Cart State (Hidden by default) -->
            <div id="empty-cart" class="card d-none">
                <div class="card-body empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted">Add some items to your cart to get started!</p>
                    <a href="{{ route('shop.products') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>

            <!-- Continue Shopping -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
                <button class="btn btn-outline-secondary" onclick="clearCart()">
                    <i class="fas fa-trash"></i> Clear Cart
                </button>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="cart-summary p-4">
                <h5 class="mb-3">Order Summary</h5>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal (<span id="total-items">6</span> items):</span>
                    <span id="subtotal">${{ number_format(223.94, 2) }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <span class="text-success">Free</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax:</span>
                    <span id="tax">${{ number_format(17.92, 2) }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-success">Discount:</span>
                    <span class="text-success" id="discount">-${{ number_format(20.00, 2) }}</span>
                </div>
                
                <hr>
                
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total:</strong>
                    <strong class="price-text" id="total">${{ number_format(221.86, 2) }}</strong>
                </div>
                
                <!-- Promo Code -->
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code" id="promo-code">
                        <button class="btn btn-outline-secondary" onclick="applyPromoCode()">Apply</button>
                    </div>
                </div>
                
                <button class="btn btn-success w-100 mb-2" onclick="checkout()">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </button>
                
                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt"></i> Secure checkout with SSL encryption
                    </small>
                </div>
                
                <!-- Payment Methods -->
                <div class="mt-3 text-center">
                    <small class="text-muted d-block mb-2">We accept:</small>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary">Visa</span>
                        <span class="badge bg-warning text-dark">Mastercard</span>
                        <span class="badge bg-info">PayPal</span>
                        <span class="badge bg-dark">Apple Pay</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast for notifications -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="notification-toast" class="toast" role="alert">
        <div class="toast-header">
            <i class="fas fa-check-circle text-success me-2"></i>
            <strong class="me-auto">Cart Updated</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toast-message">
            Item updated successfully!
        </div>
    </div>
</div>

<script>
    // Cart data structure
    let cartData = {
        1: { name: "Wireless Bluetooth Headphones", price: 79.99, originalPrice: 99.99, quantity: 2 },
        2: { name: "Premium Smartphone Case", price: 24.99, quantity: 1 },
        3: { name: "USB-C Charging Cable", price: 12.99, quantity: 3 }
    };

    // Update quantity function
    function updateQuantity(productId, change) {
        const currentQuantity = cartData[productId].quantity;
        const newQuantity = currentQuantity + change;
        
        if (newQuantity > 0) {
            cartData[productId].quantity = newQuantity;
            updateCartDisplay();
            showToast(`Quantity updated to ${newQuantity}`);
        }
    }

    // Set quantity directly
    function setQuantity(productId, quantity) {
        const qty = parseInt(quantity);
        if (qty > 0) {
            cartData[productId].quantity = qty;
            updateCartDisplay();
            showToast(`Quantity set to ${qty}`);
        }
    }

    // Remove item from cart
    function removeItem(productId) {
        const item = document.querySelector(`[data-product-id="${productId}"]`);
        item.classList.add('removing');
        
        setTimeout(() => {
            delete cartData[productId];
            updateCartDisplay();
            showToast(`Item removed from cart`);
            
            // Check if cart is empty
            if (Object.keys(cartData).length === 0) {
                showEmptyCart();
            }
        }, 300);
    }

    // Clear entire cart
    function clearCart() {
        if (confirm('Are you sure you want to clear your cart?')) {
            cartData = {};
            showEmptyCart();
            showToast('Cart cleared successfully');
        }
    }

    // Update cart display
    function updateCartDisplay() {
        let subtotal = 0;
        let totalItems = 0;

        // Update individual items
        Object.keys(cartData).forEach(productId => {
            const item = cartData[productId];
            const itemElement = document.querySelector(`[data-product-id="${productId}"]`);
            
            if (itemElement) {
                // Update quantity input
                const quantityInput = itemElement.querySelector('.quantity-input');
                quantityInput.value = item.quantity;
                
                // Update item total
                const itemTotal = item.price * item.quantity;
                const itemTotalElement = itemElement.querySelector('.item-total');
                itemTotalElement.textContent = `$${itemTotal.toFixed(2)}`;
                
                subtotal += itemTotal;
                totalItems += item.quantity;
            }
        });

        // Update summary
        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('total-items').textContent = totalItems;
        
        // Calculate tax (8% for example)
        const tax = subtotal * 0.08;
        document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
        
        // Calculate total with discount
        const discount = 20.00;
        const total = subtotal + tax - discount;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }

    // Show empty cart
    function showEmptyCart() {
        document.getElementById('cart-items').classList.add('d-none');
        document.getElementById('empty-cart').classList.remove('d-none');
    }

    // Apply promo code
    function applyPromoCode() {
        const promoCode = document.getElementById('promo-code').value.trim();
        
        if (promoCode === 'SAVE20') {
            showToast('Promo code applied! $20 discount added.');
            document.getElementById('discount').textContent = '-$20.00';
        } else if (promoCode === '') {
            showToast('Please enter a promo code', 'warning');
        } else {
            showToast('Invalid promo code', 'error');
        }
    }

    // Checkout function
    function checkout() {
        if (Object.keys(cartData).length === 0) {
            showToast('Your cart is empty!', 'error');
            return;
        }
        
        // Redirect to checkout page
        window.location.href = "{{ route('shop.checkout') }}";
    }

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('notification-toast');
        const toastMessage = document.getElementById('toast-message');
        const toastHeader = toast.querySelector('.toast-header');
        
        // Update message
        toastMessage.textContent = message;
        
        // Update icon based on type
        const icon = toastHeader.querySelector('i');
        icon.className = type === 'error' ? 'fas fa-exclamation-triangle text-danger me-2' : 
                       type === 'warning' ? 'fas fa-exclamation-triangle text-warning me-2' :
                       'fas fa-check-circle text-success me-2';
        
        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }

    // Initialize cart display on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartDisplay();
    });
</script>

@endsection