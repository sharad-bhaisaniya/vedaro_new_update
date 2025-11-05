@extends('layouts.admin_lay')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>HSN Codes</h4>
        <a href="{{ route('hsn.create') }}" class="btn btn-primary">Add HSN</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Code</th><th>Description</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach($hsnCodes as $hsn)
                <tr>
                    <td>{{ $hsn->id }}</td>
                    <td>{{ $hsn->code }}</td>
                    <td>{{ $hsn->description }}</td>
                    <td>
                        <a href="{{ route('hsn.edit', $hsn) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('hsn.destroy', $hsn) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this item?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $hsnCodes->links() }}
</div>
@endsection
