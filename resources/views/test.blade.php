<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Custom Product Layout</title>
		<link rel="stylesheet" href="../assets/css/style.css">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	</head>
	<body>
		<?php require "../resources/views/includes/header.php"; ?>
		<!-- <div class="sect_head">
			<h3>Cart</h3>
		</div> -->

        <div class="user_register_form">
        @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('test') }}" method="post">
        @csrf
        <div class="input-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="submit-btn">
            <button type="submit">Submit</button>
        </div>
    </form>
        </div>
		<?php require "../resources/views/includes/footer.php"; ?>
		<script src="../assets/css/script.js"></script>
	</body>
</html>