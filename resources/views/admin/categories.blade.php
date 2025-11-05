@extends('layouts.admin_lay')
@section('title', 'Dashboard')
@section('content')

<style>
    .container {
        width: 100% !important;
    }
 
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1800px;
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

                    {{-- Your existing Category Image field --}}
                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    {{-- NEW: Category Icon field --}}
                    <div class="form-group">
                        <label for="icon">Category Icon</label>
                        <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                    </div>

                    {{-- NEW: Category Banner Image field --}}
                    <div class="form-group">
                        <label for="banner_image">Category Banner Image</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*">
                    </div>

                    <div class="form-group form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="showOnHome" name="showOnHome" value="1">
                        <label class="form-check-label" for="showOnHome">Show on Home</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                    </div>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
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