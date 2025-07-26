@extends('layouts.admin_lay')

@section('title', 'Canceled Orders')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-ban mr-2"></i>Canceled Orders
            </h2>
            <div class="d-flex">
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="canceledOrdersTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="120px">Order ID</th>
                            <th width="150px">Date</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th width="120px">Amount</th>
                            <th width="120px">Status</th>
                            <th width="200px">Shipping</th>
                            <th width="150px">Items</th>
                            <th width="100px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="font-weight-bold">
                                #{{ is_array($order) ? $order['order_id'] ?? $order['channel_order_id'] ?? 'N/A' : $order->order_id }}
                            </td>
                            <td>
                                @if(is_array($order))
                                <small class="text-muted">{{ \Carbon\Carbon::parse($order['created_at'] ?? '')->format('M d, Y') }}</small><br>
                                <small>{{ \Carbon\Carbon::parse($order['created_at'] ?? '')->format('h:i A') }}</small>
                                @else
                                <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small><br>
                                <small>{{ $order->created_at->format('h:i A') }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold">{{ is_array($order) ? $order['customer_name'] ?? 'Unknown' : $order->full_name }}</div>
                                <small class="text-muted">{{ is_array($order) ? $order['email'] ?? 'N/A' : $order->email }}</small>
                            </td>
                            <td>
                                {{ is_array($order) ? $order['phone'] ?? 'N/A' : $order->phone }}
                            </td>
                            <td class="font-weight-bold text-danger">
                                ₹{{ is_array($order) ? number_format($order['order_total'] ?? $order['total'] ?? 0, 2) : number_format($order->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge badge-danger text-dark">
                                    {{ is_array($order) ? ucfirst($order['status']) : ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                @if(is_array($order))
                                <small>
                                    {{ $order['shipping_address']['address'] ?? $order['customer_address'] ?? 'N/A' }}, 
                                    {{ $order['shipping_address']['city'] ?? $order['customer_city'] ?? '' }}, 
                                    {{ $order['shipping_address']['state'] ?? $order['customer_state'] ?? '' }}
                                </small>
                                @else
                                <small>{{ $order->shipping_address }}</small>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary view-items" 
                                        data-toggle="modal" 
                                        data-target="#itemsModal"
                                        data-items='@json(is_array($order) ? $order['order_items'] ?? [] : $order->items)'
                                        data-order-id="#{{ is_array($order) ? $order['order_id'] ?? $order['channel_order_id'] ?? 'N/A' : $order->order_id }}">
                                    {{ is_array($order) ? count($order['order_items'] ?? []) : $order->items->count() }} Items
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary view-details" 
                                            data-toggle="modal" 
                                            data-target="#orderModal"
                                            data-order='@json($order)'>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Re-order">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(count($orders) == 0)
            <div class="text-center py-5">
                <i class="fas fa-ban fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Canceled Orders Found</h4>
                <p class="text-muted">There are currently no canceled orders in the system.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Items Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1" role="dialog" aria-labelledby="itemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemsModalLabel">Order Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be inserted here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Order details will be inserted here via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
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

</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#canceledOrdersTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    // Tooltips
    $('[title]').tooltip();
    
    // Items Modal
    $('.view-items').click(function() {
        const items = $(this).data('items');
        const orderId = $(this).data('order-id');
        $('#itemsModalLabel').text(`Order ${orderId} - Items`);
        
        let html = '';
        if (Array.isArray(items)) {
            items.forEach(item => {
                const isArrayItem = item.hasOwnProperty('price'); // Check if it's from array data
                const name = isArrayItem ? item.name : (item.product ? item.product.name : 'N/A');
                const sku = isArrayItem ? item.sku : (item.product ? item.product.sku : 'N/A');
                const price = isArrayItem ? item.price : item.price;
                const quantity = isArrayItem ? item.quantity : item.product_qty;
                const total = price * quantity;
                
                html += `
                <tr>
                    <td>${name}</td>
                    <td>${sku}</td>
                    <td>₹${price.toFixed(2)}</td>
                    <td>${quantity}</td>
                    <td>₹${total.toFixed(2)}</td>
                </tr>
                `;
            });
        }
        $('#itemsTableBody').html(html || '<tr><td colspan="5" class="text-center">No items found</td></tr>');
    });
    
    // Order Details Modal
    $('.view-details').click(function() {
        const order = $(this).data('order');
        const isArray = Array.isArray(order);
        const orderId = isArray ? (order.order_id || order.channel_order_id || 'N/A') : order.order_id;
        
        let html = `
        <div class="row">
            <div class="col-md-6">
                <h5>Order Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="40%">Order ID</th>
                        <td>#${orderId}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>${isArray ? 
                            (order.created_at ? new Date(order.created_at).toLocaleString() : 'N/A') : 
                            new Date(order.created_at).toLocaleString()}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge badge-danger text-dark">${isArray ? order.status : order.status}</span></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td class="font-weight-bold">₹${isArray ? 
                            (order.order_total || order.total || 0).toFixed(2) : 
                            order.amount.toFixed(2)}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Customer Information</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="40%">Name</th>
                        <td>${isArray ? (order.customer_name || 'Unknown') : order.full_name}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>${isArray ? (order.email || 'N/A') : order.email}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>${isArray ? (order.phone || 'N/A') : order.phone}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h5>Shipping Address</h5>
                <address>
                    ${isArray ? 
                        (order.shipping_address ? 
                            `${order.shipping_address.address}<br>
                            ${order.shipping_address.city}, ${order.shipping_address.state}<br>
                            ${order.shipping_address.pincode}` : 
                            (order.customer_address || 'N/A')) : 
                        order.shipping_address}
                </address>
            </div>
            <div class="col-md-6">
                <h5>Billing Address</h5>
                <address>
                    ${isArray ? (order.billing_address || 'Same as shipping') : (order.billing_address || 'Same as shipping')}
                </address>
            </div>
        </div>
        `;
        
        $('#orderDetailsContent').html(html);
        $('#orderModalLabel').text(`Order #${orderId} Details`);
    });
});
</script>
@endsection