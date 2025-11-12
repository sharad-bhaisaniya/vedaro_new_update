@extends('layouts.admin_lay')

@section('title', 'Edit Expense')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit me-2"></i> Edit Expense</h2>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- ✅ Error Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small">
            <strong><i class="bi bi-exclamation-triangle"></i> Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Expense Type, Amount, Date, Payment --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Expense Type <span class="text-danger">*</span></label>
                        <select name="expense_type" class="form-select form-select-sm @error('expense_type') is-invalid @enderror" required>
                            <option value="">Select Expense Type</option>
                            @php
                                $types = [
                                    'Marketing', 'Courier / Shipping', 'Packaging', 'Website / Hosting',
                                    'Advertisement', 'Office Rent', 'Utilities', 'Staff Salary',
                                    'Repair / Maintenance', 'Miscellaneous'
                                ];
                            @endphp
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ old('expense_type', $expense->expense_type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_type') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small">Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" step="0.01" class="form-control form-control-sm @error('amount') is-invalid @enderror" 
                               value="{{ old('amount', $expense->amount) }}" required>
                        @error('amount') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control form-control-sm @error('expense_date') is-invalid @enderror" 
                               value="{{ old('expense_date', $expense->expense_date) }}" required>
                        @error('expense_date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small">Payment Type</label>
                        <select name="payment_type" class="form-select form-select-sm @error('payment_type') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Cash" {{ old('payment_type', $expense->payment_type) == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="UPI" {{ old('payment_type', $expense->payment_type) == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank" {{ old('payment_type', $expense->payment_type) == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="Card" {{ old('payment_type', $expense->payment_type) == 'Card' ? 'selected' : '' }}>Card</option>
                        </select>
                        @error('payment_type') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Transaction Number & Description --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Transaction No. (Optional)</label>
                        <input type="text" name="transaction_number" class="form-control form-control-sm @error('transaction_number') is-invalid @enderror"
                               value="{{ old('transaction_number', $expense->transaction_number) }}">
                        @error('transaction_number') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small">Description</label>
                        <input type="text" name="description" class="form-control form-control-sm @error('description') is-invalid @enderror"
                               value="{{ old('description', $expense->description) }}" placeholder="Short detail about expense">
                        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Bill Upload & Note --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small">Upload Bill (Optional)</label>
                        <input type="file" name="bill_image" class="form-control form-control-sm @error('bill_image') is-invalid @enderror" accept="image/*,.pdf">
                        @error('bill_image') <div class="text-danger small">{{ $message }}</div> @enderror

                        @if ($expense->bill_image)
                            <div class="mt-2">
                                @if (Str::endsWith($expense->bill_image, '.pdf'))
                                    <a href="{{ asset($expense->bill_image) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> View PDF
                                    </a>
                                @else
                                    <img src="{{ asset($expense->bill_image) }}" alt="Bill" class="img-thumbnail mt-1" style="max-height: 80px;">
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small">Note</label>
                        <input type="text" name="note" class="form-control form-control-sm @error('note') is-invalid @enderror"
                               value="{{ old('note', $expense->note) }}" placeholder="Extra information (if any)">
                        @error('note') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm px-4">
                        <i class="bi bi-save"></i> Update Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
