@extends('layouts.admin_lay')

@section('title', 'Vendors')

@section('content')

<style>
    .table th {
        white-space: nowrap;
    }
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
</style>


<div class="container-fluid">

    <!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success py-2 px-3">
        {{ session('success') }}
    </div>
@endif

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Vendors</h2>
                <div>
                    <a href="{{ route('vendor.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Vendor
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('vendor.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search vendors..." value="{{ request('search') }}" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary h-100 mx-2"  type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filters
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item" href="{{ route('vendor.index', ['status' => 'active']) }}">Active</a>
                                    <a class="dropdown-item" href="{{ route('vendor.index', ['status' => 'inactive']) }}">Inactive</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('vendor.index') }}">Clear Filters</a>
                                </div>
                            </div>
                            <div class="dropdown d-inline-block ml-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="exportDropdown">
                                    <a class="dropdown-item" href="#">CSV</a>
                                    <a class="dropdown-item" href="#">Excel</a>
                                    <a class="dropdown-item" href="#">PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Display Name</th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>GSTIN</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vendors as $vendor)
                                <tr>
                                    <td>{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}</td>
                                   <td>
                                            <a href="javascript:void(0);"
                                            class="viewVendor text-primary font-weight-bold"
                                            data-id="{{ $vendor->id }}"
                                            data-display="{{ $vendor->display_name }}"
                                            data-company="{{ $vendor->company_name ?? 'N/A' }}"
                                            data-gst="{{ $vendor->gst_no ?? 'N/A' }}"
                                            data-email="{{ $vendor->email ?? 'N/A' }}"
                                            data-phone="{{ $vendor->phone ?? 'N/A' }}"
                                            data-mobile="{{ $vendor->mobile ?? 'N/A' }}"
                                            data-address="{{ $vendor->address ?? 'N/A' }}"
                                            data-status="{{ $vendor->status }}"
                                            data-created="{{ $vendor->created_at }}">
                                            {{ $vendor->display_name }}
                                            </a>

                                            </td>

                                    <td>{{ $vendor->company_name ?? 'N/A' }}</td>
                                    <td>
                                        {{ $vendor->first_name }} {{ $vendor->last_name }},
                                        @if($vendor->email)
                                        <br><small class="text-muted">{{ $vendor->email }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $vendor->gst_no ?? 'N/A' }}</td>
                                    <td>
                                        @if($vendor->phone)
                                            {{ $vendor->phone }}
                                            @if($vendor->mobile)
                                            <br><small class="text-muted">M: {{ $vendor->mobile }}</small>
                                            @endif
                                        @else
                                            {{ $vendor->mobile ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $vendor->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($vendor->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('vendor.edit', $vendor->id) }}"
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                    title="Delete" data-toggle="modal"
                                                    data-target="#deleteModal{{ $vendor->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $vendor->id }}" tabindex="-1" role="dialog"
                                             aria-labelledby="deleteModalLabel{{ $vendor->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $vendor->id }}">
                                                            Confirm Delete
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete vendor <strong>{{ $vendor->display_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        {{-- <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No vendors found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    <!-- Vendor Details Modal -->
                    <div class="modal fade" id="vendorDetailsModal" tabindex="-1" role="dialog" aria-labelledby="vendorDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="vendorDetailsModalLabel">
                            <i class="fas fa-user"></i> Vendor Details
                            </h5>
                            </div>

                        <div class="modal-body">
                            <div id="vendorDetailsContent"><!-- Filled by script --></div>
                        </div>

                       <div class="modal-footer">
                            <a href="#" id="editVendorBtn" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-secondary close-model" data-dismiss="modal">
                                Close
                            </button>
                        </div>

                        </div>
                    </div>
                    </div>


               <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="text-muted">
                                Showing {{ $vendors->firstItem() }} to {{ $vendors->lastItem() }} of {{ $vendors->total() }} entries
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                {{ $vendors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS (needed for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
$(document).ready(function() {
    // Show vendor details modal
    $('.viewVendor').on('click', function() {
        let vendor = {
            id: $(this).data('id'),
            display: $(this).data('display'),
            company: $(this).data('company'),
            gst: $(this).data('gst'),
            email: $(this).data('email'),
            phone: $(this).data('phone'),
            mobile: $(this).data('mobile'),
            address: $(this).data('address'),
            status: $(this).data('status'),
            created: $(this).data('created')
        };

        let html = `
            <div class="row mb-2">
                <div class="col-md-6"><strong>Display Name:</strong> ${vendor.display}</div>
                <div class="col-md-6"><strong>Company:</strong> ${vendor.company}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>GSTIN:</strong> ${vendor.gst}</div>
                <div class="col-md-6"><strong>Email:</strong> ${vendor.email}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Phone:</strong> ${vendor.phone}</div>
                <div class="col-md-6"><strong>Mobile:</strong> ${vendor.mobile}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12"><strong>Address:</strong><br> ${vendor.address}</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Status:</strong> <span class="badge badge-${vendor.status === 'active' ? 'success' : 'secondary'}">${vendor.status}</span>
                </div>
                <div class="col-md-6"><strong>Created At:</strong> ${new Date(vendor.created).toLocaleDateString()}</div>
            </div>
        `;

        $('#vendorDetailsContent').html(html);
        $('#editVendorBtn').attr('href', "/vendor/" + vendor.id + "/edit");
        $('#vendorDetailsModal').modal('show');
    });

    // Close button click
    $('.close-model').on('click', function() {
        console.log("Close button clicked");
        $('#vendorDetailsModal').modal('hide'); // Close modal manually
    });
});

</script>
