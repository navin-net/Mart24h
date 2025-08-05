@forelse ($products as $product)
    <div class="col-6 col-md-3 col-lg-2 mb-3">
        <div class="card product-card h-100 border shadow-sm" data-id="{{ $product['id'] }}">
            <img src="{{ $product['image'] }}" class="card-img-top p-2" alt="{{ $product['name'] }}" loading="lazy">
            <div class="card-body p-2">
                <h6 class="card-title mb-1 text-truncate" title="{{ $product['name'] }}">{{ $product['name'] }}</h6>
                <p class="card-text mb-0 text-muted">${{ number_format($product['price'], 2) }}</p>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center text-danger">
        <p>No products found.</p>
    </div>
@endforelse