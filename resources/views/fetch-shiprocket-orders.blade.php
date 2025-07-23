@extends('layouts.main')

@section('title', 'My Orders')

@section('content')

<div class="orders-page-container" style="margin-top:120px">
   <div class="d-flex justify-content-between align-items-center">
        <h1 class="orders-page-title">My Orders</h1>

   <!-- Filter Dropdown -->
    <div class="filter-container mt-3 mb-3">
        <label for="orderStatusFilter" class="form-label">Filter by Status:</label>
        <select id="orderStatusFilter"  class="form-select" style="width:130px">
            <option value="all">All</option>
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>
   </div>



@forelse ($processedOrders as $order)
<div class="card mb-12 shadow-sm mb-3">
    <div class="card-body col-md-12">
        <div class="row align-items-center mb-3">
            <div class="col-md-7">
                <h5 class="card-title mb-0">Order #{{ $order['order_id'] }}</h5>
                <p class="card-text text-muted small">Placed on: <span class="order-date">{{ $order['order_date'] }}</span></p>
            </div>
            <div class="col-md-5 text-end">
                <div class="d-flex  align-items-center justify-content-end gap-3">
                    <button class="btn btn-info btn-sm view_order_status ">
                        Status: <span class="fw-bold">{{ $order['status'] }}</span>
                    </button>
                    <a href="{{ $order['tracking_url'] }}" target="_blank" class="btn btn-primary btn-sm track-order-btn "
                        data-order_id="{{ $order['order_id'] }}"
                       >
                        Track Order
                    </a>
                   {{-- <a href="{{ $order['tracking_url'] }}" target="_blank" class="btn btn-primary btn-sm track-order-btn "
                        data-order_id="{{ $order['order_id'] }}"
                        data-awb="{{ $order['awb'] }}">
                        Track Order
                    </a>--}}
                    <button class="btn btn-danger btn-sm cancel-order-btn"
                        data-order_id="{{ $order['order_id'] }}">
                        Cancel Order
                    </button>
                </div>
            </div>
        </div>

        <hr class=" col-md-12">

        <div class="row">
            <div class="col-12">
                <h6 class="mb-2">Order Details</h6>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 product-name fw-bold">{{ $order['product_name'] }}</p>
                            <small class="text-muted product-sku">SKU: {{ $order['product_sku'] }}</small>
                        </div>
                        <span class="product-quantity">Qty: {{ $order['product_quantity'] }}</span>
                        <span class="product-price">₹{{ number_format((float) $order['product_price'], 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-2">Payment & Shipping</h6>
                <!--<p class="mb-1"><strong>Payment Method:</strong> <span class="payment-method">{{ $order['payment_method'] }}</span></p>-->
                <p class="mb-1"><strong>Shipping Charges:</strong> ₹{{ number_format((float) $order['shipping_charges'], 2) }}</p>
            </div>
            <div class="col-md-6">
                {{--<p class="mb-1"><strong>Courier:</strong> {{ $order['courier'] }}</p>
                <p class="mb-1"><strong>AWB:</strong> {{ $order['awb'] }}</p>--}}
                <p class="mb-1"><strong>Estimated Delivery:</strong> {{ $order['etd'] }}</p>
            </div>
        </div>

        <hr class=" col-md-12">

        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Total Amount:</h5>
            <h5 class="mb-0 text-success total-price">₹{{ number_format((float) $order['order_total'], 2) }}</h5>
        </div>
    </div>
</div>
@empty
    <p class="text-center">No orders to display.</p>
@endforelse
</div> 


<script>
    $(document).ready(function() {
    $(".cancel-order-btn").on("click", function() {
        let orderId = $(this).data("order_id");

        if (!confirm("Are you sure you want to cancel this order?")) {
            return;
        }

        $.ajax({
            url: "/cancel-shiprocket-order",
            type: "POST",
            data: { order_id: orderId, _token: "{{ csrf_token() }}" },
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    location.reload(); // Reload the page to update status
                }
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseJSON.message);
            }
        });
    });
});


$(document).ready(function () {
 $('#orderStatusFilter').on('change', function() {
            let selectedStatus = $(this).val().toLowerCase();

            $('.order').each(function() {
                let orderStatus = $(this).data('status');

                if (selectedStatus === 'all' || orderStatus === selectedStatus) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
});

</script>


@endsection
