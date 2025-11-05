@extends('layouts.admin_lay')

@section('content')

<div class="container py-5">

  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <h1 class="h3 fw-bold text-dark mb-3 mb-md-0">
      <i class="fas fa-file-invoice text-primary me-2"></i> All Invoices
    </h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i> Create New Invoice
    </a>
  </div>

  <!-- Filters and Search -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form id="filterForm" method="GET" action="{{ route('invoices.index') }}">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search invoices..." value="{{ request('search') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="">All Statuses</option>
              <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
              <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Date Range</label>
            <select name="date_range" class="form-select">
              <option value="">All Dates</option>
              <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
              <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
              <option value="quarter" {{ request('date_range') == 'quarter' ? 'selected' : '' }}>This Quarter</option>
              <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>This Year</option>
            </select>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary me-2">
              <i class="fas fa-filter me-1"></i> Apply Filters
            </button>
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
              <i class="fas fa-times me-1"></i> Clear Filters
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex align-items-center">
          <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
            <i class="fas fa-file-invoice fs-4"></i>
          </div>
          <div>
            <p class="mb-0 text-muted small">Total Invoices</p>
            <h5 class="fw-bold mb-0">{{ $totalInvoices }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex align-items-center">
          <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
            <i class="fas fa-check-circle fs-4"></i>
          </div>
          <div>
            <p class="mb-0 text-muted small">Paid</p>
            <h5 class="fw-bold mb-0">{{ $paidInvoices }}</h5>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex align-items-center">
          <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
            <i class="fas fa-clock fs-4"></i>
          </div>
          <div>
            <p class="mb-0 text-muted small">Pending</p>
            <h5 class="fw-bold mb-0">{{ $pendingInvoices }}</h5>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="col-md-3">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex align-items-center">
          <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle me-3">
            <i class="fas fa-exclamation-circle fs-4"></i>
          </div>
          <div>
            <p class="mb-0 text-muted small">Overdue</p>
            <h5 class="fw-bold mb-0">{{ $overdueInvoices }}</h5>
          </div>
        </div>
      </div>
    </div> --}}
  </div>

  <!-- Invoices Table -->
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Invoice #</th>
            <th>Customer ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Online/Offline</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($invoices as $invoice)
          <tr>
            <td class="fw-semibold text-primary">#{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->user_id }}</td>
            <td>{{ $invoice->customer_name }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
            <td class="fw-semibold">₹{{ number_format($invoice->total, 2) }}</td>
            <td>
              @if($invoice->offline_online == 'online')
                <span class="badge bg-primary ">Online</span>
                {{-- @elseif($invoice->invoice_date->addDays(30) < now())
                <span class="badge bg-danger">Overdue</span> --}}
              @else
                <span style="background: #20c997;" class="badge ">Offline</span>
              @endif
            </td>
            <td>
              @if($invoice->due_amount == 0)
                <span class="badge bg-success">Paid</span>
                {{-- @elseif($invoice->invoice_date->addDays(30) < now())
                <span class="badge bg-danger">Overdue</span> --}}
              @else
                <span class="badge bg-warning text-dark">Pending</span>
              @endif
            </td>
            <td class="text-center">
                <a href="{{ route('invoices.bill', $invoice->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                @if($invoice->offline_online == 'offline')
              <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="fas fa-edit"></i></a>
               @endif
              <form action="{{ route('invoice.destroy',$invoice->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-4">
              <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
              <p class="text-muted">No invoices found.</p>
              <a href="{{ route('invoices.create') }}" class="btn btn-primary">Create Your First Invoice</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($invoices->hasPages())
    <div class="card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center">
      <div class="mb-2 mb-sm-0">
        <small class="text-muted">
          Showing <span class="fw-semibold">{{ $invoices->firstItem() }}</span> to <span class="fw-semibold">{{ $invoices->lastItem() }}</span> of <span class="fw-semibold">{{ $invoices->total() }}</span> results
        </small>
      </div>
      <nav>
        {{ $invoices->links() }}
      </nav>
    </div>
    @endif
  </div>

</div>
@endsection

<script>
    // Simple JavaScript for filtering and search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.querySelector('select[name="status"]');
        const dateRangeFilter = document.querySelector('select[name="date_range"]');
        const searchInput = document.querySelector('input[name="search"]');
        const filterForm = document.getElementById('filterForm');

        // Auto-submit form when filters change
        [statusFilter, dateRangeFilter].forEach(select => {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });

        // Add debounce to search input
        let debounceTimer;
        searchInput.addEventListener('keyup', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });
    });
</script>
