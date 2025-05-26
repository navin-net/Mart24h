@extends('admin.master')

@section('title', __('messages.dashboard'))

@section('content')
    <!-- Dashboard Header -->
    <div class="mb-4">
        <div class="section-title">{{ __('messages.dashboard') }}</div>
        <h1 class="display-6 fw-bold mb-3">{{ __('messages.stock_management_system') }}</h1>
        <p class="text-muted mb-4">{{ __('messages.dashboard_welcome') }}</p>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-3">
    {{-- <div class="col-md-4">
        <x-stat-card
            title="{{ __('messages.brands') }}"
            value="{{ $brandCount }}"
            icon="bi bi-tags"
            iconColor="#a855f7"
            bgColor="rgba(168, 85, 247, 0.2)"
            link="{{ route('brands.index') }}"
        />
    </div> --}}
    <div class="col-md-4">
        <x-stat-card
            title="{{ __('messages.purchases') }}"
            value="{{ $purchasesCount }}"
            icon="bi bi-tags"
            iconColor="#a855f7"
            bgColor="rgba(168, 85, 247, 0.2)"
            link="{{ route('purchases.index') }}"
        />
    </div>
    <div class="col-md-4">
        <x-stat-card
            title="{{ __('messages.products') }}"
            value="{{ $productCount }}"
            icon="bi bi-box-seam"
            iconColor="#10b981"
            bgColor="rgba(16, 185, 129, 0.2)"
            link="{{ route('products.index') }}"
        />
    </div>

    <div class="col-md-4">
        <x-stat-card
            title="{{ __('messages.orders') }}"
            {{-- value="{{ $orderCount }}" --}}
            icon="bi bi-cart-check"
            iconColor="#f59e0b"
            bgColor="rgba(245, 158, 11, 0.2)"
            {{-- link="{{ route('orders.index') }}" --}}
        />
    </div>
</div>


    <!-- Reports & Recent Activity -->
    <div class="row mt-3">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">{{ __('messages.sales_report') }}</h5>
                        <small class="text-muted">{{ __('messages.example_data') }}</small>
                    </div>
                    <button class="btn btn-sm btn-outline-custom">
                        <i class="bi bi-three-dots"></i>
                    </button>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.recent_activity') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">2 mins ago</div>
                                <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">New sale: $250.00</div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">1 hour ago</div>
                                <div class="rounded-circle bg-info" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">Product "Laptop" updated</div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent border-bottom" style="border-color: var(--border-color) !important;">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">4 hours ago</div>
                                <div class="rounded-circle bg-warning" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">Low stock alert: "Mouse"</div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="d-flex align-items-center">
                                <div class="me-3 text-muted small">1 day ago</div>
                                <div class="rounded-circle bg-primary" style="width: 8px; height: 8px;"></div>
                                <div class="ms-3">New customer registered</div>
                            </div>
                        </div>
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
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 4000); // hides after 4 seconds
</script>
@endpush

@push('scripts')
    <!-- Chart.js for Sales Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Sales',
                        data: [1200, 1900, 1500, 2200, 1800, 2500, 2000],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
