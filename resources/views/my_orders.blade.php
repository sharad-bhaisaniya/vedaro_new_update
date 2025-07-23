@extends('layouts.main')

@section('title', 'My Orders')

@section('content')
<div class="sect_head"></div>

<div class="orders-page-container">
    <h1 class="orders-page-title">My Orders</h1>

    @forelse ($orders as $order)
        <div class="order">
            <div class="order-header">
                <h2>Order #{{ $order->order_id }}</h2>
                <p>Placed on: <span class="order-date">{{ $order->created_at->format('Y-m-d') }}</span></p>
            </div>

<div class="order-details">
    @forelse ($order->items as $item)
        <div class="order-item">
            @php
                $product = $item->product;
                $image = $product && $product->image1 ? asset('public/storage/products/' . $product->image1) : asset('images/default.jpg');
                $productName = $product->name ?? 'Product not available';
            @endphp

            <img src="{{ $image }}" alt="Product Image" class="order-item-image">

            <div class="order-item-info">
                <p class="product-name">{{ $productName }}</p>
                <p class="product-quantity">Quantity: {{ $item->product_qty }}</p>
                <p class="product-price">₹{{ number_format($item->price, 2) }}</p>
            </div>
        </div>
    @empty
        <p>No items found for this order.</p>
    @endforelse
</div>

            <div class="order-summary">
                <div class="order-status">
                    <button class="view_order_status"> 
                        Status: <span class="status">{{ $order->status }}</span>
                    </button>
                </div>
                <div class="order-payment">
                    <p>Payment Method: <span class="payment-method">Razorpay</span></p>
                </div>
                <div class="order-total">
                    <p>Total: <span class="total-price">₹{{ number_format($order->amount, 2) }}</span></p>
                </div>

                @if ($order->awb)
                <button class="track-order-btn" 
                    data-order_id="{{ $order->order_id }}" 
                    data-awb="{{ $order->awb }}">
                    Track Order
                </button>
                @endif
            </div>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</div>

<!-- Tracking Modal -->
<div id="orderTrackingModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:20px; border-radius:5px; box-shadow:0px 0px 10px rgba(0,0,0,0.3); z-index:999;">
    <div id="orderDetails"></div>
    <button id="closeModal">Close</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $(".track-order-btn").click(function () {
        var order_id = $(this).data("order_id");
        var awb = $(this).data("awb");

        if (!order_id || !awb) {
            alert("⚠️ Error: Order ID or AWB is missing!");
            return;
        }

        $("#orderDetails").html("Fetching tracking details...");

        $.ajax({
            url: "/track-order",
            type: "GET",
            data: { order_id: order_id, awb: awb },
            dataType: "json",
            success: function (response) {
                if (response.success && response.data && response.data.shipment_track.length > 0) {
                    var shipment = response.data.shipment_track[0];
                    const shippingDetails = `
                        <strong>AWB Number:</strong> ${shipment.awb_code || 'N/A'}<br>
                        <strong>Consignee Name:</strong> ${shipment.consignee_name || 'N/A'}<br>
                        <strong>Courier Name:</strong> ${shipment.courier_name || 'N/A'}<br>
                        <strong>Origin:</strong> ${shipment.origin || 'N/A'}<br>
                        <strong>Destination:</strong> ${shipment.destination || 'N/A'}<br>
                        <strong>Current Status:</strong> ${shipment.current_status || 'N/A'}<br>
                        <strong>Expected Delivery:</strong> ${shipment.edd || 'N/A'}<br>
                        <strong>Tracking Link:</strong> <a href="${response.tracking_url}" target="_blank">Track Order</a><br>
                    `;

                    $("#orderDetails").html(shippingDetails);
                    $("#orderTrackingModal").fadeIn();
                } else {
                    $("#orderDetails").html(`<p>Error: ${response.message || 'No tracking data available.'}</p>`);
                }
            },
            error: function (xhr, status, error) {
                console.error("❌ AJAX Error:", error);
                $("#orderDetails").html(`<p>Error fetching data.</p>`);
            }
        });
    });

    $("#closeModal").click(function () {
        $("#orderTrackingModal").fadeOut();
    });
});
</script>
@endsection
