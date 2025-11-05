@extends('layouts.admin_lay')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Product Name</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchase-product-names.update', $purchaseProductName->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $purchaseProductName->name) }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('purchase-product-names.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
