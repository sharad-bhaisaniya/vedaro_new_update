@extends('layouts.admin_lay')

@section('title', 'Pending Orders')

@section('content')
<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">
            <h1>Pending Orders</h1>
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
                                    <button class="process_now">
                                        Process Now
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

<style>
.table-fixed th, .table-fixed td {
    width: 150px; /* Adjust the width as needed */
}

.fixed-column {
    position: sticky;
    right: 0;
    background-color: #f2f2f2 !important; /* Match the background of your table header */
}
.process_now {
    border: none;
    background: darkorange;
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
    padding: 8px !important;
    font-size: 14px;
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
