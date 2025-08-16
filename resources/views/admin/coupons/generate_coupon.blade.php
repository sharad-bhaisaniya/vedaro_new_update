@extends('layouts.admin_lay')
@section('title', 'Generate Coupon')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Generate New Coupon</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf

                {{-- Coupon Code --}}
                <div class="mb-3">
                    <label for="code" class="form-label">Coupon Code</label>
                    <div class="input-group">
                        <input type="text" name="code" id="code" class="form-control" placeholder="E.g., COUPON2025" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="generateCouponCode()">Generate Code</button>
                    </div>
                </div>

                {{-- Discount Percentage --}}
                <div class="mb-3">
                    <label for="discount_percentage" class="form-label">Discount Percentage (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" placeholder="E.g., 15" min="0" max="100" required>
                </div>

                {{-- Universal Checkbox --}}
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="is_universal" id="is_universal" value="1" onchange="handleUniversalToggle()">
                    <label class="form-check-label" for="is_universal">Is Universal (applies to all products)</label>
                </div>

                {{-- Category Field --}}
                <div class="mb-3" id="categoryField">
                    <label for="category_id" class="form-label">Select Category</label>
                    <select name="category_id" id="category_id" class="form-select" onchange="handleCategorySelection()">
                        <option value="">-- None --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Product Field (Multiple Select) --}}
                <div class="mb-3" id="productField">
                    <label for="product_ids" class="form-label">Select Products (if no category selected)</label>
                    <select name="product_ids[]" id="product_ids" class="form-select" multiple>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->productName }}</option>
                    @endforeach
                </select>

                    <small class="text-muted">Hold Ctrl/Cmd to select multiple.</small>
                </div>


                {{-- Validity Dates --}}
                <div class="mb-3">
    <label for="valid_from" class="form-label">Valid From</label>
    <input type="datetime-local" name="valid_from" id="valid_from" class="form-control">
</div>

<div class="mb-3">
    <label for="valid_to" class="form-label">Valid To</label>
    <input type="datetime-local" name="valid_to" id="valid_to" class="form-control">
</div>

                <button type="submit" class="btn btn-success">Save Coupon</button>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    function generateCouponCode() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let coupon = 'COUPON-';
        for (let i = 0; i < 6; i++) {
            coupon += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        document.getElementById('code').value = coupon;
    }

    function handleUniversalToggle() {
        const isUniversal = document.getElementById('is_universal').checked;
        document.getElementById('categoryField').style.display = isUniversal ? 'none' : 'block';
        document.getElementById('productField').style.display = isUniversal ? 'none' : 'block';

        if (isUniversal) {
            document.getElementById('category_id').value = '';
            const productSelect = document.getElementById('product_ids');
            for (let option of productSelect.options) {
                option.selected = false;
            }
        }
    }

    function handleCategorySelection() {
        const categorySelected = document.getElementById('category_id').value !== '';
        document.getElementById('productField').style.display = categorySelected ? 'none' : 'block';

        if (categorySelected) {
            const productSelect = document.getElementById('product_ids');
            for (let option of productSelect.options) {
                option.selected = false;
            }
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', () => {
        handleUniversalToggle();
        handleCategorySelection();
    });
</script>
@endsection
