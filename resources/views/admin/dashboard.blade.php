
@extends(config('view.paths.admin_template_master', 'admin.template.master'))

@section('title')
    Dashboard | POS System
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <!-- Summary Section -->
            <div class="row g-5 g-xl-8 mt-5">
                <!-- Total Sales -->
                <div class="col-xl-6">
                    <div class="card bg-primary text-white shadow-sm hover-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Total Sales</h5>
                            <p class="card-text fs-3 fw-bold">{{ $totalSales }}</p>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-xl-6">
                    <div class="card bg-success text-white shadow-sm hover-card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-dollar-sign"></i> Total Revenue</h5>
                            <p class="card-text fs-3 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Low Stock Products -->
            <div class="row g-5 g-xl-8 mt-5">
                <!-- Top-Selling Products Chart -->
                <div class="col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Top-Selling Products</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="topSellingProductsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue Chart -->
                <div class="col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h3 class="card-title"><i class="fas fa-chart-line"></i> Monthly Revenue</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products Table -->
                <div class="col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Low Stock Products</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody id="lowStockTableBody">
                                    <!-- Rows will be populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Top-Selling Products Chart
        const topSellingCtx = document.getElementById('topSellingProductsChart').getContext('2d');
        fetch("{{ route('dashboard.getTopSellingProducts') }}")
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.NamaProduk); // Product names
                const values = data.map(item => item.total_sold); // Total sold

                new Chart(topSellingCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Sold',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                            }
                        }
                    }
                });
            });

        // Monthly Revenue Chart
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        fetch("{{ route('dashboard.getMonthlyRevenue') }}")
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => `Month ${item.month}`); // Months
                const values = data.map(item => item.revenue); // Revenue

                new Chart(monthlyRevenueCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Revenue',
                            data: values,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                            }
                        }
                    }
                });
            });

        // Low Stock Products Table
        fetch("{{ route('dashboard.getLowStockProducts') }}")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('lowStockTableBody');
                data.forEach(product => {
                    const row = `<tr>
                        <td>${product.NamaProduk}</td>
                        <td>${product.Stok}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            });
    });
</script>
@endsection