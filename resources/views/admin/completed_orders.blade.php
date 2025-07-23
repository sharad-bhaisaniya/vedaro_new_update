<!-- In resources/views/admin/completed_orders.blade.php -->
@extends('layouts.admin_lay')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">
            <h1>Completed Orders</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Shipping Address</th>
                            <th>Billing Address</th>
                            <th>Items</th>
                            <th class="fixed-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->full_name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->amount }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->shipping_address }}</td>
                                <td>{{ $order->billing_address }}</td>
                                <td>
                                    <ul>
                                        @foreach($order->items as $item)
                                            <li> Quantity: {{ $item->product_qty }} - Price: {{ $item->price }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="fixed-column">
                                    <button class="ship_now" data-order-id="{{ $order->order_id }}" data-status="{{ $order->status }}">
                                        @if($order->status == 'Shipped') 
                                            Shipped 
                                        @else 
                                            Ship Now 
                                        @endif
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.ship_now').each(function() {
        var status = $(this).data('status');
        if (status === 'Shipped') {
            $(this).text('Shipped');
            $(this).prop('disabled', true); // Disable the button if the order is shipped
        }
    });

    $('.ship_now').click(function() {
        var orderId = $(this).data('order-id');
        var button = $(this);  // Reference to the clicked button
        var row = button.closest('tr');  // The entire row containing the order

        button.text('Shipped');
        button.prop('disabled', true);

        row.find('td:nth-child(7)').text('Shipped');  // Update status column in the same row

        $.ajax({
            url: '{{ route('ship.order') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: orderId
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);  // Show success message
                } else {
                    button.text('Ship Now');
                    button.prop('disabled', false);
                    alert(response.message);
                }
            },
            error: function(xhr) {
                button.text('Ship Now');
                button.prop('disabled', false);
                alert('An error occurred while processing the request.');
            }
        });
    });
});
</script>


<style>
.table-fixed th, .table-fixed td {
    width: 150px; /* Adjust the width as needed */
}

.fixed-column {
    position: sticky;
    right: 0;
    background-color: #f2f2f2 !important; /* Match the background of your table header */
}
.ship_now {
    border: none;
    background: forestgreen;
    color: #fff;
    padding: 3px 10px;
    font-size: 13px;
    border-radius: 4px;
}
.container {
    width: 100% !important;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
}
.table {
    min-width: 1800px; /* Adjust to match your table's content */
}
/* In public/css/app.css */
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 1.2em;
    text-align: left;
    border: 1px solid #ddd;
}

.table td {
    padding: 5px !important;
    font-size: 13px;
    vertical-align: middle;
}
.table th {
     padding: 12px 8px !important;
    background-color: #f2f2f2;
    font-size: 16px;
}

.table tr {
    border-bottom: 1px solid #ddd;
}

.table tr:nth-of-type(even) {
    background-color: #f9f9f9;
}

.table tr:last-of-type {
    border-bottom: 2px solid #009879;
}
</style>
