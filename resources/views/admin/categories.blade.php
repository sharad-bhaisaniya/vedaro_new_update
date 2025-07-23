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
        min-width: 1800px; /* Adjust to match your table's content */
    }

</style>

<div class="container mt-1">
    <div class="row justify-content-end">
        <div class="col-lg-12 col-md-10 col-sm-12">
        <h2 class="text-center mb-4">Add Category</h2>
            <div class="form-container">
            <form action="{{ route('admin.categories') }}" method="POST" enctype="multipart/form-data" id="addCategoryForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category description (optional)"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Category Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


            </div>
        </div>
    </div>
</div>

@endsection
