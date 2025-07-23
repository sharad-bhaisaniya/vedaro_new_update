@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex">
    <!-- Sidebar -->
    
    <!-- Content Area -->
    <div class="content flex-grow-1">
        <button class="btn btn-secondary toggle-sidebar mb-3" onclick="toggleSidebar()">☰ Menu</button>
        <div class="container">
            <h2 class="mb-4">Dashboard Overview</h2>
            <div class="row">
                <!-- Total Orders -->
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text display-6">{{ $totalOrders }}</p>
                            <!--<a href="completed_orders" class="btn btn-primary">View Details</a>-->
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
<style>
    .row {

    justify-content: flex-start !important;
}
.card{
        height: 169px !important;
}
</style>
<!-- Sidebar Toggle Script -->
<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.toggle('open');
        }
    }
</script>

@endsection
