@extends('shop.layouts.app')

@section('title','Product List')

@section('content')

@php
  $products = [
    [
      'id' => 0,
      'name' => 'Smart Watch Pro',
            'image' => asset('storage/banners/2lFTJbvF7lfuDzJ05qgXtLRpIYSbxYCJeD9nNYvA.jpg'),
      'price' => 149.99,
      'old_price' => 199.99,
      'rating' => 4,
      'badge' => 'Sale',
      'badge_class' => 'bg-danger',
      'description' => 'Stay connected with the Smart Watch Pro, featuring health tracking and notifications.',
    ],
    [
      'id' => 1,
      'name' => 'Wireless Headphones',
      'image' => 'https://via.placeholder.com/300x200?text=Headphones',
      'price' => 89.99,
      'old_price' => null,
      'rating' => 5,
      'badge' => null,
      'badge_class' => null,
      'description' => 'Experience immersive sound with noise-cancelling wireless headphones.',
    ],
    [
      'id' => 2,
      'name' => 'Running Shoes',
      'image' => 'https://via.placeholder.com/300x200?text=Shoes',
      'price' => 129.99,
      'old_price' => null,
      'rating' => 4,
      'badge' => null,
      'badge_class' => null,
      'description' => 'Comfortable and durable running shoes for all terrains.',
    ],
    [
      'id' => 3,
      'name' => 'Gaming Laptop X200',
      'image' => 'https://via.placeholder.com/300x200?text=Gaming+Laptop',
      'price' => 1499.00,
      'old_price' => 1799.00,
      'rating' => 5,
      'badge' => 'New',
      'badge_class' => 'bg-success',
      'description' => 'High-performance laptop designed for gaming and multitasking.',
    ],
  ];
@endphp

<div class="container py-5">
  <h3 class="mb-4 fw-bold">All Products</h3>
  <div class="row">
    <!-- Filters -->
    <div class="col-lg-3 mb-4">
      <div class="p-3 border rounded bg-light">
        <h5 class="fw-semibold mb-3">Filters</h5>

        <!-- Categories -->
        <div class="mb-4">
          <h6>Categories</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="electronics"><label class="form-check-label" for="electronics">Electronics</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="clothing"><label class="form-check-label" for="clothing">Clothing</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="home"><label class="form-check-label" for="home">Home & Living</label></div>
        </div>

        <!-- Price -->
        <div class="mb-4">
          <h6>Price Range</h6>
          <input type="range" class="form-range" min="0" max="1000" id="priceRange">
          <div class="d-flex justify-content-between small text-muted">
            <span>$0</span><span>$1000</span>
          </div>
        </div>

        <!-- Colors -->
        <div class="mb-4">
          <h6>Colors</h6>
          <div class="d-flex gap-2">
            <span class="d-inline-block rounded-circle border" style="width:20px; height:20px; background:black;"></span>
            <span class="d-inline-block rounded-circle border" style="width:20px; height:20px; background:red;"></span>
            <span class="d-inline-block rounded-circle border" style="width:20px; height:20px; background:blue;"></span>
            <span class="d-inline-block rounded-circle border" style="width:20px; height:20px; background:green;"></span>
          </div>
        </div>

        <!-- Rating -->
        <div class="mb-4">
          <h6>Rating</h6>
          <div class="form-check"><input class="form-check-input" type="radio" name="rating"><label class="form-check-label">★★★★☆ & up</label></div>
          <div class="form-check"><input class="form-check-input" type="radio" name="rating"><label class="form-check-label">★★★☆☆ & up</label></div>
        </div>

        <button class="btn btn-primary w-100">Apply Filters</button>
      </div>
    </div>

    <!-- Product Grid -->
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">Showing 1–{{ count($products) }} of {{ count($products) }} products</div>
        <select class="form-select w-auto">
          <option selected>Sort by</option>
          <option>Price: Low to High</option>
          <option>Newest</option>
        </select>
      </div>

      <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4 col-sm-6">
          <div class="card h-100 shadow-sm">
            <div class="position-relative">
              <a href="{{ route('shop.productDetail', $product['id']) }}">
                <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}">
              </a>
              @if($product['badge'])
                <span class="badge {{ $product['badge_class'] }} position-absolute top-0 start-0 m-2">{{ $product['badge'] }}</span>
              @endif
            </div>
            <div class="card-body d-flex flex-column">
              <h6 class="card-title fw-semibold">
                <a href="{{ route('shop.productDetail', $product['id']) }}" class="text-decoration-none text-dark">{{ $product['name'] }}</a>
              </h6>
              <p class="mb-1">
                <strong>${{ number_format($product['price'], 2) }}</strong>
                @if($product['old_price'])
                  <del class="text-muted small">${{ number_format($product['old_price'], 2) }}</del>
                @endif
              </p>
              <div class="mb-2 text-warning">
                {!! str_repeat('★', $product['rating']) !!}
                {!! str_repeat('☆', 5 - $product['rating']) !!}
              </div>
              <a href="{{ route('shop.productDetail', $product['id']) }}" class="btn btn-outline-primary btn-sm mt-auto">View Details</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-4">
        <nav>
          <ul class="pagination">
            <li class="page-item disabled"><span class="page-link">«</span></li>
            <li class="page-item active"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

@endsection
