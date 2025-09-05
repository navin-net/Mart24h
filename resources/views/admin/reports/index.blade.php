@extends('admin.master')

@section('title', __('messages.report_list'))

@section('content')
<div class="container-fluid py-4">
    <div class="pagetitle mb-4">
        <div class="row">
            <div class="col-6">
        <h1 class="display-6 fw-bold">{{ $pageTitle }}</h1>

            </div>
            <div class="col-6 text-end">
        <p class="mb-0 opacity-75" id="currentDate">Loading date...</p>

            </div>
        </div>

        <nav>
            <!-- <ol class="breadcrumb rounded-3 p-2">
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
            </ol> -->
        </nav>
    </div>
    
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Sales</h6>
                                <h3 class="mb-0" id="totalSales">$0</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>12.5% vs yesterday
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Orders</h6>
                                <h3 class="mb-0" id="totalOrders">0</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>8.2% vs yesterday
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Avg Order Value</h6>
                                <h3 class="mb-0" id="avgOrderValue">$0</h3>
                                <small class="text-danger">
                                    <i class="fas fa-arrow-down me-1"></i>2.1% vs yesterday
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Customers</h6>
                                <h3 class="mb-0" id="totalCustomers">0</h3>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>15.3% vs yesterday
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="card stat-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Hourly Sales Trend</h5>
                        <small class="text-muted">Sales performance throughout the day</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="hourlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-3">
                <div class="card stat-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sales by Brands</h5>
                        <small class="text-muted">Product Brand breakdown</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="row mb-4">
            <!-- <div class="col-lg-6 mb-3">
                <div class="card stat-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Selling Products</h5>
                        <small class="text-muted">Best performers today</small>
                    </div>
                    <div class="card-body">
                        <div id="topProducts"></div>
                    </div>
                </div>
            </div> -->

            <div class="col-lg-12 mb-3">
                <div class="card stat-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sales Goals</h5>
                        <small class="text-muted">Progress towards daily targets 15000</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-sm font-medium">Daily Target</span>
                                <span class="text-sm font-medium" id="dailyProgress">0%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-primary" id="dailyProgressBar" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-sm font-medium">Weekly Target</span>
                                <span class="text-sm font-medium" id="weeklyProgress">0%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-success" id="weeklyProgressBar" style="width: 0%"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-sm font-medium">Monthly Target</span>
                                <span class="text-sm font-medium" id="monthlyProgress">0%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-warning" id="monthlyProgressBar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container">
                    <div class="card-header p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Recent Transactions</h5>
                                <small class="text-muted">Latest sales activity</small>
                            </div>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search transactions..." id="searchInput" style="width: 200px;">
                                <select class="form-select form-select-sm" id="statusFilter" style="width: 120px;">
                                    <option value="">All Status</option>
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="transactionsTable">
                                <!-- Transactions will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
           // Sample data
        const salesData = {
            // totalSales: 24750.50,
            // totalOrders: 156,
            totalCustomers: 89,
            dailyTarget: 30000,
            weeklyTarget: 180000,
            monthlyTarget: 750000,
            // hourlySales: [1200, 1800, 2100, 2800, 3200, 4100, 3800, 4500, 3900, 3200, 2800, 2100, 1800, 1500, 1200, 1800, 2400, 3200, 4100, 3800, 3200, 2400, 1800, 1200],
            categories: @json($brandsData),
            hourlySales: @json($hourlySales),
            //     'Books': 2050
            // },
            // topProducts: [
            //     { name: 'iPhone 15 Pro', sales: 45, revenue: 4500 },
            //     { name: 'Nike Air Max', sales: 32, revenue: 3200 },
            //     { name: 'Samsung TV 55"', sales: 18, revenue: 2700 },
            //     { name: 'MacBook Air', sales: 12, revenue: 2400 },
            //     { name: 'AirPods Pro', sales: 28, revenue: 2100 }
            // ],
        topProducts: @json($topProducts),
        totalSales: @json($totalSales),
        totalOrders: @json($totalOrders),
        transactions: @json($transactions),
            // transactions: [
            //     { id: 'ORD-001', customer: 'John Smith', product: 'iPhone 15 Pro', amount: 999, status: 'completed', time: '10:30 AM' },
            //     { id: 'ORD-002', customer: 'Sarah Johnson', product: 'Nike Air Max', amount: 129, status: 'completed', time: '10:25 AM' },
            //     { id: 'ORD-003', customer: 'Mike Davis', product: 'Samsung TV 55"', amount: 799, status: 'pending', time: '10:20 AM' },
            //     { id: 'ORD-004', customer: 'Emily Brown', product: 'MacBook Air', amount: 1299, status: 'completed', time: '10:15 AM' },
            //     { id: 'ORD-005', customer: 'David Wilson', product: 'AirPods Pro', amount: 249, status: 'completed', time: '10:10 AM' },
            //     { id: 'ORD-006', customer: 'Lisa Garcia', product: 'iPad Pro', amount: 899, status: 'refunded', time: '10:05 AM' },
            //     { id: 'ORD-007', customer: 'Tom Anderson', product: 'Apple Watch', amount: 399, status: 'completed', time: '10:00 AM' },
            //     { id: 'ORD-008', customer: 'Anna Martinez', product: 'Dell Laptop', amount: 699, status: 'pending', time: '09:55 AM' }
            // ]
        };
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentDate();
            updateKeyMetrics();
            createHourlySalesChart();
            createCategoryChart();
            setupFilters();
            updateSalesGoals();
            updateTransactionsTable();
            updateTopProducts();
        });


        function updateCurrentDate() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        }

        function updateKeyMetrics() {
            document.getElementById('totalSales').textContent = `$${salesData.totalSales.toLocaleString()}`;
            document.getElementById('totalOrders').textContent = salesData.totalOrders.toLocaleString();
            document.getElementById('totalCustomers').textContent = salesData.totalCustomers.toLocaleString();
            
            const avgOrderValue = salesData.totalSales / salesData.totalOrders;
            document.getElementById('avgOrderValue').textContent = `$${avgOrderValue.toFixed(2)}`;
        }

        function createHourlySalesChart() {
            const ctx = document.getElementById('hourlySalesChart').getContext('2d');
            const hours = Array.from({length: 24}, (_, i) => `${i}:00`);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'Sales ($)',
                        data: salesData.hourlySales,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        function createCategoryChart() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            const categories = Object.keys(salesData.categories);
            const values = Object.values(salesData.categories);
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categories,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#2563eb',
                            '#059669',
                            '#d97706',
                            '#dc2626',
                            '#7c3aed'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }


        function updateTransactionsTable() {
            const tbody = document.getElementById('transactionsTable');
            tbody.innerHTML = '';
            
            salesData.transactions.forEach(transaction => {
                const row = document.createElement('tr');
                const statusClass = {
                    'completed': 'success',
                    'pending': 'warning',
                    'refunded': 'danger'
                }[transaction.status];
                
                row.innerHTML = `
                    <td><span class="fw-medium">${transaction.id}</span></td>
                    <td>${transaction.customer}</td>
                    <td>${transaction.product}</td>
                    <td class="fw-bold">$${transaction.amount.toLocaleString()}</td>
                    <td><span class="badge bg-${statusClass} badge-custom">${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</span></td>
                    <td class="text-muted">${transaction.time}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="viewTransaction('${transaction.id}')">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }


        function updateSalesGoals() {
            const dailyProgress = (salesData.totalSales / salesData.dailyTarget) * 100;
            const weeklyProgress = (salesData.totalSales * 7 / salesData.weeklyTarget) * 100;
            const monthlyProgress = (salesData.totalSales * 30 / salesData.monthlyTarget) * 100;
            
            document.getElementById('dailyProgress').textContent = `${dailyProgress.toFixed(1)}%`;
            document.getElementById('dailyProgressBar').style.width = `${Math.min(dailyProgress, 100)}%`;
            
            document.getElementById('weeklyProgress').textContent = `${weeklyProgress.toFixed(1)}%`;
            document.getElementById('weeklyProgressBar').style.width = `${Math.min(weeklyProgress, 100)}%`;
            
            document.getElementById('monthlyProgress').textContent = `${monthlyProgress.toFixed(1)}%`;
            document.getElementById('monthlyProgressBar').style.width = `${Math.min(monthlyProgress, 100)}%`;
        }


        function updateTopProducts() {
            const container = document.getElementById('topProducts');
            container.innerHTML = '';
            
            salesData.topProducts.forEach((product, index) => {
                const productElement = document.createElement('div');
                productElement.className = 'd-flex justify-content-between align-items-center mb-3';
                productElement.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 0.875rem; font-weight: 600;">
                            ${index + 1}
                        </div>
                        <div>
                            <div class="fw-medium">${product.name}</div>
                            <small class="text-muted">${product.sales} units sold</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">$${product.revenue.toLocaleString()}</div>
                    </div>
                `;
                container.appendChild(productElement);
            });
        }



        function setupFilters() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            
            searchInput.addEventListener('input', filterTransactions);
            statusFilter.addEventListener('change', filterTransactions);
        }
        function filterTransactions() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#transactionsTable tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const status = row.querySelector('.badge').textContent.toLowerCase();
                
                const matchesSearch = text.includes(searchTerm);
                const matchesStatus = !statusFilter || status.includes(statusFilter);
                
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }
        function viewTransaction(orderId) {
            alert(`Viewing details for order: ${orderId}`);
        }

        function exportToPDF() {
            alert('PDF export functionality would be implemented here');
        }

        function exportToExcel() {
            alert('Excel export functionality would be implemented here');
        }

        // Auto-refresh data every 30 seconds
        setInterval(() => {
            // In a real application, you would fetch new data from your API
            console.log('Refreshing dashboard data...');
        }, 30000);

    console.log(salesData);
</script>
@endpush

