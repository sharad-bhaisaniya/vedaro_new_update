@extends('layouts.admin_lay')

@section('title', 'Pending Orders')

@section('content')

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-primary">
                <i class="fas fa-clock text-warning"></i> Pending Orders
            </h3>
            <div class="d-flex">
                <input type="text" class="form-control form-control-sm me-2" placeholder="Search orders...">
                <button class="btn btn-danger btn-sm"><i class="fas fa-file-export"></i> Export</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Shipping</th>
                        <th>Billing</th>
                        <th>Items</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}<br><small>{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</small></td>
                        <td>{{ $order->full_name }}</td>
                        <td>{{ $order->phone ?? 'N/A' }}</td>
                        <td class="text-danger">₹{{ number_format($order->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $order->status == 'Shipped' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->shipping_address }}</td>
                        <td>{{ $order->billing_address }}</td>
                        <td>{{ count($order->items) }} Items</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderItemsModal{{ $order->order_id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm ship_now {{ $order->status == 'Shipped' ? 'btn-secondary' : 'btn-success' }} "
                                data-order-id="{{ $order->order_id }}" 
                                data-status="{{ $order->status }}"
                                {{ $order->status == 'Shipped' ? 'disabled' : '' }}>
                                {{ $order->status == 'Shipped' ? 'Shipped' : 'Ship Now' }}
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="orderItemsModal{{ $order->order_id }}" tabindex="-1" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="orderItemsModalLabel">Order #{{ $order->order_id }} Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Items:</h6>
                                    <ul>
                                        @foreach($order->items as $item)
                                            <li>Qty: {{ $item->product_qty }} — ₹{{ $item->price }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Details:</h6>
                                    <ul>
                                        @foreach($order->items as $item)
                                            <li>Size: {{ $item->product->size ?? 'N/A' }} | Weight: {{ $item->product->weight ?? 'N/A' }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.ship_now').click(function() {
        const orderId = $(this).data('order-id');
        const button = $(this);
        button.text('Shipped').prop('disabled', true);

        $.ajax({
            url: '{{ route("ship.order") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: orderId
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    button.removeClass('btn-success').addClass('btn-secondary');
                    button.closest('tr').find('span.badge').removeClass('bg-warning text-dark').addClass('bg-success').text('SHIPPED');
                } else {
                    button.text('Ship Now').prop('disabled', false);
                    alert(response.message);
                }
            },
            error: function() {
                button.text('Ship Now').prop('disabled', false);
                alert('An error occurred while processing the request.');
            }
        });
    });
});
</script>
@endpush
