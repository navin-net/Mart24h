@extends('admin.master')

@section('title', 'Point of Sale')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    <style>
        .stats-card {
            padding: 20px;
            border-radius: 8px;
            background: var(--card-bg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .payment-btn {
            width: 100%;
            margin-bottom: 10px;
        }
        .cart-item {
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .quantity-controls button {
            width: 30px;
        }
        .product-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-image {
            font-size: 2rem;
            text-align: center;
            padding: 20px;
        }
        .display-status.connected {
            color: green;
        }
        .display-status.disconnected {
            color: red;
        }
        .list-group-item.category-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        /* Ensure modals and offcanvas appear above other elements */
        .modal, .offcanvas {
            z-index: 1055;
        }
        /* Adjust modal backdrop to avoid conflicts with sidebar */
        .modal-backdrop {
            z-index: 1050;
        }
        /* Optimize offcanvas animation */
        .offcanvas {
            transition: transform 0.2s ease-in-out !important;
        }
        .offcanvas-backdrop {
            transition: opacity 0.2s ease-in-out !important;
        }
        /* Loading spinner */
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Disable animations for reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .offcanvas, .offcanvas-backdrop {
                transition: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Products Section -->
            <div class="col-lg-8 col-md-7">
                <div class="p-3">
                    <!-- Customer Display Controls -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <h6>
                                <i class="bi bi-display"></i> Customer Display
                                <span id="displayStatus" class="display-status disconnected"></span>
                                <span id="displayStatusText">Disconnected</span>
                            </h6>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-warning btn-sm" onclick="reset()">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Search, Sort & Offcanvas Category Toggle -->
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control search-bar" id="searchInput" placeholder="Search products...">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <select class="form-select" id="sortSelect" aria-label="Sort products">
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="price-asc">Price (Low to High)</option>
                                <option value="price-desc">Price (High to Low)</option>
                                <option value="created-desc">Newest First</option>
                                <option value="created-asc">Oldest First</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas"
                            aria-controls="filterOffcanvas">
                                Filters  <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row" id="product-list">
                        @include('admin.partials.product-list')
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="col-lg-4 col-md-5">
                <div class="cart-sidebar p-3 card">
                    <h4>
                        <i class="bi bi-cart3"></i> Current Order
                        <span class="badge bg-primary ms-2" id="cartCount">0</span>
                    </h4>
                    <div id="cartItems">
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-cart-x display-4"></i>
                            <p class="mt-2">No items in cart</p>
                        </div>
                    </div>
                    <div class="total-section mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (8%):</span>
                            <span id="tax">$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fs-4 fw-bold">
                            <span>Total:</span>
                            <span id="total">$0.00</span>
                        </div>
                    </div>
                    <div class="payment-section mt-3">
                        <button class="btn btn-success payment-btn" onclick="processPayment('cash')">
                            <i class="bi bi-cash"></i> Cash Payment
                        </button>
                        <!-- <button class="btn btn-primary payment-btn" onclick="processPayment('card')">
                            <i class="bi bi-credit-card"></i> Card Payment
                        </button> -->
                        <button class="btn btn-warning payment-btn" data-bs-toggle="modal" data-bs-target="#bankSelectModal">
                            <i class="bi bi-phone"></i> Digital Wallet
                        </button>
                        <button class="btn btn-danger payment-btn" onclick="clearCart()">
                            <i class="bi bi-trash"></i> Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Selection Modal -->
    <div class="modal fade" id="bankSelectModal" tabindex="-1" aria-labelledby="bankSelectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bankSelectModalLabel">Select Bank for Digital Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bankSelect" class="form-label">Choose a Bank</label>
                        <select class="form-select" id="bankSelect">
                            <option value="" disabled selected>Select a bank</option>
                            <option value="bank_acleda">Acleda Bank</option>
                            <option value="bank_aba">ABA Bank</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmDigitalPayment()">Confirm</button>
                </div>
            </div>
        </div>
    </div>


<!-- Combined Offcanvas for Categories & Brands -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <!-- Categories Column -->
            <div class="col-6">
                <h6>Categories</h6>
                <div class="list-group" id="offcanvasCategoryList">
                    <button type="button" class="list-group-item list-group-item-action category-btn active" data-category="all">All</button>
                    @foreach ($categories as $category)
                        <button type="button" class="list-group-item list-group-item-action category-btn" data-category="{{ $category->slug }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Brands Column -->
            <div class="col-6">
                <h6>Brands</h6>
                <div class="list-group" id="offcanvasBrandList">
                    <button type="button" class="list-group-item list-group-item-action brand-btn active" data-brand="all">All</button>
                    @foreach ($brands as $brand)
                        <button type="button" class="list-group-item list-group-item-action brand-btn" data-brand="{{ $brand->slug }}">
                            {{ $brand->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Offcanvas for Categories -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="categoryOffcanvas" aria-labelledby="categoryOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="categoryOffcanvasLabel">Categories</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group" id="offcanvasCategoryList">
                <button type="button" class="list-group-item list-group-item-action category-btn active" data-category="all">All</button>
                @foreach ($categories as $category)
                    <button type="button" class="list-group-item list-group-item-action category-btn" data-category="{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel"><i class="bi bi-receipt"></i> Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="receipt" id="receiptContent"></div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary" onclick="printReceipt()">
                            <i class="bi bi-printer"></i> Print Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        let cart = [];

        // Add to cart via event delegation
        $(document).on('click', '.product-card', function() {
            const productId = $(this).data('id');
            const productName = $(this).find('.card-title').text();
            const productPrice = parseFloat($(this).find('.card-text').text().replace('$', ''));

            let existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
            }
            updateCart();
        });

        function updateCart() {
            const cartItems = $('#cartItems');
            cartItems.empty();

            if (cart.length === 0) {
                cartItems.html('<div class="text-center text-muted py-5"><i class="bi bi-cart-x display-4"></i><p class="mt-2">No items in cart</p></div>');
                $('#cartCount').text(0);
                // $('#subtotal').text('$0.00');
                // $('#tax').text('$0.00');
                // $('#total').text('$0.00');
                return;
            }

            let subtotal = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                cartItems.append(`
                    <div class="cart-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6>${item.name}</h6>
                            <p class="mb-0">$${item.price.toFixed(2)} x ${item.quantity}</p>
                        </div>
                        <div class="quantity-controls">
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, -1)">-</button>
                            <span>${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, 1)">+</button>
                        </div>
                    </div>
                `);
            });

            const tax = subtotal * 0.01;
            const total = subtotal + tax;

            $('#cartCount').text(cart.length);
            $('#subtotal').text(`$${subtotal.toFixed(2)}`);
            $('#tax').text(`$${tax.toFixed(2)}`);
            $('#total').text(`$${total.toFixed(2)}`);
        }

        function updateQuantity(productId, change) {
            let item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    cart = cart.filter(i => i.id !== productId);
                }
                updateCart();
            }
        }

        function clearCart() {
            cart = [];
            updateCart();
        }

        function processPayment(method, bank = null) {
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Cart',
                    text: 'Your cart is empty!',
                });
                return;
            }

            if (method === 'digital' && !bank) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bank Required',
                    text: 'Please select a bank for digital payment.',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `Proceed with ${method.charAt(0).toUpperCase() + method.slice(1)} payment${bank ? ` via ${bank.replace('bank_', '').toUpperCase()}` : ''}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pos.process-payment') }}',
                        method: 'POST',
                        data: {
                            cart: cart,
                            payment_method: method,
                            bank: bank
                        },
                        success: function(response) {
                            if (response.success) {
                                showReceiptModal(response.receipt);
                                clearCart();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Success',
                                    text: 'Receipt generated successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Failed',
                                text: xhr.responseJSON?.message || 'An error occurred during payment processing.',
                            });
                        }
                    });
                }
            });
        }

        function confirmDigitalPayment() {
            const bank = $('#bankSelect').val();
            if (!bank) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Bank Selected',
                    text: 'Please select a bank to proceed with the digital payment.',
                });
                return;
            }
            const bankModal = bootstrap.Modal.getInstance(document.getElementById('bankSelectModal'));
            bankModal.hide();
            processPayment('digital', bank);
        }

        // Efficient receipt modal usage: reuse modal instance and insert content before show
        function showReceiptModal(receiptHtml) {
            const receiptModalEl = document.getElementById('receiptModal');
            $('#receiptContent').html(receiptHtml);

            // Reuse modal instance if exists, else create new
            let receiptModal = bootstrap.Modal.getInstance(receiptModalEl);
            if (!receiptModal) {
                receiptModal = new bootstrap.Modal(receiptModalEl);
            }
            receiptModal.show();
        }

        function printReceipt() {
            const receiptContent = $('#receiptContent').html();
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; background: #fff; color: #000; }
                            .receipt { max-width: 300px; margin: 0 auto; border: 1px dashed #ccc; padding: 15px; background: #fdfdfd; }
                            .receipt h4, .receipt h5 { text-align: center; margin-bottom: 5px; }
                            .receipt small { display: block; text-align: center; margin-bottom: 10px; color: #666; }
                            .receipt hr { border-top: 1px dashed #999; margin: 10px 0; }
                            .receipt table { width: 100%; font-size: 14px; border-collapse: collapse; }
                            .receipt table th, .receipt table td { padding: 4px 0; }
                            .receipt .text-end { text-align: right; }
                            .receipt .totals { font-weight: bold; }
                            .receipt .footer { text-align: center; margin-top: 10px; font-size: 12px; color: #555; }
                        </style>
                        <title>Receipt</title>
                    </head>
                    <body>
                        <div class="receipt">${receiptContent}</div>
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        // Filtering & Search Logic (keep your debounce function)
        $('#searchInput').on('input', debounce(function() {
            applyFilters();
        }, 300));

        $('#clearSearch').on('click', function() {
            $('#searchInput').val('');
            applyFilters();
        });

        $('#sortSelect').on('change', function() {
            applyFilters();
        });

        // Category buttons inside Offcanvas
        $('#offcanvasCategoryList').on('click', '.category-btn', function() {
            if ($(this).hasClass('active')) {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('categoryOffcanvas'));
                if (offcanvas) offcanvas.hide();
                return;
            }

            $('#offcanvasCategoryList .category-btn').removeClass('active');
            $(this).addClass('active');

            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('categoryOffcanvas'));
            if (offcanvas) offcanvas.hide();

            setTimeout(() => {
                applyFilters();
            }, 50);
        });
        $('#offcanvasBrandList').on('click', '.brand-btn', function() {
            if ($(this).hasClass('active')) {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('filterOffcanvas'));
                if (offcanvas) offcanvas.hide();
                return;
            }

            $('#offcanvasBrandList .brand-btn').removeClass('active');
            $(this).addClass('active');

            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('filterOffcanvas'));
            if (offcanvas) offcanvas.hide();

            setTimeout(() => {
                applyFilters();
            }, 50);
        });


        function applyFilters() {
            const query = $('#searchInput').val().toLowerCase();
            const category = $('#offcanvasCategoryList .category-btn.active').data('category') || 'all';
            const brand = $('#offcanvasBrandList .brand-btn.active').data('brand') || 'all';
            const sort = $('#sortSelect').val();

            $('#product-list').html('<div class="text-center py-5"><i class="bi bi-arrow-clockwise spin"></i> Loading...</div>');

            $.ajax({
                url: '{{ route('pos.filter') }}',
                method: 'GET',
                data: { query, category, sort, brand },
                success: function(response) {
                    $('#product-list').html(response);
                    // No manual modal/offcanvas event listeners here! Bootstrap handles them.
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON?.message || 'Error filtering products.',
                    });
                    $('#product-list').html('<div class="text-center py-5">Error loading products.</div>');
                }
            });
        }

        // Debounce utility (keep as is)
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        }

        // Customer display functions (placeholders)
        function handleCustomerDisplayOpen() { /* Implement WebSocket or API connection */ }
        function testCustomerDisplay() {
            $('#displayStatus').removeClass('disconnected').addClass('connected');
            $('#displayStatusText').text('Connected');
        }
        function reset() {
            location.reload();
        }

        // Initialize cart on page load
        $(document).ready(() => {
            updateCart();
            // No manual modal/offcanvas event listeners here
        });
    </script>

@endsection