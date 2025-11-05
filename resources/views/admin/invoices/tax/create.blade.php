@extends('layouts.admin_lay')

@section('content')
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
        border: none;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
    }

    .input-group-outline {
        position: relative;
    }

    .input-group-outline .form-control {
        border: 1px solid #d2d6da;
        background-color: transparent;
    }

    .input-group-outline .form-control:focus {
        border-color: #1a73e8;
    }

    .btn {
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }

    .btn i {
        vertical-align: middle;
        margin-right: 5px;
        font-size: 18px;
    }

    .bg-gradient-primary {
        background: linear-gradient(195deg, #1a73e8 0%, #0d47a1 100%);
    }

    .bg-gradient-secondary {
        background: linear-gradient(195deg, #6c757d 0%, #495057 100%);
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Create New Tax</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="container">
                        <form method="POST" action="{{ route('taxes.store') }}" class="px-4 py-3">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Tax Name <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-outline">
                                            <input id="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name" value="{{ old('name') }}"
                                                   required autocomplete="name" autofocus>
                                        </div>
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate" class="form-label">Rate (%) <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-outline">
                                            <input id="rate" type="number" step="0.01"
                                                   class="form-control @error('rate') is-invalid @enderror"
                                                   name="rate" value="{{ old('rate') }}"
                                                   required autocomplete="rate">
                                        </div>
                                        @error('rate')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_group" class="form-label">Tax Type</label>
                                        <div class="input-group input-group-outline">
                                            <select id="type" class="form-control @error('type') is-invalid @enderror" name="tax_group">
                                                <option value="" disabled selected>Select a Tax Type</option>

                                                <option value="CGST" {{ old('type') == 'gst' ? 'selected' : '' }}>CGST</option>
                                                <option value="SGST" {{ old('type') == 'gst' ? 'selected' : '' }}>SGST</option>
                                                <option value="IGST" {{ old('type') == 'gst' ? 'selected' : '' }}>IGST</option>
                                                <option value="UTGST" {{ old('type') == 'gst' ? 'selected' : '' }}>UTGST</option>

                                                <option value="Cess" {{ old('type') == 'other' ? 'selected' : '' }}>Cess</option>
                                            </select>
                                        </div>
                                        @error('type')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary bg-gradient-primary">
                                        <i class="material-icons">save</i> Save
                                    </button>
                                    <a href="{{ route('taxes.index') }}" class="btn btn-secondary bg-gradient-secondary">
                                        <i class="material-icons">cancel</i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


