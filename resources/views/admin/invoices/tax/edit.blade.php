@extends('layouts.admin_lay')

@section('content')
<form method="POST" action="{{ route('taxes.update', $tax->id) }}" class="px-4 py-3">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="name">Tax Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tax->name) }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="rate">Rate (%)</label>
        <input type="number" step="0.01" name="rate" id="rate" class="form-control" value="{{ old('rate', $tax->rate) }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="tax_group">Tax Group</label>
        <select name="tax_group" id="tax_group" class="form-control">
            <option value="" {{ $tax->tax_group == '' ? 'selected' : '' }}>Select</option>
            <option value="CGST" {{ $tax->tax_group == 'CGST' ? 'selected' : '' }}>CGST</option>
            <option value="SGST" {{ $tax->tax_group == 'SGST' ? 'selected' : '' }}>SGST</option>
            <option value="IGST" {{ $tax->tax_group == 'IGST' ? 'selected' : '' }}>IGST</option>
            <option value="UTGST" {{ $tax->tax_group == 'UTGST' ? 'selected' : '' }}>UTGST</option>
            <option value="Cess" {{ $tax->tax_group == 'Cess' ? 'selected' : '' }}>Cess</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Tax</button>
    <a href="{{ route('taxes.index') }}" class="btn btn-secondary">Cancel</a>
</form>


@endsection
