@extends('layouts.main')

@section('title', 'About Us')

@section('content')
<div class="sect_head">
			<h3>Cart</h3>
		</div>
		<div class="cart-page">
			<div class="cart-container">
				<table class="cart-table">
					<thead>
						<tr>
							<th>Product</th>
							<th>Unit price</th>
							<th>Stock status</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="product-info">
								<img src="../assets/images/1.png" class="img-fluid" alt="Product 1">
								<p>Lio Fairness Cream</p>
							</td>
							<td class="price"><span class="main_price">₹28.00</span>₹18.00</td>
							<td class="quantity">
								<p class="in_stock">In Stock</p>
							</td>
							<td class="subtotal">
                                <p style="font-size: 12px;">Added on: December 30, 2024 </p>
                            <div>
                                <button class="update-cart">Add to Cart</button>
                                <button class="update-cart">Remove</button>
                            </div>
                            </td>
							<td class="remove"><i class="fas fa-times"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
@endsection
