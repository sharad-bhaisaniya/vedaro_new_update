@extends('layouts.admin_lay')

@section('title', 'Add Expense')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-plus-circle me-2"></i> Add Expense</h2>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- ✅ Global Error Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <strong><i class="bi bi-exclamation-triangle"></i> Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Expense Type & Amount --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Expense Type <span class="text-danger">*</span></label>
                        <select name="expense_type" class="form-select form-select-sm" required>
                            <option value="">Select Expense Type</option>
                            <option value="Marketing" {{ old('expense_type') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Courier / Shipping" {{ old('expense_type') == 'Courier / Shipping' ? 'selected' : '' }}>Courier / Shipping</option>
                            <option value="Packaging" {{ old('expense_type') == 'Packaging' ? 'selected' : '' }}>Packaging</option>
                            <option value="Website / Hosting" {{ old('expense_type') == 'Website / Hosting' ? 'selected' : '' }}>Website / Hosting</option>
                            <option value="Advertisement" {{ old('expense_type') == 'Advertisement' ? 'selected' : '' }}>Advertisement</option>
                            <option value="Office Rent" {{ old('expense_type') == 'Office Rent' ? 'selected' : '' }}>Office Rent</option>
                            <option value="Utilities" {{ old('expense_type') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                            <option value="Staff Salary" {{ old('expense_type') == 'Staff Salary' ? 'selected' : '' }}>Staff Salary</option>
                            <option value="Repair / Maintenance" {{ old('expense_type') == 'Repair / Maintenance' ? 'selected' : '' }}>Repair / Maintenance</option>
                            <option value="Miscellaneous" {{ old('expense_type') == 'Miscellaneous' ? 'selected' : '' }}>Miscellaneous</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small">Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" step="0.01" class="form-control form-control-sm" value="{{ old('amount') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control form-control-sm" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Payment Type</label>
                        <select name="payment_type" class="form-select form-select-sm">
                            <option value="">Select</option>
                            <option value="Cash" {{ old('payment_type') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="UPI" {{ old('payment_type') == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank" {{ old('payment_type') == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="Card" {{ old('payment_type') == 'Card' ? 'selected' : '' }}>Card</option>
                        </select>
                    </div>
                </div>

                {{-- Transaction Number & Description --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Transaction No. (Optional)</label>
                        <input type="text" name="transaction_number" class="form-control form-control-sm" value="{{ old('transaction_number') }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small">Description</label>
                        <input type="text" name="description" class="form-control form-control-sm" value="{{ old('description') }}" placeholder="Short detail about expense">
                    </div>
                </div>

                {{-- Bill Image & Note --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Upload Bill (Optional)</label>
                        <input type="file" name="bill_image" class="form-control form-control-sm" accept="image/*,.pdf">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small">Note</label>
                        <input type="text" name="note" class="form-control form-control-sm" value="{{ old('note') }}" placeholder="Extra information (if any)">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm px-4">
                        <i class="bi bi-save"></i> Save Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
