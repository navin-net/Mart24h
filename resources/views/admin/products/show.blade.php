<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canvas Sneaker - Black</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
        --orange-primary: #ff6b35;
        --orange-light: #ff8c42;
    }

    .product-image-container {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 40px;
        position: relative;
    }

    .main-product-image {
        width: 100%;
        max-width: 400px;
        height: auto;
    }

    .discount-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: var(--orange-primary);
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 18px;
    }

    .thumbnail-container {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .thumbnail {
        width: 80px;
        height: 80px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.3s;
    }

    .thumbnail.active,
    .thumbnail:hover {
        border-color: var(--orange-primary);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .pagination-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 15px;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #dee2e6;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .dot.active {
        background-color: #6c757d;
    }

    .price {
        font-size: 24px;
        font-weight: bold;
        color: var(--orange-primary);
    }

    .rating {
        color: var(--orange-primary);
    }

    .btn-orange {
        background-color: var(--orange-primary);
        border-color: var(--orange-primary);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .btn-orange:hover {
        background-color: var(--orange-light);
        border-color: var(--orange-light);
        color: white;
    }

    .size-select {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 8px 12px;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: var(--orange-primary);
        border-bottom-color: var(--orange-primary);
        background-color: transparent;
    }

    .specifications-table {
        border: none;
    }

    .specifications-table td {
        border: none;
        padding: 8px 0;
    }

    .specifications-table td:first-child {
        color: #6c757d;
        width: 40%;
    }

    .other-variations h6 {
        font-size: 12px;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 15px;
    }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <!-- Product Images Section -->
            <div class="col-lg-6">
                <div class="product-image-container">
                    <div class="discount-badge">30%</div>
                    <div class="text-center">
                        <img src="/placeholder.svg?height=300&width=400" alt="Canvas Sneaker - Black"
                            class="main-product-image" id="mainImage">
                    </div>
                </div>

                <div class="pagination-dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>

                <div class="mt-4">
                    <h6 class="other-variations">OTHER VARIATIONS</h6>
                    <div class="thumbnail-container">
                        <div class="thumbnail active">
                            <img src="/placeholder.svg?height=60&width=60" alt="Black variation">
                        </div>
                        <div class="thumbnail">
                            <img src="/placeholder.svg?height=60&width=60" alt="Yellow variation">
                        </div>
                        <div class="thumbnail">
                            <img src="/placeholder.svg?height=60&width=60" alt="Pink variation">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <div class="mb-2">
                        <small class="text-muted">NEW | LIFESTYLE | ABRAHAM | FOR TOP</small>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">PRODUCT CODE: 126786SFG</small>
                    </div>

                    <h1 class="h2 mb-3">CANVAS SNEAKER - BLACK</h1>

                    <div class="d-flex align-items-center mb-3">
                        <span class="price me-3">$ 70 / € 65</span>
                        <div class="rating me-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <small class="text-muted">(7) reviews</small>
                    </div>

                    <p class="text-muted mb-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">SIZE</label>
                            <select class="form-select size-select">
                                <option>UK</option>
                                <option>US</option>
                                <option>EU</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">SIZE</label>
                            <select class="form-select size-select">
                                <option>SIZE</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">SIZE GUIDE</label>
                            <div class="pt-2">
                                <a href="#" class="text-decoration-none text-muted small">Size Guide</a>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-orange w-100 mb-4">ADD TO CART</button>

                    <div class="border-top pt-3">
                        <h6 class="small text-muted mb-2">DELIVERY ESTIMATE</h6>
                        <p class="small text-muted mb-0">Next day delivery available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                            type="button" role="tab">
                            DETAIL
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="size-detail-tab" data-bs-toggle="tab" data-bs-target="#size-detail"
                            type="button" role="tab">
                            SIZE DETAIL
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="return-policy-tab" data-bs-toggle="tab"
                            data-bs-target="#return-policy" type="button" role="tab">
                            RETURN POLICY
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="delivery-info-tab" data-bs-toggle="tab"
                            data-bs-target="#delivery-info" type="button" role="tab">
                            DELIVERY INFO
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="productTabsContent">
                    <div class="tab-pane fade show active" id="detail" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table specifications-table">
                                    <tr>
                                        <td>SKU</td>
                                        <td>A5DFGHJK3678GZ</td>
                                    </tr>
                                    <tr>
                                        <td>Upper Material</td>
                                        <td>Leather</td>
                                    </tr>
                                    <tr>
                                        <td>Inner Material</td>
                                        <td>Leather</td>
                                    </tr>
                                    <tr>
                                        <td>Sole Material</td>
                                        <td>Synthetic</td>
                                    </tr>
                                    <tr>
                                        <td>Inner Sole Material</td>
                                        <td>Synthetic</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="size-detail" role="tabpanel">
                        <p>Size details and measurements will be displayed here.</p>
                    </div>

                    <div class="tab-pane fade" id="return-policy" role="tabpanel">
                        <p>Return policy information will be displayed here.</p>
                    </div>

                    <div class="tab-pane fade" id="delivery-info" role="tabpanel">
                        <p>Delivery information will be displayed here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Thumbnail click functionality
    document.querySelectorAll('.thumbnail').forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));

            // Add active class to clicked thumbnail
            this.classList.add('active');

            // Update main image (in a real application, you would change the src)
            const mainImage = document.getElementById('mainImage');
            const variations = [
                '/placeholder.svg?height=300&width=400',
                '/placeholder.svg?height=300&width=400',
                '/placeholder.svg?height=300&width=400'
            ];

            if (variations[index]) {
                mainImage.src = variations[index];
            }
        });
    });

    // Pagination dots functionality
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.addEventListener('click', function() {
            document.querySelectorAll('.dot').forEach(d => d.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Add to cart functionality
    document.querySelector('.btn-orange').addEventListener('click', function() {
        alert('Product added to cart!');
    });
    </script>
</body>

</html>