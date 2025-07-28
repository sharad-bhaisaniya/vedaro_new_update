@extends('layouts.admin_lay')
@section('title', 'All Orders')
@section('content')
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
    /* Added style for product image */
    .product-image-thumbnail {
        width: 50px; /* Adjust as needed */
        height: 50px; /* Adjust as needed */
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
</style>
<div class="container-fluid px-4">
	<div class="card shadow mb-4">
		<div class="card-header d-flex justify-content-between align-items-center">
			<h2 class="m-0 font-weight-bold text-warning">
				<i class="fas fa-clock text-warning"></i> Pending Orders
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
			<table class="table table-bordered align-middle">
				<thead class="table-dark">
					<tr>
						<th>#</th>
						<th>Order ID</th>
						<th>Customer</th>
						<th>Date</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Details</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $index => $order)
					<tr>
						<td>{{ $index + 1 }}</td>
						<td>{{ $order['order_id'] }}</td>
						<td>{{ $order->full_name ?? 'N/A' }}</td>
						<td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}<br><small>{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</small></td>
						<td>{{ $order['phone'] ?? 'N/A' }}</td>
						<td>{{ $order['email'] ?? 'N/A' }}</td>
						<td>₹{{ number_format($order->amount, 2) }}</td>
						<td>{{ $order['status'] }}</td>
						<td>
							<button class="btn btn-sm btn-outline-primary eye-button" data-target="detail-{{ $order['order_id'] }}">
							<i class="fas fa-eye"></i>
							</button>
						</td>
						<td>
							<button class="btn btn-sm {{ $order->status == 'Shipped' ? 'btn-secondary' : 'btn-success' }} ship_now"
							data-order-id="{{ $order->order_id }}"
							data-status="{{ $order->status }}"
							{{ $order->status == 'Shipped' ? 'disabled' : '' }}>
							{{ $order->status == 'Shipped' ? 'Shipped' : 'Ship Now' }}
							</button>
						</td>
					</tr>
					{{-- Hidden Row --}}
					<tr class="full-detail" id="detail-{{ $order['order_id'] }}" style="display: none;">
						<td colspan="11">
							<div class="">
								<div class="card border-0 rounded-lg">
									<div class="card-header text-white py-3 d-flex justify-content-between align-items-center" style="background-color:#FFC107">
										<div>
											<i class="bi bi-bag-fill me-2"></i>
											<span class="fw-bold fs-5">Order Summary</span>
										</div>
										<span>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</span>
									</div>
									<div class="card-body">
										<div class="row g-3">
											<div class="col-md-4">
												<p class="mb-2"><i class="bi bi-person-circle me-1"></i><strong>Name:</strong> {{ $order->full_name }}</p>
												<p class="mb-2"><i class="bi bi-envelope me-1"></i><strong>Email:</strong> {{ $order['email'] ?? 'N/A' }}</p>
												<p><i class="bi bi-telephone me-1"></i><strong>Phone:</strong> {{ $order['phone'] ?? 'N/A' }}</p>
											</div>
											<div class="col-md-4">
												<p class="mb-2"><i class="bi bi-currency-rupee me-1"></i><strong>Total Amount:</strong> ₹{{ number_format($order->amount, 2) }}</p>
											</div>
											<div class="col-md-4">
												<p class="mb-1">
													<i class="bi bi-geo-alt me-1"></i><strong>Shipping Address:</strong>
													<br>
													<span class="text-muted small">
														{{ $order->shipping_address ?? '' }}
														{{ $order->city ?? '' }},
														{{ $order->state ?? '' }}
														{{ $order->postal_code ?? '' }}
													</span>
												</p>
												<p class="mb-0"><i class="bi bi-house-door me-1"></i><strong>Billing Address:</strong>
													<br>
													<span class="text-muted small">
													{{ $order->billing_address ?? 'N/A' }},
													{{ $order->city ?? '' }},
													{{ $order->state ?? '' }},
													{{ $order->pincode ?? '' }}
													{{ $order->postal_code ?? '' }}
													</span>
												</p>
											</div>
										</div>
										<hr>
										<div>
											<div class="d-flex justify-content-between align-items-center mb-2">
												<span class="fw-semibold">Order Items</span>
												@php
													$orderItems = $order->items;
													$totalCount = $orderItems->count();
												@endphp
												<span class="badge bg-primary bg-opacity-75 fs-6">Total: {{ $totalCount }}</span>
											</div>
											<ul class="list-group">
												@if ($orderItems->isNotEmpty())
													@foreach ($orderItems as $item)
													<li class="list-group-item border-0 border-bottom d-flex align-items-center"> {{-- Changed to align-items-center for vertical alignment --}}
                                                        {{-- Product Image --}}
                                                        @if($item->product && $item->product->image1)
                                                            <img src="{{ asset('public/storage/products/' . $item->product->image1) }}" alt="{{ $item->product->productName ?? 'Product Image' }}" class="product-image-thumbnail">
                                                        @else
                                                            {{-- Fallback for no image --}}
                                                            <img src="{{ asset('images/placeholder.png') }}" alt="No Image" class="product-image-thumbnail"> {{-- Create a placeholder.png in public/images --}}
                                                        @endif
														<div>
															<div class="fw-bold">{{ $item->product->productName ?? $item->name ?? 'N/A' }}</div>
															<div class="text-muted small">Qty: {{ $item->product_qty ?? 'N/A' }}</div>
														</div>
														<span class="text-primary fw-bold ms-auto">₹{{ number_format($item->price ?? 0, 2) }}</span> {{-- Used ms-auto to push price to the right --}}
													</li>
													@endforeach
												@else
												<li class="list-group-item text-danger">No items found for this order.</li>
												@endif
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
{{-- Toggle Script --}}
<script>
	document.addEventListener("DOMContentLoaded", function () {
	    const eyeButtons = document.querySelectorAll(".eye-button");

	    eyeButtons.forEach(button => {
	        button.addEventListener("click", () => {
	            const targetId = button.getAttribute("data-target");
	            const detailRow = document.getElementById(targetId);
	            if (detailRow.style.display === "none" || detailRow.style.display === "") {
	                detailRow.style.display = "table-row";
	            } else {
	                detailRow.style.display = "none";
	            }
	        });
	    });
	});
</script>
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
@endsection