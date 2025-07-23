@extends('layouts.main')
@section('title', 'Thank You')
@section('content')

<div style="text-align: center; padding: 50px; background: #f9f9f9; border-radius: 10px; max-width: 600px; margin: 50px auto;">
    <div style="font-size: 80px; color: #4CAF50;">✓</div>
    <h1>Thank You!</h1>
    <p>Your order has been placed successfully</p>
    
    @if(isset($orderId))
        <div style="margin: 30px 0; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3>Order Details</h3>
            <p><strong>Order ID:</strong> {{ $orderId }}</p>
            <p><strong>Status:</strong> Payment Completed</p>
        </div>
    @endif
    
    <p>You will receive an order confirmation email shortly</p>
    
    <div style="margin-top: 30px;">
        <a href="/" class="btn" style="background: #F37254; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Continue Shopping
        </a>
    </div>
</div>

@endsection