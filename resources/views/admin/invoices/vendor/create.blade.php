@extends('layouts.admin_lay')

@section('title', 'Create Vendor')

@section('content')
<style>
.vendor-form-section {
    max-width: 900px;
    margin: 0 auto;
    padding: 15px;
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.08);
    font-size: 0.9rem;
}

.vendor-form-header h5 {
    font-size: 1.1rem;
    margin: 0;
}

.form-section {
    background: #f8f9fa;
    border-radius: 4px;
    margin-bottom: 15px;
    padding: 10px;
}

.form-section-title {
    font-size: 0.95rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 2px;
}

.form-label.small {
    font-size: 0.85rem;
    margin-bottom: 3px;
}

.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    font-size: 0.875rem;
    padding: 3px 8
    padding: 3px 8px;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

.text-muted {
    font-size: 0.75rem;
}
</style>

<div class="vendor-form-section">
    <div class="vendor-form-header d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Create New Vendor</h5>
        <button class="btn btn-outline-primary btn-sm">
            <i class="fas fa-sync-alt"></i> Prefill from GST
        </button>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendor.store') }}" method="POST">
        @csrf

        <!-- Primary Contact -->
        <div class="form-section p-2">
            <h6 class="form-section-title mb-2">Primary Contact</h6>
            <div class="row g-2">
                <div class="col-md-2">
                    <label class="form-label small">Salutation</label>
                    <select class="form-select form-select-sm" name="salutation">
                        <option value="">Select</option>
                        <option value="Mr." {{ old('salutation') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Mrs." {{ old('salutation') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms." {{ old('salutation') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                        <option value="Dr." {{ old('salutation') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label small">First Name *</label>
                    <input type="text" name="first_name" class="form-control form-control-sm"
                           value="{{ old('first_name') }}" required>
                </div>

                <div class="col-md-5">
                    <label class="form-label small">Last Name *</label>
                    <input type="text" name="last_name" class="form-control form-control-sm"
                           value="{{ old('last_name') }}" required>
                </div>
            </div>
        </div>

        <!-- Company Info -->
        <div class="form-section p-2">
            <h6 class="form-section-title mb-2">Company Information</h6>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small">Company Name</label>
                    <input type="text" name="company_name" class="form-control form-control-sm"
                           value="{{ old('company_name') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Display Name *</label>
                    <input type="text" name="display_name" class="form-control form-control-sm"
                           value="{{ old('display_name') }}" required>
                    <small class="text-muted">Select or type to add</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label small">GSTIN</label>
                    <input type="text" name="gst_no" class="form-control form-control-sm"
                           value="{{ old('gst_no') }}">
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="form-section p-2">
            <h6 class="form-section-title mb-2">Contact Information</h6>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm"
                           value="{{ old('email') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Phone</label>
                    <input type="text" name="phone" class="form-control form-control-sm"
                           value="{{ old('phone') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label small">Mobile</label>
                    <input type="text" name="mobile" class="form-control form-control-sm"
                           value="{{ old('mobile') }}">
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-2">
            <label class="form-label small">Status *</label>
            <select class="form-select form-select-sm" name="status" required>
                <option value="">Select Status</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Address -->
        <div class="form-section p-2">
            <h6 class="form-section-title mb-2">Address</h6>
            <textarea name="address" class="form-control form-control-sm" rows="2"
                      placeholder="Enter full address">{{ old('address') }}</textarea>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2 mt-2">
            <button type="submit" class="btn btn-primary btn-sm">Save Vendor</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.history.back()">Cancel</button>
        </div>
    </form>
</div>
@endsection

