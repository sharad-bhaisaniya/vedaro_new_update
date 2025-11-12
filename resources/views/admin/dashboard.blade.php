@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')
<style>
    .row {
        justify-content: flex-start !important;
    }
    .card {
        /*height: 169px !important;*/
            min-height: 169px;
    }
    canvas {
        max-height: 300px;
    }
</style>

<div class="d-flex">
    <div class="content flex-grow-1">
        <button class="btn btn-secondary toggle-sidebar mb-3" onclick="toggleSidebar()">☰ Menu</button>
        <div class="container">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dashboard Overview</h2>
            <a href="{{ route('reports.index') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-text"></i> Reports
            </a>
        </div>

            <div class="row">
                
                 <!-- Charts Section -->
            <div class="row mt-5">
                <!-- Doughnut Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Order Status (Doughnut Chart)</h5>
                            <canvas id="orderDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>

           <!-- Radar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Dashboard Metrics (Polar Area Chart)</h5>
                        <canvas id="dashboardPolarChart"></canvas>
                    </div>
                </div>
            </div>

            </div>

                
                
                <!-- Total Orders -->
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text display-6">{{ $totalOrders }}</p>
                        </div>
                    </div>
                </div>

                <!-- Paid Orders -->
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Paid Orders</h5>
                            <p class="card-text display-6">{{ $paidOrders }}</p>
                            <a href="completed_orders" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Pending Orders</h5>
                            <p class="card-text display-6">{{ $pendingOrders }}</p>
                            <a href="pending_orders" class="btn btn-warning">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Orders -->
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Cancelled Orders</h5>
                            <p class="card-text display-6">{{ $cancelledOrders }}</p>
                            <a href="canceled_orders" class="btn btn-danger">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="col-md-3 mt-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text display-6">{{ $productCount }}</p>
                            <a href="manage-products" class="btn btn-success">Manage Products</a>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="col-md-3 mt-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text display-6">{{ $userCount }}</p>
                            <a href="registered-users" class="btn btn-warning">View Users</a>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>  
</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Sidebar Toggle -->
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.toggle('open');
        }
    }

    // Doughnut Chart: Order Status
    const doughnutCtx = document.getElementById('orderDoughnutChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Cancelled'],
            datasets: [{
                data: [{{ $paidOrders }}, {{ $pendingOrders }}, {{ $cancelledOrders }}],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

   // Polar Area Chart: Dashboard Metrics
const polarCtx = document.getElementById('dashboardPolarChart').getContext('2d');
new Chart(polarCtx, {
    type: 'polarArea',
    data: {
        labels: ['Total Orders', 'Paid Orders', 'Pending Orders', 'Cancelled Orders', 'Products', 'Users'],
        datasets: [{
            label: 'Dashboard Overview',
            data: [{{ $totalOrders }}, {{ $paidOrders }}, {{ $pendingOrders }}, {{ $cancelledOrders }}, {{ $productCount }}, {{ $userCount }}],
            backgroundColor: [
                '#0d6efd',
                '#198754',
                '#ffc107',
                '#dc3545',
                '#20c997',
                '#6f42c1'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});

</script>

@endsection
