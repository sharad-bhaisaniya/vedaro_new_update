@extends('layouts.admin_lay')

@section('title', 'Edit Vendor')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Vendor</h5>
            <small class="text-white-50">Update vendor details below</small>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Salutation -->
                    <div class="col-md-2">
                        <label class="form-label small">Salutation</label>
                        <select class="form-select form-select-sm" name="salutation">
                            <option value="">Select</option>
                            <option value="Mr." {{ old('salutation', $vendor->salutation) == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                            <option value="Mrs." {{ old('salutation', $vendor->salutation) == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                            <option value="Ms." {{ old('salutation', $vendor->salutation) == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                            <option value="Dr." {{ old('salutation', $vendor->salutation) == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        </select>
                    </div>

                    <!-- First Name -->
                    <div class="col-md-5">
                        <label class="form-label small">First Name *</label>
                        <input type="text" name="first_name" class="form-control form-control-sm"
                               value="{{ old('first_name', $vendor->first_name) }}" required>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-5">
                        <label class="form-label small">Last Name *</label>
                        <input type="text" name="last_name" class="form-control form-control-sm"
                               value="{{ old('last_name', $vendor->last_name) }}" required>
                    </div>

                    <!-- Display Name -->
                    <div class="col-md-6">
                        <label class="form-label small">Display Name *</label>
                        <input type="text" name="display_name" class="form-control form-control-sm"
                               value="{{ old('display_name', $vendor->display_name) }}" required>
                    </div>

                    <!-- Company Name -->
                    <div class="col-md-6">
                        <label class="form-label small">Company Name</label>
                        <input type="text" name="company_name" class="form-control form-control-sm"
                               value="{{ old('company_name', $vendor->company_name) }}">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm"
                               value="{{ old('email', $vendor->email) }}">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-3">
                        <label class="form-label small">Phone</label>
                        <input type="text" name="phone" class="form-control form-control-sm"
                               value="{{ old('phone', $vendor->phone) }}">
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-3">
                        <label class="form-label small">Mobile</label>
                        <input type="text" name="mobile" class="form-control form-control-sm"
                               value="{{ old('mobile', $vendor->mobile) }}">
                    </div>

                    <!-- GSTIN -->
                    <div class="col-md-6">
                        <label class="form-label small">GSTIN</label>
                        <input type="text" name="gst_no" class="form-control form-control-sm"
                               value="{{ old('gst_no', $vendor->gst_no) }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label small">Status *</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="active" {{ old('status', $vendor->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $vendor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label class="form-label small">Address</label>
                        <textarea name="address" class="form-control form-control-sm" rows="3">{{ old('address', $vendor->address) }}</textarea>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Update Vendor</button>
                    <a href="{{ route('vendor.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
