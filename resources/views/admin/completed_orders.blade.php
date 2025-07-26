@extends('layouts.admin_lay')

@section('title', 'All Orders')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Orders</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Source</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Tracking</th>
                </tr>
            </thead>
            <tbody>
                {{-- Local Orders --}}
                @foreach ($localOrders as $order)
                    <tr>
                        <td><span class="badge bg-success">Local</span></td>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment_method ?? 'N/A' }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->product_name }} × {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>₹{{ $order->total ?? 'N/A' }}</td>
                        <td>N/A</td>
                    </tr>
                @endforeach

                {{-- Shiprocket Orders --}}
                @foreach ($shiprocketOrders as $order)
                    <tr>
                        <td><span class="badge bg-primary">Shiprocket</span></td>
                        <td>#{{ $order['channel_order_id'] }}</td>
                        <td>{{ $order['customer_name'] }}</td>
                        <td>{{ $order['status'] }}</td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach ($order['order_items'] as $item)
                                    <li>{{ $item['name'] }} × {{ $item['quantity'] }}</li>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
