@extends('layouts.admin_lay')
@section('title', 'All Orders')
@section('content')
<div class="container-fluid px-4">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-success">
                <i class="fas fa-check-circle text-success"></i> Completed Orders
            </h2>
            <div class="d-flex gap-3">
                <div class="input-group mr-3" style="width: 250px;">
                    <input type="text" class="form-control" placeholder="Search orders..." id="searchInput">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-danger">
                <i class="fas fa-file-export mr-1"></i> Export
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>ProductName × Qty × Price</th>
                        <th>Total</th>
                        <th>Tracking</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shiprocketOrders as $order)
                    <tr>
                        <td>{{ $order['channel_order_id'] }}</td>
                        <td>{{ $order['customer_name'] }}</td>
                        <td>{{ $order['status'] }}</td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach ($order['order_items'] as $item)
                                <li> {{ $item['name'] }} ×  {{ $item['quantity'] }} × {{  number_format($item['price'] ?? 0, 2)   }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>₹{{ $order['order_total'] }}</td>
                        <td>
                            @if ($order['tracking_url'])
                            <a href="{{ $order['tracking_url'] }}" target="_blank">Track Order</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary eye-button" data-target="detail-{{ $order['order_id'] }}">
                            <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    {{-- Hidden Row --}}
                    <tr class="full-detail" id="detail-{{ $order['order_id'] }}" style="display: none;">
                        <td colspan="8">
                            <div class="">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <div class="card-header text-white py-3 d-flex justify-content-between bg-success align-items-center" >
                                        <div>
                                            <i class="bi bi-bag-fill me-2"></i>
                                            <span class="fw-bold fs-5">Order Summary</span>
                                        </div>
                                        <span>{{ $order['order_date'] }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <p class="mb-2"><i class="bi bi-person-circle me-1"></i><strong>Name:</strong> {{ $order['customer_name'] }}</p>
                                                <p class="mb-2"><i class="bi bi-envelope me-1"></i><strong>Email:</strong> {{ $order['customer_email'] ?? 'N/A' }}</p>
                                                <p><i class="bi bi-telephone me-1"></i><strong>Phone:</strong> {{ $order['customer_phone'] ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-2"><i class="bi bi-currency-rupee me-1"></i><strong>Total Amount:</strong> ₹{{ number_format($order['order_total'], 2) }}</p>
                                                <p class="mb-2">
                                                    <i class="bi bi-truck me-1 text-success"></i>
                                                    <strong>Courier:</strong> {{ $order['courier_name'] ?? 'N/A' }}
                                                </p>
                                                @if ($order['tracking_url'])
                                                <p>
                                                    <i class="bi bi-link-45deg me-1"></i>
                                                    <strong>Tracking: </strong>
                                                    <a href="{{ $order['tracking_url'] }}" target="_blank" class="link-primary">Track Order</a>
                                                </p>
                                                @else
                                                <p><i class="bi bi-link-45deg me-1"></i><strong>Tracking:</strong> N/A</p>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1"><i class="bi bi-geo-alt me-1"></i><strong>Shipping Address:</strong><br>
                                                    <span class="text-muted small">
                                                    {{ $order['shipping_address']['address'] ?? '' }},
                                                    {{ $order['shipping_address']['city'] ?? '' }},
                                                    {{ $order['shipping_address']['state'] ?? '' }},
                                                    {{ $order['shipping_address']['pincode'] ?? '' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-semibold">Order Items</span>
                                                <span class="badge bg-primary bg-opacity-75 fs-6">Total: {{ count($order['order_items']) }}</span>
                                            </div>
                                            <ul class="list-group">
                                                @foreach ($order['order_items'] as $item)
                                                <li class="list-group-item border-0 border-bottom d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <div class="fw-bold">{{ $item['name'] ?? 'N/A' }}</div>
                                                        <div class="text-muted small">Qty: {{ $item['quantity'] ?? 0 }}</div>
                                                       </div>
                                                    <span class="text-primary fw-bold align-self-center">₹{{ number_format($item['price'] ?? 0, 2) }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Use event delegation for dynamically loaded elements
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.eye-button')) {
                const button = e.target.closest('.eye-button');
                const targetId = button.getAttribute('data-target');
                const detailRow = document.getElementById(targetId);
                
                if (detailRow) {
                    if (detailRow.style.display === "none" || detailRow.style.display === "") {
                        detailRow.style.display = "table-row";
                        button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    } else {
                        detailRow.style.display = "none";
                        button.innerHTML = '<i class="fas fa-eye"></i>';
                    }
                }
            }
        });
    });
</script>

<style>
    .card {
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .badge-danger {
        background-color: #e74a3b;
        color: white;
    }
    .empty-state {
        opacity: 0.5;
    }
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .card-header .d-flex {
            width: 100%;
            margin-top: 1rem;
        }
        .input-group {
            width: 100% !important;
            margin-bottom: 1rem;
        }
    }
    .view-items {
        white-space: nowrap;
    }
    .full-detail {
        background-color: #f8f9fa;
    }
</style>
@endsection