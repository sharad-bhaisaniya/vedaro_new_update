@extends('layouts.admin_lay')

@section('title', 'Expenses List')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-money-bill-wave me-2"></i> Expenses
        </h2>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Expense
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount (₹)</th>
                            <th>Date</th>
                            <th>Payment Type</th>
                            <th>Bill</th>
                            <th>Note</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $expense->expense_type }}</td>
                                <td>{{ $expense->formatted_amount }}</td>
                                <td>{{ $expense->formatted_date }}</td>
                                <td>{{ $expense->payment_type ?? '-' }}</td>
                                <td>
                                    @if($expense->bill_image)
                                        <a href="{{ asset('storage/' . $expense->bill_image) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            View
                                        </a>
                                    @else
                                        <span class="text-muted">No Bill</span>
                                    @endif
                                </td>
                                <td>{{ $expense->note ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Delete this expense?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
