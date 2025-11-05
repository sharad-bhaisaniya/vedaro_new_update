@extends('layouts.admin_lay')

@section('content')
<style>
.cursor-pointer { cursor: pointer; }
.details-div { border-radius: 5px; }
.badge-success { background-color: #28a745; color: #fff; }
.badge-secondary { background-color: #6c757d; color: #fff; }

/* Enhanced table inside details div */
.enhanced-table {
    font-size: 0.85rem; /* smaller font */
}
.enhanced-table thead th {
    background-color: #007bff;
    color: #fff;
    border-color: #0069d9;
}
.enhanced-table tbody tr:nth-child(even) {
    background-color: #f2f9ff;
}
.enhanced-table tbody tr:nth-child(odd) {
    background-color: #e6f2ff;
}
.enhanced-table td, .enhanced-table th {
    padding: 0.35rem 0.5rem;
    vertical-align: middle;
}
</style>

{{-- Toast container --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    @if (session('info'))
        <div class="toast align-items-center text-bg-info border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="toastMessage">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('info') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

{{-- Script to auto-show and hide toast --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('toastMessage');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 }); // 4s delay
            toast.show();
        }
    });
</script>



<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Purchase Invoices</h2>
        <a href="{{ route('purchase.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Purchase
        </a>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Purchases</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Vendor GST</th>
                            <th>Grand Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $index => $purchase)
                        <tr class="purchase-row cursor-pointer" data-purchase-id="{{ $purchase->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $purchase->invoice_number }}</td>
                            <td>{{ $purchase->invoice_date->format('d-m-Y') }}</td>
                            <td>{{ $purchase->vendor->display_name ?? 'N/A' }}</td>
                            <td>{{ $purchase->vendor_gstin }}</td>
                            <td><strong>₹ {{ number_format($purchase->grand_total, 2) }}</strong></td>
                            <td>
                                <button class="btn btn-sm btn-info toggle-details">View Details</button>
                                <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                {{--<form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>--}}
                            </td>
                        </tr>

                        {{-- Details div hidden initially --}}
                        <tr class="details-container">
                            <td colspan="7">
                                <div class="details-div p-3 bg-light shadow-sm" style="display: none;">

                                    {{-- Purchase Items --}}
                                    <h6 class="text-primary">Purchase Items</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0 enhanced-table">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Item Code</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Discount %</th>
                                                    <th>Net Price</th>
                                                    <th>Tax Amount</th>
                                                    <th>Total Incl. Tax</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchase->items as $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->item_code }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₹ {{ number_format($item->unit_price, 2) }}</td>
                                                    <td>{{ $item->discount_percentage }}%</td>
                                                    <td>₹ {{ number_format($item->net_price, 2) }}</td>
                                                    <td>₹ {{ number_format($item->tax_amount, 2) }}</td>
                                                    <td><strong>₹ {{ number_format($item->total_incl_tax, 2) }}</strong></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No purchases found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.toggle-details').on('click', function() {
        var detailsDiv = $(this).closest('tr').next('.details-container').find('.details-div');
        detailsDiv.slideToggle();
    });
});
</script>
@endsection
