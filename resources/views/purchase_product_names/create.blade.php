@extends('layouts.admin_lay')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Add New Product Name</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchase-product-names.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required value="{{ old('name') }}">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('purchase-product-names.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
