@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .container {
        width: 100% !important;
    }
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
    }
    .table {
    min-width: 100%;
}

</style>

<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">

    <h2 class="mt-4">Manage Categories</h2>

    <!--@if(session('success'))-->
    <!--    <div class="alert alert-success">-->
    <!--        {{ session('success') }}-->
    <!--    </div>-->
    <!--        @endif-->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('public/storage/products/' . $category->image) }}" alt="{{ $category->name }}" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.edit_category', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.delete_category', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    
                        <form action="{{ route('admin.toggle_category', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-secondary' : 'btn-success' }}">
                                {{ $category->active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>

@endsection
