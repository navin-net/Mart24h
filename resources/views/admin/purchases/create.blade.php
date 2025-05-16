@extends('admin.master')
@section('title', __('messages.add_purchase'))

@section('content')
    <div class="container-fluid py-4">
        <div class="pagetitle mb-4">
            <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>
            <nav>
                <ol class="breadcrumb rounded-3 p-2">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active text-muted' : '' }}">
                            @if (!$breadcrumb['active'])
                                <a href="{{ $breadcrumb['url'] }}"
                                    class="text-primary text-decoration-none">{{ $breadcrumb['label'] }}</a>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-semibold">{{ __('messages.add_purchase') }}</h5>

                            <div class="mb-4">
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('purchases.store') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="total_amount" class="form-label fw-medium">{{ __('messages.total_amount') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control rounded-3 @error('total_amount') is-invalid @enderror" value="{{ old('total_amount') }}" required>
                                        @error('total_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date" class="form-label fw-medium">{{ __('messages.date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control rounded-3 @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div id="items">
                                    <div class="item mb-3">
                                        <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                                        <select name="items[0][product_id]" class="form-control rounded-3 @error('items.0.product_id') is-invalid @enderror" required>
                                            <option value="">{{ __('messages.select_product') }}</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }} (SKU: {{ $product->sku }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('items.0.product_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <label class="form-label fw-medium mt-2">{{ __('messages.quantity') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="items[0][quantity]" placeholder="{{ __('messages.quantity') }}" class="form-control rounded-3 mt-2 @error('items.0.quantity') is-invalid @enderror" value="{{ old('items.0.quantity') }}" required>
                                        @error('items.0.quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <label class="form-label fw-medium mt-2">{{ __('messages.cost_price') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="items[0][cost_price]" placeholder="{{ __('messages.cost_price') }}" class="form-control rounded-3 mt-2 @error('items.0.cost_price') is-invalid @enderror" value="{{ old('items.0.cost_price') }}" required>
                                        @error('items.0.cost_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="button" onclick="addItem()" class="btn btn-secondary btn-sm rounded-3 mb-3">{{ __('messages.add_another_item') }}</button>

                                <div class="text-end">
                                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm rounded-3">{{ __('messages.cancel') }}</a>
                                    <button type="submit" class="btn btn-primary btn-sm rounded-3">{{ __('messages.add') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        let itemCount = 1;

        function addItem() {
            const products = @json($products);
            const itemsDiv = document.getElementById('items');
            const newItem = `
                <div class="item mb-3">
                    <label class="form-label fw-medium">{{ __('messages.product') }} <span class="text-danger">*</span></label>
                    <select name="items[${itemCount}][product_id]" class="form-control rounded-3" required>
                        <option value="">{{ __('messages.select_product') }}</option>
                        ${products.map(p => `<option value="${p.id}">${p.name} (SKU: ${p.sku})</option>`).join('')}
                    </select>
                    <label class="form-label fw-medium mt-2">{{ __('messages.quantity') }} <span class="text-danger">*</span></label>
                    <input type="number" name="items[${itemCount}][quantity]" placeholder="{{ __('messages.quantity') }}" class="form-control rounded-3 mt-2" required>
                    <label class="form-label fw-medium mt-2">{{ __('messages.cost_price') }} <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="items[${itemCount}][cost_price]" placeholder="{{ __('messages.cost_price') }}" class="form-control rounded-3 mt-2" required>
                </div>
            `;
            itemsDiv.insertAdjacentHTML('beforeend', newItem);
            itemCount++;
        }
    </script>
@endpush
