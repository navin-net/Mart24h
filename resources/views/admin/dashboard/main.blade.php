@extends('admin.master')

@section('title', __('messages.dashboard'))

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <div class="section-title text-start">{{ __('messages.dashboard') }}</div>
        <h1 class="display-6 fw-bold mb-3 text-start">{{ __('messages.stock_management_system') }}</h1>
        <p class="text-muted mb-4 text-start">{{ __('messages.dashboard_welcome') }}</p>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
    </div>
@endif

<!-- Stat Cards -->
<div class="row g-3">
    <div class="col-sm-6 col-lg-3">
        <x-stat-card
            title="{{ __('messages.products') }}"
            value="{{ $productCount }}"
            icon="bi bi-box-seam"
            iconColor="#10b981"
            bgColor="rgba(16, 185, 129, 0.2)"
            link="{{ route('products.index') }}"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-stat-card
            title="{{ __('messages.purchases') }}"
            value="{{ $purchasesCount }}"
            icon="bi bi-tags"
            iconColor="#a855f7"
            bgColor="rgba(168, 85, 247, 0.2)"
            link="{{ route('purchases.index') }}"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-stat-card
            title="{{ __('messages.sales') }}"
            value="{{ $salesCount }}"
            icon="bi bi-cart-check"
            iconColor="#f59e0b"
            bgColor="rgba(245, 158, 11, 0.2)"
            link="{{ route('sales.index') }}"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-stat-card
            title="{{ __('messages.biller') }}"
            value="{{ $billerCount }}"
            icon="bi bi-person-badge"
            iconColor="#6366f1"
            bgColor="rgba(99, 102, 241, 0.2)"
            link="{{ route('billers.index') }}"
        />
    </div>
</div>

<!-- Reports & Recent Activity -->
<div class="row mt-3">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">{{ __('messages.sales_report') }}</h5>
                    <small class="text-muted">{{ __('messages.data') }}</small>
                </div>
            </div>
            <div class="card-body" style="height: 350px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4 mt-3 mt-lg-0">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('messages.recent_activity') }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">

                    {{-- Recent Sales --}}
                    @forelse ($recentSales as $sale)
                        <div class="list-group-item border-bottom bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">
                                    {{ \Carbon\Carbon::parse($sale->date)->diffForHumans() }}
                                </div>
                                <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">{{ __('messages.new_sale') }}: 
                                    ${{ number_format($sale->total_amount, 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
<!--                         <div class="list-group-item text-center text-muted py-3">
                            {{ __('messages.no_recent_sales') }}
                        </div> -->
                    @endforelse

                    <!-- Before 6 months summary -->
                    <div class="list-group-item border-bottom bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-muted small">{{ __('messages.after_6_month') }}</div>
                            <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                            <div class="ms-3">{{ __('messages.total_sales') }}:
                                ${{ number_format($recentBeforSales, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item border-bottom bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-muted small">{{ __('messages.after_6_month') }}</div>
                            <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                            <div class="ms-3">{{ __('messages.total_purchases') }}:
                                ${{ number_format($recentBeforPurchases, 2) }}
                            </div>
                        </div>
                    </div>

                    {{-- Product Updates --}}
                    @forelse ($recentProducts as $product)
                        <div class="list-group-item border-bottom bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">{{ $product->updated_at->diffForHumans() }}</div>
                                <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">{{ __('messages.products') }} "{{ $product->name }}" 
                                    {{ __('messages.updated') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted py-3">
                            {{ __('messages.no_recent_products') }}
                        </div>
                    @endforelse

                    {{-- Low Stock Alerts --}}
                    @forelse ($lowStockProducts as $product)
                        <div class="list-group-item border-bottom bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">{{ now()->diffForHumans() }}</div>
                                <div class="rounded-circle bg-warning" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">{{ __('messages.low_stock_alert') }}: "{{ $product->name }}" 
                                    ({{ __('messages.qty') }}: {{ $product->stock_quantity }})
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- <div class="list-group-item text-center text-muted py-3">
                            {{ __('messages.no_low_stock') }}
                        </div> -->
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="back-to-top rounded-circle shadow d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up"></i>
</a>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Auto dismiss alerts using Bootstrap
    setTimeout(() => {
        const alertEl = document.querySelector('.alert');
        if (alertEl) {
            const alert = new bootstrap.Alert(alertEl);
            alert.close();
        }
    }, 4000);

    // Chart.js initialization
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesLabels),
            datasets: [
                {
                    label: '{{ __("messages.sales_by_month") }}',
                    data: @json($salesData),
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: '{{ __("messages.purchases_by_month") }}',
                    data: @json($purchasesData),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true },
                x: { title: { display: true, text: '{{ __("messages.month") }}' } }
            }
        }
    });
});
</script>
@endpush
