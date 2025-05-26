<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom CSS can go here if needed */
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .category-btn.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">Point of Sale System</h1>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Products Section -->
            <div class="lg:w-2/3 bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Products</h2>
                    <div class="relative">
                        <input type="text" id="search-product" placeholder="Search products..."
                               class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="category-btn active px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50" data-category="all">All</button>
                    <button class="category-btn px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50" data-category="electronics">Electronics</button>
                    <button class="category-btn px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50" data-category="clothing">Clothing</button>
                    <button class="category-btn px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50" data-category="groceries">Groceries</button>
                    <button class="category-btn px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50" data-category="stationery">Stationery</button>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="product-grid">
                    <!-- Products will be dynamically inserted here -->
                </div>
            </div>

            <!-- Cart Section -->
            <div class="lg:w-1/3 bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                <div class="border-b pb-4 mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Customer:</span>
                        <select id="customer-select" class="border rounded px-2 py-1">
                            <option value="walk-in">Walk-in Customer</option>
                            <option value="regular">Regular Customer</option>
                            <option value="vip">VIP Customer</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Order #:</span>
                        <span id="order-number" class="font-mono">ORD-2023-001</span>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="max-h-96 overflow-y-auto mb-4" id="cart-items">
                    <!-- Cart items will be dynamically inserted here -->
                    <div class="text-center text-gray-500 py-8" id="empty-cart-message">
                        <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                        <p>Your cart is empty</p>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Tax (10%):</span>
                        <span id="tax">$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Discount:</span>
                        <span id="discount">$0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span id="total">$0.00</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button id="clear-cart" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i> Clear
                    </button>
                    <button id="checkout" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                        <i class="fas fa-credit-card"></i> Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal (hidden by default) -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Complete Payment</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-lg font-medium mb-2">Total Amount: <span id="modal-total">$0.00</span></p>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Payment Method</label>
                <select id="payment-method" class="w-full border rounded px-3 py-2">
                    <option value="cash">Cash</option>
                    <option value="credit">Credit Card</option>
                    <option value="debit">Debit Card</option>
                    <option value="mobile">Mobile Payment</option>
                </select>
            </div>

            <div id="cash-payment" class="mb-4">
                <label class="block mb-2 font-medium">Amount Received</label>
                <input type="number" id="amount-received" class="w-full border rounded px-3 py-2" placeholder="0.00">
                <p class="mt-2 text-sm">Change: <span id="change-amount">$0.00</span></p>
            </div>

            <div class="flex justify-end gap-3">
                <button id="cancel-payment" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Cancel</button>
                <button id="confirm-payment" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal (hidden by default) -->
    <div id="receipt-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="text-center mb-4">
                <h3 class="text-xl font-semibold">Order Receipt</h3>
                <p class="text-sm text-gray-500" id="receipt-date"></p>
            </div>

            <div class="border-b pb-2 mb-2">
                <p class="font-medium">Order #: <span id="receipt-order-number"></span></p>
                <p class="text-sm">Customer: <span id="receipt-customer"></span></p>
            </div>

            <div class="mb-4 max-h-64 overflow-y-auto" id="receipt-items">
                <!-- Receipt items will be inserted here -->
            </div>

            <div class="border-t pt-2">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span id="receipt-subtotal"></span>
                </div>
                <div class="flex justify-between">
                    <span>Tax:</span>
                    <span id="receipt-tax"></span>
                </div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span id="receipt-total"></span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Payment Method:</span>
                    <span id="receipt-payment-method"></span>
                </div>
                <div class="flex justify-between" id="receipt-change-container">
                    <span>Change:</span>
                    <span id="receipt-change"></span>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 mb-4">Thank you for your purchase!</p>
                <button id="print-receipt" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mr-2">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <button id="close-receipt" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Sample product data
        const products = [
            { id: 1, name: "Wireless Headphones", price: 99.99, category: "electronics", image: "https://via.placeholder.com/150?text=Headphones" },
            { id: 2, name: "Smartphone", price: 599.99, category: "electronics", image: "https://via.placeholder.com/150?text=Smartphone" },
            { id: 3, name: "Laptop", price: 899.99, category: "electronics", image: "https://via.placeholder.com/150?text=Laptop" },
            { id: 4, name: "T-Shirt", price: 19.99, category: "clothing", image: "https://via.placeholder.com/150?text=T-Shirt" },
            { id: 5, name: "Jeans", price: 49.99, category: "clothing", image: "https://via.placeholder.com/150?text=Jeans" },
            { id: 6, name: "Milk", price: 3.99, category: "groceries", image: "https://via.placeholder.com/150?text=Milk" },
            { id: 7, name: "Bread", price: 2.49, category: "groceries", image: "https://via.placeholder.com/150?text=Bread" },
            { id: 8, name: "Notebook", price: 4.99, category: "stationery", image: "https://via.placeholder.com/150?text=Notebook" },
            { id: 9, name: "Pen Set", price: 12.99, category: "stationery", image: "https://via.placeholder.com/150?text=Pen+Set" },
            { id: 10, name: "Smart Watch", price: 199.99, category: "electronics", image: "https://via.placeholder.com/150?text=Watch" },
            { id: 11, name: "Sneakers", price: 79.99, category: "clothing", image: "https://via.placeholder.com/150?text=Sneakers" },
            { id: 12, name: "Coffee", price: 8.99, category: "groceries", image: "https://via.placeholder.com/150?text=Coffee" }
        ];

        // Cart state
        let cart = [];
        let currentOrderNumber = 1;

        // DOM elements
        const productGrid = document.getElementById('product-grid');
        const cartItems = document.getElementById('cart-items');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const subtotalElement = document.getElementById('subtotal');
        const taxElement = document.getElementById('tax');
        const totalElement = document.getElementById('total');
        const discountElement = document.getElementById('discount');
        const clearCartBtn = document.getElementById('clear-cart');
        const checkoutBtn = document.getElementById('checkout');
        const searchInput = document.getElementById('search-product');
        const categoryBtns = document.querySelectorAll('.category-btn');
        const customerSelect = document.getElementById('customer-select');
        const orderNumberElement = document.getElementById('order-number');

        // Modal elements
        const paymentModal = document.getElementById('payment-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const cancelPaymentBtn = document.getElementById('cancel-payment');
        const confirmPaymentBtn = document.getElementById('confirm-payment');
        const paymentMethodSelect = document.getElementById('payment-method');
        const amountReceivedInput = document.getElementById('amount-received');
        const changeAmountElement = document.getElementById('change-amount');
        const modalTotalElement = document.getElementById('modal-total');

        // Receipt modal elements
        const receiptModal = document.getElementById('receipt-modal');
        const closeReceiptBtn = document.getElementById('close-receipt');
        const printReceiptBtn = document.getElementById('print-receipt');
        const receiptDateElement = document.getElementById('receipt-date');
        const receiptOrderNumberElement = document.getElementById('receipt-order-number');
        const receiptCustomerElement = document.getElementById('receipt-customer');
        const receiptItemsElement = document.getElementById('receipt-items');
        const receiptSubtotalElement = document.getElementById('receipt-subtotal');
        const receiptTaxElement = document.getElementById('receipt-tax');
        const receiptTotalElement = document.getElementById('receipt-total');
        const receiptPaymentMethodElement = document.getElementById('receipt-payment-method');
        const receiptChangeElement = document.getElementById('receipt-change');
        const receiptChangeContainer = document.getElementById('receipt-change-container');

        // Initialize the app
        function init() {
            renderProducts(products);
            setupEventListeners();
            generateOrderNumber();
        }

        // Generate a random order number
        function generateOrderNumber() {
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const randomNum = Math.floor(100 + Math.random() * 900);

            const orderNumber = `ORD-${year}${month}${day}-${randomNum}`;
            orderNumberElement.textContent = orderNumber;
            return orderNumber;
        }

        // Render products to the grid
        function renderProducts(productsToRender) {
            productGrid.innerHTML = '';

            if (productsToRender.length === 0) {
                productGrid.innerHTML = '<p class="col-span-full text-center text-gray-500 py-8">No products found</p>';
                return;
            }

            productsToRender.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card bg-white rounded-lg shadow-sm p-4 cursor-pointer transition-all duration-200';
                productCard.innerHTML = `
                    <div class="h-32 bg-gray-100 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                        <img src="${product.image}" alt="${product.name}" class="object-cover h-full">
                    </div>
                    <h3 class="font-medium text-gray-800 truncate">${product.name}</h3>
                    <p class="text-blue-600 font-bold">$${product.price.toFixed(2)}</p>
                    <button class="add-to-cart mt-2 w-full bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-sm"
                            data-id="${product.id}">
                        <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                    </button>
                `;
                productGrid.appendChild(productCard);
            });
        }

        // Setup event listeners
        function setupEventListeners() {
            // Add to cart buttons
            productGrid.addEventListener('click', (e) => {
                if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
                    const button = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest('.add-to-cart');
                    const productId = parseInt(button.dataset.id);
                    addToCart(productId);
                }
            });

            // Clear cart button
            clearCartBtn.addEventListener('click', clearCart);

            // Checkout button
            checkoutBtn.addEventListener('click', () => {
                if (cart.length > 0) {
                    openPaymentModal();
                } else {
                    alert('Your cart is empty. Add some products first.');
                }
            });

            // Search functionality
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase();
                const filteredProducts = products.filter(product =>
                    product.name.toLowerCase().includes(searchTerm)
                );
                renderProducts(filteredProducts);
            });

            // Category filter buttons
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const category = btn.dataset.category;
                    if (category === 'all') {
                        renderProducts(products);
                    } else {
                        const filteredProducts = products.filter(product => product.category === category);
                        renderProducts(filteredProducts);
                    }
                });
            });

            // Customer select change
            customerSelect.addEventListener('change', () => {
                // In a real app, you might apply customer-specific discounts here
                updateCartSummary();
            });

            // Payment modal events
            closeModalBtn.addEventListener('click', () => paymentModal.classList.add('hidden'));
            cancelPaymentBtn.addEventListener('click', () => paymentModal.classList.add('hidden'));

            paymentMethodSelect.addEventListener('change', (e) => {
                if (e.target.value === 'cash') {
                    document.getElementById('cash-payment').classList.remove('hidden');
                } else {
                    document.getElementById('cash-payment').classList.add('hidden');
                }
            });

            amountReceivedInput.addEventListener('input', () => {
                const amountReceived = parseFloat(amountReceivedInput.value) || 0;
                const total = calculateTotal();
                const change = amountReceived - total;
                changeAmountElement.textContent = `$${Math.max(0, change).toFixed(2)}`;
            });

            confirmPaymentBtn.addEventListener('click', completePayment);

            // Receipt modal events
            closeReceiptBtn.addEventListener('click', () => {
                receiptModal.classList.add('hidden');
                clearCart();
            });

            printReceiptBtn.addEventListener('click', () => {
                window.print();
            });
        }

        // Add product to cart
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);

            if (!product) return;

            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1
                });
            }

            updateCartDisplay();
        }

        // Update cart display
        function updateCartDisplay() {
            cartItems.innerHTML = '';

            if (cart.length === 0) {
                emptyCartMessage.classList.remove('hidden');
            } else {
                emptyCartMessage.classList.add('hidden');

                cart.forEach(item => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'flex justify-between items-center py-3 border-b';
                    cartItem.innerHTML = `
                        <div class="flex-1">
                            <h4 class="font-medium">${item.name}</h4>
                            <p class="text-sm text-gray-500">$${item.price.toFixed(2)} x ${item.quantity}</p>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium mr-4">$${(item.price * item.quantity).toFixed(2)}</span>
                            <div class="flex items-center">
                                <button class="decrease-quantity w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100"
                                        data-id="${item.id}">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="mx-2">${item.quantity}</span>
                                <button class="increase-quantity w-8 h-8 rounded-full border flex items-center justify-center hover:bg-gray-100"
                                        data-id="${item.id}">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <button class="remove-item ml-3 text-red-500 hover:text-red-700" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    cartItems.appendChild(cartItem);
                });

                // Add event listeners to quantity buttons
                document.querySelectorAll('.decrease-quantity').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const productId = parseInt(btn.dataset.id);
                        updateQuantity(productId, -1);
                    });
                });

                document.querySelectorAll('.increase-quantity').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const productId = parseInt(btn.dataset.id);
                        updateQuantity(productId, 1);
                    });
                });

                document.querySelectorAll('.remove-item').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const productId = parseInt(btn.dataset.id);
                        removeFromCart(productId);
                    });
                });
            }

            updateCartSummary();
        }

        // Update item quantity in cart
        function updateQuantity(productId, change) {
            const itemIndex = cart.findIndex(item => item.id === productId);

            if (itemIndex !== -1) {
                cart[itemIndex].quantity += change;

                if (cart[itemIndex].quantity <= 0) {
                    cart.splice(itemIndex, 1);
                }

                updateCartDisplay();
            }
        }

        // Remove item from cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
        }

        // Clear the cart
        function clearCart() {
            cart = [];
            updateCartDisplay();
        }

        // Calculate subtotal
        function calculateSubtotal() {
            return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }

        // Calculate tax (10% for this example)
        function calculateTax(subtotal) {
            return subtotal * 0.1;
        }

        // Calculate discount (based on customer type)
        function calculateDiscount(subtotal) {
            const customerType = customerSelect.value;

            switch (customerType) {
                case 'regular':
                    return subtotal * 0.05; // 5% discount
                case 'vip':
                    return subtotal * 0.1; // 10% discount
                default:
                    return 0;
            }
        }

        // Calculate total
        function calculateTotal() {
            const subtotal = calculateSubtotal();
            const tax = calculateTax(subtotal);
            const discount = calculateDiscount(subtotal);

            return subtotal + tax - discount;
        }

        // Update cart summary
        function updateCartSummary() {
            const subtotal = calculateSubtotal();
            const tax = calculateTax(subtotal);
            const discount = calculateDiscount(subtotal);
            const total = subtotal + tax - discount;

            subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
            taxElement.textContent = `$${tax.toFixed(2)}`;
            discountElement.textContent = `$${discount.toFixed(2)}`;
            totalElement.textContent = `$${total.toFixed(2)}`;
        }

        // Open payment modal
        function openPaymentModal() {
            const total = calculateTotal();
            modalTotalElement.textContent = `$${total.toFixed(2)}`;
            amountReceivedInput.value = '';
            changeAmountElement.textContent = '$0.00';
            paymentModal.classList.remove('hidden');
        }

        // Complete payment process
        function completePayment() {
            const paymentMethod = paymentMethodSelect.value;
            const total = calculateTotal();

            if (paymentMethod === 'cash') {
                const amountReceived = parseFloat(amountReceivedInput.value) || 0;

                if (amountReceived < total) {
                    alert('Amount received is less than the total amount.');
                    return;
                }
            }

            paymentModal.classList.add('hidden');
            showReceipt(paymentMethod);
        }

        // Show receipt
        function showReceipt(paymentMethod) {
            const subtotal = calculateSubtotal();
            const tax = calculateTax(subtotal);
            const discount = calculateDiscount(subtotal);
            const total = calculateTotal();
            const customer = customerSelect.options[customerSelect.selectedIndex].text;
            const orderNumber = orderNumberElement.textContent;

            // Set receipt date
            const now = new Date();
            receiptDateElement.textContent = now.toLocaleString();

            // Set receipt details
            receiptOrderNumberElement.textContent = orderNumber;
            receiptCustomerElement.textContent = customer;
            receiptSubtotalElement.textContent = `$${subtotal.toFixed(2)}`;
            receiptTaxElement.textContent = `$${tax.toFixed(2)}`;
            receiptTotalElement.textContent = `$${total.toFixed(2)}`;
            receiptPaymentMethodElement.textContent = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);

            // Set receipt items
            receiptItemsElement.innerHTML = '';
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between py-2 border-b';
                itemElement.innerHTML = `
                    <div>
                        <span>${item.name}</span>
                        <span class="text-sm text-gray-500 ml-2">x${item.quantity}</span>
                    </div>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                `;
                receiptItemsElement.appendChild(itemElement);
            });

            // Set change if payment was cash
            if (paymentMethod === 'cash') {
                const amountReceived = parseFloat(amountReceivedInput.value) || 0;
                const change = amountReceived - total;
                receiptChangeElement.textContent = `$${change.toFixed(2)}`;
                receiptChangeContainer.classList.remove('hidden');
            } else {
                receiptChangeContainer.classList.add('hidden');
            }

            // Show receipt modal
            receiptModal.classList.remove('hidden');

            // Generate a new order number for the next order
            generateOrderNumber();
        }

        // Initialize the application
        init();
    </script>
</body>
</html>
