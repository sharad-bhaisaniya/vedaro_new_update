@extends('layouts.admin_lay')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Brand Master</h4>
        <a href="{{ route('brands.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Brand Name</th><th>Description</th><th width="180">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->description }}</td>
                    <td>
                        <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this brand?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No Brands Found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $brands->links() }}
</div>
@endsection
