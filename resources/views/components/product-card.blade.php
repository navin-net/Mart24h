            <div class="row g-4" id="productsGrid">
                @foreach ($products as $product)
                    <div class="col-md-4 col-sm-6 product-item" data-category="{{ $product['category'] ?? 'general' }}"
                        data-price="{{ $product['price'] }}" data-rating="{{ $product['rating'] }}">
                        <div class="card h-100 shadow-sm product-card" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="position-relative product-image-container">
                                <img src="{{ $product['image'] }}" class="card-img-top product-image"
                                    alt="{{ $product['name'] }}">

                                @if ($product['badge'])
                                    <span
                                        class="badge {{ $product['badge_class'] }} position-absolute top-0 start-0 m-2">
                                        {{ $product['badge'] }}
                                    </span>
                                @endif

                                @if ($product['old_price'])
                                    @php
                                        $discount = round(
                                            (($product['old_price'] - $product['price']) / $product['old_price']) * 100,
                                        );
                                    @endphp
                                    <span
                                        class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ $discount }}%</span>
                                @endif

                                <!-- Product Actions -->
                                <div class="product-actions">
                                    <button class="btn btn-sm btn-light rounded-circle action-btn"
                                        onclick="toggleFavorite({{ $product['id'] }})" title="Add to Favorites">
                                        <i class="far fa-heart favorite-icon" id="fav-{{ $product['id'] }}"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light rounded-circle action-btn"
                                        onclick="window.location.href='{{ route('shop.productDetail', $product['id']) }}'"
                                        title="Quick View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-semibold">
                                    <a href="{{ route('shop.productDetail', $product['id']) }}"
                                        class="text-decoration-none text-dark">{{ $product['name'] }}</a>
                                </h6>

                                <p class="text-muted small mb-2">
                                    {{ \Illuminate\Support\Str::limit($product['description'], 60) }}
                                </p>

                                <div class="mb-2 text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $product['rating'])
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <small class="text-muted ms-1">({{ $product['rating'] }}/5)</small>
                                </div>

                                <div class="mb-3">
                                    <span
                                        class="h5 fw-bold text-primary">${{ number_format($product['price'], 2) }}</span>
                                    @if ($product['old_price'])
                                        <del
                                            class="text-muted small ms-2">${{ number_format($product['old_price'], 2) }}</del>
                                    @endif
                                </div>

                                <div class="mt-auto d-flex gap-2">
                                    <button class="btn btn-primary flex-fill add-to-cart-btn"
                                        onclick="addToCart({{ json_encode($product) }})">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                    <button class="btn btn-outline-secondary"
                                        onclick="window.location.href='{{ route('shop.productDetail', $product['id']) }}'"
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
