<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Processing Payment...</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h3 class="process">Processing Payment<span class="dots"></span> Please wait.</h3>

<!-- Payment form -->
<form id="payuForm" action="{{ $action }}" method="POST">
    @csrf
    <input type="hidden" name="hash" value="{{ $hash }}">
    <input type="hidden" name="key" value="{{ $MERCHANT_KEY }}">
    <input type="hidden" name="txnid" value="{{ $txnid }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    <input type="hidden" name="firstname" value="{{ $name }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="phone" value="{{ $phone }}">
    <input type="hidden" name="productinfo" value="Webappfix">
    <input type="hidden" name="surl" value="{{ $successURL }}">
    <input type="hidden" name="furl" value="{{ $failURL }}">
    <input type="hidden" name="service_provider" value="payu_paisa">

    <!-- Hidden submit button -->
    <button type="submit" id="payNowButton" style="display:none;">Pay Now</button>
</form>

<script>
    window.onload = function() {
        document.getElementById('payuForm').submit();
    };
</script>
<style>
.process {
    font-size: 20px;
    font-weight: bold;
        display: flex;
    justify-content: center;
    align-items: center;
    color: forestgreen;
    height: 100vh;
}
.dots{
    margin-right: 20px;
}
.dots::after {
    content: "";
    display: inline-block;
    width: 0;
    height: 0;
    background-color: #333;
    border-radius: 50%;
    animation: dot-blink 1.5s steps(3, end) infinite;
}

@keyframes dot-blink {
    0% {
        content: ".";
    }
    33% {
        content: "..";
    }
    66% {
        content: "...";
    }
    100% {
        content: ".";
    }
}

</style>
</body>
</html>
