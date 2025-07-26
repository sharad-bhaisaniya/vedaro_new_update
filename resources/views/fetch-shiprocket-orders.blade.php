@extends('layouts.main')

@section('title', 'My Orders')

@section('content')

<style>
    .card-header{
        width: 100%;
    }
</style>
  
  <div class="container" style="margin-top:150px">
    @foreach($processedOrders as $order)
    <div class="card mb-4">
        <div class="card-header">
            <h3>Order #{{ $order['channel_order_id'] }}</h3>
            <p class="mb-1">Date: {{ $order['order_date'] }}</p>
            <p class="mb-1">Status: <span class="badge bg-{{ $order['status'] === 'shipped' ? 'success' : 'warning' }}">
                {{ ucfirst($order['status']) }}
            </span></p>
            <p class="mb-1">Payment Method: {{ ucfirst($order['payment_method']) }}</p>
            <p class="mb-1">Order Total: ₹{{ number_format($order['order_total'], 2) }}</p>
            @if($order['tracking_url'])
                <a href="{{ $order['tracking_url'] }}" target="_blank" class="btn btn-sm btn-primary">
                    Track Order
                </a>
            @endif
                                <button class="btn btn-danger btn-sm cancel-order-btn"
                        data-order_id="{{ $order['order_id'] }}">
                        Cancel Order
                    </button>
        </div>
        
        <div class="card-body">
            <h4>Products:</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['order_items'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['sku'] }}</td>
                            <td>₹{{ number_format($item['price'], 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₹{{ number_format($item['total'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <h4 class="mt-4">Shipping Address:</h4>
            <address>
                {{ $order['shipping_address']['address'] }}<br>
                {{ $order['shipping_address']['city'] }}, 
                {{ $order['shipping_address']['state'] }} - 
                {{ $order['shipping_address']['pincode'] }}
            </address>
        </div>
    </div>
    @endforeach
    
    @if(count($processedOrders) === 0)
    <div class="alert alert-info">
        No orders found for your account.
    </div>
    @endif

  
  


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
