@extends('layouts.admin_lay')

@section('content')
<style>
    .badge {
        font-size: 0.85em;
    }
    .card-header {
        font-weight: bold;
    }
    .table th {
        background-color: #f8f9fa;
    }
</style>

<div class="container">
    <h1>Taxes</h1>
    <div class="d-flex justify-content-between">
      <a href="{{ route('taxes.create') }}" class="btn btn-primary mb-3">Add New Tax</a>
      <a href="javascript:void(0)" class="btn btn-primary mb-3 group-taxes">Create Group</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">All Taxes</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Tax Group</th>
                        <th>Rate (%)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taxes as $tax)
                        <tr>
                            <td>{{ $tax->name }}</td>
                            {{-- Display the tax groups for a single tax --}}
                            <td>
                                @foreach($tax->groups as $group)
                                    <span class="badge bg-info text-dark">{{ $group->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $tax->rate }}</td>
                            <td>
                                <span class="badge {{ $tax->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $tax->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            {{-- <td>
                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                <form action="" class="d-inline"
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td> --}}
                            <td>
    <a href="{{ route('taxes.edit', $tax->id) }}" class="btn btn-sm btn-warning">Edit</a>

    <form action="{{ route('taxes.destroy', $tax->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">All Tax Groups</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Taxes in this Group</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tax_groups as $tax_group)
                        <tr>
                            <td>{{ $tax_group->name }}</td>
                            <td>
                                @if($tax_group->taxes->isNotEmpty())
                                    @foreach ($tax_group->taxes as $tax)
                                        <span class="badge bg-secondary mb-1">{{ $tax->name }} ({{ $tax->rate }}%)</span><br>
                                    @endforeach
                                @else
                                    <span class="text-muted">No taxes in this group</span>
                                @endif
                            </td>
                            <td>
                                <form action="" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="taxGroupModal" tabindex="-1" aria-labelledby="taxGroupModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="taxGroupModalLabel">Create Tax Group</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="taxGroupForm" method="POST" action="{{ route('taxgroup.store') }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="group_name" class="form-label">Group Name</label>
                <input type="text" name="group_name" id="group_name" class="form-control" required>
              </div>

              <h6>Select Taxes:</h6>
              <div id="taxList" class="border p-3" style="max-height: 300px; overflow-y: auto;">
                @foreach($taxes as $tax)
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="taxes[]" value="{{ $tax->id }}" id="tax{{ $tax->id }}">
                    <label class="form-check-label" for="tax{{ $tax->id }}">
                      {{ $tax->name }} ({{ $tax->rate }}%)
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Group</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
    // Show modal on button click
    document.querySelector(".group-taxes").addEventListener("click", function(e) {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('taxGroupModal'));
        myModal.show();
    });
</script>

@endsection
