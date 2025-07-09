@extends('shop.layouts.app')

@section('title', 'sasasa')
@section('content')

@push('style')
<style> 
    /* Product detail specific styles */
    .product-main {
        animation: fadeIn 0.8s ease-out;
    }
    
    .product-info {
        animation: slideInRight 0.8s ease-out;
    }
    
    .product-gallery {
        position: relative;
    }
    
    .gallery-main {
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .gallery-main img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-main:hover img {
        transform: scale(1.05);
    }
    
    .gallery-thumbs {
        display: flex;
        gap: 10px;
    }
     .gallery-thumb {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            opacity: 0.7;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .gallery-thumb.active {
            opacity: 1;
            border-color: #3a86ff;
        }
        
        .gallery-thumb:hover {
            opacity: 1;
        }
        
        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #3a86ff;
        }
        
        .product-original-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 1.2rem;
        }
        
        .product-discount {
            background-color: #ff3a5e;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-left: 10px;
        }
   .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }
        
        .color-option:hover, .color-option.active {
            transform: scale(1.1);
            border-color: #3a86ff;
        }
        
        .color-black {
            background-color: #000;
        }
        
        .color-silver {
            background-color: #c0c0c0;
        }
        
        .color-blue {
            background-color: #3a86ff;
        }
        
        .color-red {
            background-color: #ff3a5e;
        }
        
        .quantity-selector {
            width: 120px;
        }
        
        .product-features {
            margin-top: 20px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(58, 134, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #3a86ff;
        }
        
        .product-tabs {
            margin-top: 50px;
        }
</style>
@endpush

    <!-- Breadcrumb -->

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
    <!-- Product Main Section -->
    <section class="py-5 product-main">
        <div class="container">
            
            <div class="row">
                <!-- Product Gallery -->
            <div class="col-md-6 product-gallery">
                <div class="gallery-main">
                    <img src="{{ $product->main_image }}" id="mainImage" alt="{{ $product->thumbnails[0]->alt_text ?? $product->name }}">
                </div>

                <div class="gallery-thumbs">
                    @foreach($product->thumbnails as $index => $thumb)
                        <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }}" data-src="{{ $thumb->image }}">
                            <img src="{{ $thumb->thumbnail }}" alt="{{ $thumb->alt_text }}">
                        </div>
                    @endforeach
                </div>
            </div>

                
                <!-- Product Info -->
                <div class="col-md-6 product-info">
                    <h1 class="mb-2">{{ $product->name }}</h1>
                    <div class="d-flex align-items-center mb-3">
                        <div class="star-rating me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                            </svg>
                        </div>
                        <span>4.8 (128 reviews)</span>
                    </div>
                    <div class="mb-4">
                        <span class="product-price">$149.99</span>
                        <span class="product-original-price ms-2">$199.99</span>
                        <span class="product-discount">25% OFF</span>
                    </div>
                    <p class="mb-4">The Smart Watch Pro is the perfect companion for your active lifestyle. With advanced health monitoring, notifications, and a sleek design, it's the ultimate smartwatch for tech enthusiasts.</p>
                    
                    <!-- Color Options -->
                    <div class="mb-4">
                        <h6 class="mb-2">Color</h6>
                        <div>
                            <span class="color-option color-black active" data-color="Black" title="Black"></span>
                            <span class="color-option color-silver" data-color="Silver" title="Silver"></span>
                            <span class="color-option color-blue" data-color="Blue" title="Blue"></span>
                            <span class="color-option color-red" data-color="Red" title="Red"></span>
                        </div>
                        <div class="mt-2">
                            <span id="selectedColor">Black</span>
                        </div>
                    </div>
                    
                    <!-- Quantity and Add to Cart -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="quantity-selector me-3">
                        <div class="cart-item-quantity">
                        <div class="quantity-btn decrement-quantity">-</div>
                        <span>1</span>
                        <div class="quantity-btn increment-quantity">+</div>
                        </div>
                        </div>
                        <!-- <button class="btn btn-primary-custom w-100 add-to-cart-btn">Add to Cart</button> -->

                        <button class="btn btn-primary-custom w-50 add-to-cart-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus me-2" viewBox="0 0 16 16">
                                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 0h6a2 2 0 1 0 0 0h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 13.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                    
                    <!-- Product Features -->
                    <div class="product-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-pulse" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053.918 3.995.78 5.323 1.508 7H.43c-2.128-5.697 4.165-8.83 7.394-5.857.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17c3.23-2.974 9.522.159 7.394 5.856h-1.078c.728-1.677.59-3.005.108-3.947C13.486.878 10.4.28 8.717 2.01L8 2.748ZM2.212 10h1.315C4.593 11.183 6.05 12.458 8 13.795c1.949-1.337 3.407-2.612 4.473-3.795h1.315c-1.265 1.566-3.14 3.25-5.788 5-2.648-1.75-4.523-3.434-5.788-5Z"/>
                                    <path d="M10.464 3.314a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8H.5a.5.5 0 0 0 0 1H4a.5.5 0 0 0 .416-.223l1.473-2.209 1.647 4.118a.5.5 0 0 0 .945-.049l1.598-5.593 1.457 3.642A.5.5 0 0 0 12 9h3.5a.5.5 0 0 0 0-1h-3.162l-1.874-4.686Z"/>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-0">Health Monitoring</h6>
                                <p class="mb-0 text-muted">Track heart rate, sleep, and activity</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-battery-charging" viewBox="0 0 16 16">
                                    <path d="M9.585 2.568a.5.5 0 0 1 .226.58L8.677 6.832h1.99a.5.5 0 0 1 .364.843l-5.334 5.667a.5.5 0 0 1-.842-.49L5.99 9.167H4a.5.5 0 0 1-.364-.843l5.333-5.667a.5.5 0 0 1 .616-.09z"/>
                                    <path d="M2 4h4.332l-.94 1H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2.38l-.308 1H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                                    <path d="M2 6h2.45L2.908 7.639A1.5 1.5 0 0 0 3.313 10H2V6zm8.595-2-.308 1H12a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H9.276l-.942 1H12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.405z"/>
                                    <path d="M12 10h-1.783l1.542-1.639c.097-.103.178-.218.241-.34V10zm0-3.354V6h-.646a1.5 1.5 0 0 1 .646.646zM16 8a1.5 1.5 0 0 1-1.5 1.5v-3A1.5 1.5 0 0 1 16 8z"/>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-0">Long Battery Life</h6>
                                <p class="mb-0 text-muted">Up to 7 days on a single charge</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-water" viewBox="0 0 16 16">
                                    <path d="M.036 3.314a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0L.314 3.964a.5.5 0 0 1-.278-.65zm0 3a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0L.314 6.964a.5.5 0 0 1-.278-.65zm0 3a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0L.314 9.964a.5.5 0 0 1-.278-.65zm0 3a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.757-.703a.5.5 0 0 1-.278-.65z"/>
                                </svg>
                            </div>
                            <div>
                                <h6 class="mb-0">Water Resistant</h6>
                                <p class="mb-0 text-muted">5 ATM water resistance rating</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping and Returns -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="d-flex align-items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-truck me-2 text-primary" viewBox="0 0 16 16">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                            <span class="fw-bold">Free Shipping</span>
                        </div>
                        <p class="mb-2 ms-4 small">Delivery in 2-5 business days</p>
                        
                        <div class="d-flex align-items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-return-left me-2 text-primary" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            <span class="fw-bold">Easy Returns</span>
                        </div>
                        <p class="mb-0 ms-4 small">30-day return policy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tabs Section -->
    <section class="product-tabs">
        <div class="container">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Specifications</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews (128)</button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div class="row">
                        <div class="col-md-8 p-3">

                            <h4>Product Description</h4>
                            <p>The Smart Watch Pro is designed for those who want to stay connected and track their health without compromising on style. This premium smartwatch combines cutting-edge technology with elegant design to deliver an exceptional user experience.</p>
                            
                            <h5 class="mt-4">Advanced Health Monitoring</h5>
                            <p>Keep track of your health metrics with precision. The Smart Watch Pro monitors your heart rate, blood oxygen levels, sleep patterns, and stress levels. It also tracks your daily activity, including steps, distance, calories burned, and floors climbed.</p>
                            
                            <h5 class="mt-4">Smart Notifications</h5>
                            <p>Stay connected without reaching for your phone. Receive notifications for calls, texts, emails, and app alerts directly on your wrist. You can even respond to messages with quick replies or voice-to-text.</p>
                            
                            <h5 class="mt-4">Built for Durability</h5>
                            <p>With a 5 ATM water resistance rating, the Smart Watch Pro can withstand swimming, showering, and intense workouts. The scratch-resistant display and durable materials ensure your watch looks great for years to come.</p>
                            
                            <h5 class="mt-4">Long Battery Life</h5>
                            <p>Enjoy up to 7 days of battery life on a single charge, so you can focus on your activities without worrying about running out of power.</p>
                        </div>
                        <div class="col-md-4">
                            <img src="https://images.unsplash.com/photo-1551816230-ef5deaed4a26?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="img-fluid rounded" alt="Smart Watch Pro Features">
                        </div>
                    </div>
                </div>
                
                <!-- Specifications Tab -->
                <div class="tab-pane fade p-3" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                    <h4>Technical Specifications</h4>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped spec-table">
                            <tbody>
                                <tr>
                                    <th>Display</th>
                                    <td>1.4" AMOLED touchscreen (454 x 454 pixels)</td>
                                </tr>
                                <tr>
                                    <th>Dimensions</th>
                                    <td>45mm x 45mm x 11mm</td>
                                </tr>
                                <tr>
                                    <th>Weight</th>
                                    <td>48g (without strap)</td>
                                </tr>
                                <tr>
                                    <th>Battery Life</th>
                                    <td>Up to 7 days (normal use), 14 days (battery saver mode)</td>
                                </tr>
                                <tr>
                                    <th>Water Resistance</th>
                                    <td>5 ATM (50 meters)</td>
                                </tr>
                                <tr>
                                    <th>Sensors</th>
                                    <td>Heart rate, accelerometer, gyroscope, barometer, ambient light, SpO2</td>
                                </tr>
                                <tr>
                                    <th>Connectivity</th>
                                    <td>Bluetooth 5.0, Wi-Fi, NFC</td>
                                </tr>
                                <tr>
                                    <th>Compatibility</th>
                                    <td>Android 6.0+, iOS 12.0+</td>
                                </tr>
                                <tr>
                                    <th>Storage</th>
                                    <td>4GB internal storage</td>
                                </tr>
                                <tr>
                                    <th>Materials</th>
                                    <td>Aluminum case, silicone strap (replaceable)</td>
                                </tr>
                                <tr>
                                    <th>In the Box</th>
                                    <td>Smart Watch Pro, Magnetic charging cable, User manual</td>
                                </tr>
                                <tr>
                                    <th>Warranty</th>
                                    <td>1-year limited warranty</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div class="tab-pane fade p-3" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded">
                                <h4 class="mb-3">Customer Reviews</h4>
                                <div class="d-flex align-items-center mb-3">
                                    <h1 class="display-4 me-2 mb-0">4.8</h1>
                                    <div>
                                        <div class="star-rating mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                                <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                                            </svg>
                                        </div>
                                        <p class="mb-0">Based on 128 reviews</p>
                                    </div>
                                </div>
                                
                                <!-- Rating Breakdown -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">5</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">85%</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">4</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">10%</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">3</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 3%;" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">3%</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">2</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">1%</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">1</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">1%</span>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary w-100" data-bs-toggle="collapse" data-bs-target="#writeReviewForm">Write a Review</button>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <!-- Write Review Form (Collapsed by default) -->
                            <div class="collapse mb-4" id="writeReviewForm">
                                <div class="review-form">
                                    <h5 class="mb-3">Write Your Review</h5>
                                    <form>
                                        <div class="mb-3">
                                            <label for="reviewerName" class="form-label">Your Name</label>
                                            <input type="text" class="form-control" id="reviewerName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <div class="rating-select mb-2">
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label for="star5" title="5 stars">★</label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" title="4 stars">★</label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" title="3 stars">★</label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" title="2 stars">★</label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" title="1 star">★</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewTitle" class="form-label">Review Title</label>
                                            <input type="text" class="form-control" id="reviewTitle" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewText" class="form-label">Your Review</label>
                                            <textarea class="form-control" id="reviewText" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Reviews List -->
                            <h4 class="mb-4">Recent Reviews</h4>
                            
                            <!-- Review 1 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="reviewer-name">Michael Johnson</span>
                                    <span class="review-date">May 15, 2023</span>
                                </div>
                                <div class="star-rating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <h6 class="mt-2">Excellent smartwatch with great features!</h6>
                                <p class="review-text">I've been using the Smart Watch Pro for about a month now and I'm extremely impressed. The battery life is amazing - I only need to charge it once a week. The health tracking features are accurate and the sleep tracking has helped me improve my sleep habits. The display is bright and responsive, even in direct sunlight. Highly recommend!</p>
                            </div>
                            
                            <!-- Review 2 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="reviewer-name">Sarah Williams</span>
                                    <span class="review-date">April 28, 2023</span>
                                </div>
                                <div class="star-rating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                    </svg>
                                </div>
                                <h6 class="mt-2">Great watch, but app could be better</h6>
                                <p class="review-text">The Smart Watch Pro itself is fantastic. The build quality is excellent and it feels premium. I love the health tracking features and the battery life is impressive. My only complaint is that the companion app could use some improvements in terms of user interface and data visualization. Otherwise, it's a solid product that I would recommend.</p>
                            </div>
                            
                            <!-- Review 3 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="reviewer-name">David Chen</span>
                                    <span class="review-date">April 10, 2023</span>
                                </div>
                                <div class="star-rating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <h6 class="mt-2">Best smartwatch I've ever owned</h6>
                                <p class="review-text">After trying several other smartwatches, I can confidently say the Smart Watch Pro is the best one I've owned. The battery life is incredible - I get a full week on a single charge with moderate use. The health tracking is comprehensive and accurate. The build quality is excellent, and it looks stylish enough to wear with both casual and formal attire. The water resistance is also a huge plus for swimming and showering.</p>
                            </div>
                            
                            <!-- Review 4 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="reviewer-name">Emily Rodriguez</span>
                                    <span class="review-date">March 22, 2023</span>
                                </div>
                                <div class="star-rating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                                <h6 class="mt-2">Perfect fitness companion</h6>
                                <p class="review-text">As a fitness enthusiast, I've found the Smart Watch Pro to be the perfect companion for my workouts. The heart rate monitoring is accurate, and I love the built-in GPS for tracking my runs without needing to carry my phone. The automatic workout detection works well, and the water resistance means I don't have to worry about sweat or rain. The sleep tracking has also been eye-opening and helped me improve my rest.</p>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button class="btn btn-outline-primary">Load More Reviews</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">You May Also Like</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=705&q=80"
                                alt="Summer T-Shirt">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="shoes" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                alt="Running Shoes">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="accessories sale" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1523206489230-c012c64b2b48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                                alt="Smart Watch">
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
                <div class="col-md-6 col-lg-3 product-item" data-category="clothing" data-aos="fade-up"
                    data-aos-delay="400">
                    <div class="product-card">
                        <div class="product-img-container">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=736&q=80"
                                alt="Casual Jacket">
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
        </div>
    </section>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@push('scripts')
    <script>
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
@endpush

