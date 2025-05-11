
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern POS System</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Animate.css for animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --light-gray: #f8f9fa;
            --dark-gray: #212529;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        .sidebar {
            background-color: var(--dark-gray);
            transition: all 0.3s ease;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        .product-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .badge-accent {
            background-color: var(--accent-color);
            color: white;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Sidebar -->
            <div class="col-auto px-0 bg-dark sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-4 text-white min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-0 text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline animate__animated animate__fadeIn">POS System</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link active text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-home me-2"></i> <span class="d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-shopping-cart me-2"></i> <span class="d-none d-sm-inline">Sales</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-box me-2"></i> <span class="d-none d-sm-inline">Inventory</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-users me-2"></i> <span class="d-none d-sm-inline">Customers</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-chart-bar me-2"></i> <span class="d-none d-sm-inline">Reports</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" class="nav-link sidebar-link text-white px-3 py-3 d-flex align-items-center">
                                <i class="fs-4 fas fa-cog me-2"></i> <span class="d-none d-sm-inline">Settings</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4 w-100">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/api/placeholder/40/40" alt="User" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-2">Cashier</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <!-- Top Navigation -->
                    <div class="row mb-4 fade-in">
                        <div class="col-md-8">
                            <h2 class="fw-bold">Point of Sale</h2>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-success p-2 me-2">
                                <i class="fas fa-wifi me-1"></i> Online
                            </span>
                            <span class="badge bg-primary p-2">
                                <i class="far fa-clock me-1"></i> <span id="current-time">00:00:00</span>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Products Section -->
                        <div class="col-lg-8 mb-4">
                            <!-- Search Bar -->
                            <div class="input-group mb-3 shadow-sm slide-in">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Search products..." id="product-search">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                                    <i class="fas fa-barcode"></i>
                                </button>
                            </div>

                            <!-- Product Categories -->
                            <div class="d-flex flex-wrap mb-4 slide-in" style="animation-delay: 0.1s">
                                <button class="btn btn-sm btn-primary me-2 mb-2 active" data-category="all">All</button>
                                <button class="btn btn-sm btn-outline-secondary me-2 mb-2" data-category="food">Food</button>
                                <button class="btn btn-sm btn-outline-secondary me-2 mb-2" data-category="beverage">Beverages</button>
                                <button class="btn btn-sm btn-outline-secondary me-2 mb-2" data-category="snack">Snacks</button>
                                <button class="btn btn-sm btn-outline-secondary me-2 mb-2" data-category="electronics">Electronics</button>
                                <button class="btn btn-sm btn-outline-secondary me-2 mb-2" data-category="household">Household</button>
                            </div>

                            <!-- Products Grid -->
                            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 products-container">
                                <!-- Product 1 -->
                                <div class="col slide-in" style="animation-delay: 0.15s" data-category="food">
                                    <div class="card h-100 product-card shadow-sm" data-id="1" data-name="Sandwich" data-price="5.99">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Sandwich">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Sandwich</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$5.99</p>
                                            <span class="badge bg-light text-dark">In Stock: 15</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 2 -->
                                <div class="col slide-in" style="animation-delay: 0.2s" data-category="beverage">
                                    <div class="card h-100 product-card shadow-sm" data-id="2" data-name="Coffee" data-price="3.49">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Coffee">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Coffee</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$3.49</p>
                                            <span class="badge bg-light text-dark">In Stock: 28</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 3 -->
                                <div class="col slide-in" style="animation-delay: 0.25s" data-category="snack">
                                    <div class="card h-100 product-card shadow-sm" data-id="3" data-name="Chips" data-price="1.99">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Chips">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Chips</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$1.99</p>
                                            <span class="badge bg-light text-dark">In Stock: 42</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 4 -->
                                <div class="col slide-in" style="animation-delay: 0.3s" data-category="beverage">
                                    <div class="card h-100 product-card shadow-sm" data-id="4" data-name="Soda" data-price="1.49">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Soda">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Soda</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$1.49</p>
                                            <span class="badge bg-light text-dark">In Stock: 56</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 5 -->
                                <div class="col slide-in" style="animation-delay: 0.35s" data-category="electronics">
                                    <div class="card h-100 product-card shadow-sm" data-id="5" data-name="USB Cable" data-price="12.99">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="USB Cable">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">USB Cable</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$12.99</p>
                                            <span class="badge bg-light text-dark">In Stock: 23</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 6 -->
                                <div class="col slide-in" style="animation-delay: 0.4s" data-category="household">
                                    <div class="card h-100 product-card shadow-sm" data-id="6" data-name="Soap" data-price="2.49">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Soap">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Soap</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$2.49</p>
                                            <span class="badge bg-light text-dark">In Stock: 38</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 7 -->
                                <div class="col slide-in" style="animation-delay: 0.45s" data-category="food">
                                    <div class="card h-100 product-card shadow-sm" data-id="7" data-name="Pizza Slice" data-price="4.29">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Pizza Slice">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Pizza Slice</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$4.29</p>
                                            <span class="badge bg-light text-dark">In Stock: 18</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product 8 -->
                                <div class="col slide-in" style="animation-delay: 0.5s" data-category="electronics">
                                    <div class="card h-100 product-card shadow-sm" data-id="8" data-name="Headphones" data-price="24.99">
                                        <img src="/api/placeholder/200/150" class="card-img-top p-2" alt="Headphones">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1">Headphones</h6>
                                            <p class="card-text text-primary fw-bold mb-1">$24.99</p>
                                            <span class="badge bg-light text-dark">In Stock: 9</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <nav class="mt-4 slide-in" style="animation-delay: 0.6s">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Cart Section -->
                        <div class="col-lg-4">
                            <div class="card shadow fade-in" style="animation-delay: 0.3s">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Current Sale</h5>
                                        <button class="btn btn-sm btn-outline-danger" id="clear-cart">
                                            <i class="fas fa-trash-alt me-1"></i> Clear
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush cart-items" style="max-height: 420px; overflow-y: auto;">
                                        <div class="list-group-item py-3 cart-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Coffee</h6>
                                                    <small class="text-muted">$3.49 x 1</small>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold me-3">$3.49</span>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="decrease">-</button>
                                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="increase">+</button>
                                                        <button type="button" class="btn btn-outline-danger remove-item">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item py-3 cart-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Sandwich</h6>
                                                    <small class="text-muted">$5.99 x 2</small>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold me-3">$11.98</span>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="decrease">-</button>
                                                        <button type="button" class="btn btn-outline-secondary qty-btn" data-action="increase">+</button>
                                                        <button type="button" class="btn btn-outline-danger remove-item">×</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span class="fw-bold" id="subtotal">$15.47</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax (8%):</span>
                                            <span class="fw-bold" id="tax">$1.24</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="h5 mb-0">Total:</span>
                                            <span class="h5 mb-0" id="total">$16.71</span>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                            <i class="fas fa-credit-card me-2"></i> Proceed to Payment
                                        </button>
                                        <button class="btn btn-outline-secondary">
                                            <i class="fas fa-save me-2"></i> Save Order
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card shadow mt-3 fade-in" style="animation-delay: 0.4s">
                                <div class="card-header bg-white py-3">
                                    <h5 class="card-title mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-outline-primary">
                                            <i class="fas fa-receipt"></i>
                                            <span class="d-block small">Orders</span>
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="fas fa-percent"></i>
                                            <span class="d-block small">Discount</span>
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="fas fa-user-plus"></i>
                                            <span class="d-block small">Customer</span>
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="fas fa-print"></i>
                                            <span class="d-block small">Print</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Scanner Modal -->
    <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeModalLabel">Scan Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4 p-3 border rounded">
                        <img src="/api/placeholder/320/240" alt="Barcode Scanner" class="img-fluid">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Barcode Number" id="barcode-input" autofocus>
                        <button class="btn btn-primary" type="button">Scan</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5">Total Amount:</span>
                        <span class="h5 text-primary">$16.71</span>
                    </div>

                    <ul class="nav nav-pills mb-3" id="payment-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="cash-tab" data-bs-toggle="pill" data-bs-target="#cash-content" type="button" role="tab" aria-controls="cash-content" aria-selected="true">Cash</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="card-tab" data-bs-toggle="pill" data-bs-target="#card-content" type="button" role="tab" aria-controls="card-content" aria-selected="false">Card</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mobile-tab" data-bs-toggle="pill" data-bs-target="#mobile-content" type="button" role="tab" aria-controls="mobile-content" aria-selected="false">Mobile Pay</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="payment-content">
                        <!-- Cash Payment -->
                        <div class="tab-pane fade show active" id="cash-content" role="tabpanel" aria-labelledby="cash-tab">
                            <div class="mb-3">
                                <label for="cash-amount" class="form-label">Cash Received</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="cash-amount" value="20.00">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quick Amount</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-outline-secondary cash-btn" data-amount="20">$20</button>
                                    <button class="btn btn-outline-secondary cash-btn" data-amount="50">$50</button>
                                    <button class="btn btn-outline-secondary cash-btn" data-amount="100">$100</button>
                                </div>
                            </div>
                            <div class="alert alert-success">
                                <div class="d-flex justify-content-between">
                                    <span>Change Due:</span>
                                    <span class="fw-bold">$3.29</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Payment -->
                        <div class="tab-pane fade" id="card-content" role="tabpanel" aria-labelledby="card-tab">
                            <div class="text-center mb-3">
                                <img src="/api/placeholder/320/200" alt="Card Terminal" class="img-fluid border rounded">
                            </div>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i> Please insert or tap card on the terminal
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <!-- Mobile Payment -->
                        <div class="tab-pane fade" id="mobile-content" role="tabpanel" aria-labelledby="mobile-tab">
                            <div class="text-center mb-3">
                                <img src="/api/placeholder/250/250" alt="QR Code" class="img-fluid border rounded">
                            </div>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-qrcode me-2"></i> Scan the QR code with your mobile payment app
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="complete-payment">Complete Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Payment Successful</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4>Transaction Complete!</h4>
                    <p>Receipt #: INV-2023-05-09-0042</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-print me-2"></i> Print Receipt
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i> Email Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount Modal -->
    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountModalLabel">Apply Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Discount Type</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="discount-type" id="discount-percentage" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="discount-percentage">Percentage (%)</label>

                            <input type="radio" class="btn-check" name="discount-type" id="discount-amount" autocomplete="off">
                            <label class="btn btn-outline-primary" for="discount-amount">Fixed Amount ($)</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="discount-value" class="form-label">Discount Value</label>
                        <div class="input-group">
                            <span class="input-group-text discount-symbol">%</span>
                            <input type="number" class="form-control" id="discount-value" value="10">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="discount-reason" class="form-label">Reason (Optional)</label>
                        <select class="form-select" id="discount-reason">
                            <option value="">Select reason...</option>
                            <option value="promotion">Promotion</option>
                            <option value="loyalty">Loyalty Program</option>
                            <option value="damage">Product Damage</option>
                            <option value="employee">Employee Discount</option>
                            <option value="manager">Manager Approval</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Apply Discount</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Current Time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('current-time').textContent = timeString;
        }

        setInterval(updateTime, 1000);
        updateTime();

        // Product Search Functionality
        const productSearch = document.getElementById('product-search');
        const productCards = document.querySelectorAll('.product-card');

        productSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();

            productCards.forEach(card => {
                const productName = card.getAttribute('data-name').toLowerCase();
                if (productName.includes(searchTerm) || searchTerm === '') {
                    card.closest('.col').style.display = 'block';
                } else {
                    card.closest('.col').style.display = 'none';
                }
            });
        });

        // Category Filter
        const categoryButtons = document.querySelectorAll('[data-category]');
        const productItems = document.querySelectorAll('[data-category]');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Toggle active state
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                if (button.classList.contains('btn-outline-secondary')) {
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-outline-secondary');
                    });
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-primary');
                }

                // Filter products
                if (category === 'all') {
                    productItems.forEach(item => {
                        item.style.display = 'block';
                    });
                } else {
                    productItems.forEach(item => {
                        if (item.getAttribute('data-category') === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }
            });
        });

        // Add product to cart
        productCards.forEach(card => {
            card.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');

                // Animation effect
                this.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__animated', 'animate__pulse');
                }, 500);

                // Add to cart logic would go here
                // For demo purposes, we'll just show a toast notification
                const toastHTML = `
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fas fa-check-circle me-2"></i> Added ${productName} to cart
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.insertAdjacentHTML('beforeend', toastHTML);
                const toastEl = document.querySelector('.toast');
                const toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 2000
                });
                toast.show();

                // Remove toast after it's hidden
                toastEl.addEventListener('hidden.bs.toast', function() {
                    this.parentNode.remove();
                });
            });
        });

        // Cart item quantity buttons
        const qtyButtons = document.querySelectorAll('.qty-btn');
        qtyButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const action = this.getAttribute('data-action');
                const cartItem = this.closest('.cart-item');

                // Animation effect
                cartItem.classList.add('animate__animated', 'animate__fadeIn');
                setTimeout(() => {
                    cartItem.classList.remove('animate__animated', 'animate__fadeIn');
                }, 500);

                // Quantity update logic would go here
            });
        });

        // Remove cart item
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const cartItem = this.closest('.cart-item');

                // Animation effect
                cartItem.classList.add('animate__animated', 'animate__fadeOutRight');
                setTimeout(() => {
                    // Remove logic would go here
                    // For demo, we'll just hide it
                    cartItem.style.display = 'none';
                }, 500);
            });
        });

        // Clear cart button
        const clearCartButton = document.getElementById('clear-cart');
        clearCartButton.addEventListener('click', function() {
            const cartItems = document.querySelectorAll('.cart-item');

            cartItems.forEach(item => {
                item.classList.add('animate__animated', 'animate__fadeOut');
            });

            setTimeout(() => {
                // Clear logic would go here
                // For demo, we'll just hide them
                cartItems.forEach(item => {
                    item.style.display = 'none';
                });

                document.getElementById('subtotal').textContent = '$0.00';
                document.getElementById('tax').textContent = '$0.00';
                document.getElementById('total').textContent = '$0.00';
            }, 500);
        });

        // Cash payment quick amount buttons
        const cashButtons = document.querySelectorAll('.cash-btn');
        cashButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                document.getElementById('cash-amount').value = amount;

                // Calculate change
                const total = 16.71; // This would normally be dynamic
                const change = (parseFloat(amount) - total).toFixed(2);
                document.querySelector('.alert-success .fw-bold').textContent = ' + change;
            });
        });

        // Complete payment button
        document.getElementById('complete-payment').addEventListener('click', function() {
            const paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            paymentModal.hide();

            setTimeout(() => {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }, 500);
        });

        // Discount type toggle
        document.getElementById('discount-percentage').addEventListener('change', function() {
            if (this.checked) {
                document.querySelector('.discount-symbol').textContent = '%';
            }
        });

        document.getElementById('discount-amount').addEventListener('change', function() {
            if (this.checked) {
                document.querySelector('.discount-symbol').textContent = ';
            }
        });

        // Animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation classes to elements with animation delays
            const animatedElements = document.querySelectorAll('.fade-in, .slide-in');
            animatedElements.forEach(element => {
                element.classList.add('animate__animated');

                if (element.classList.contains('fade-in')) {
                    element.classList.add('animate__fadeIn');
                } else if (element.classList.contains('slide-in')) {
                    element.classList.add('animate__fadeInUp');
                }
            });
        });
    </script>
</body>
</html>
