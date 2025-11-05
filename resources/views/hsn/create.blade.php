@extends('layouts.admin_lay')

@section('content')
<div class="container mt-4">
    <h4>Add HSN Code</h4>
    <form action="{{ route('hsn.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>HSN Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
