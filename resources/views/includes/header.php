<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="layouts/assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>
 <header class="py-3 border-bottom bg-white fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <!-- Logo -->
    <a href="/" class="navbar-brand fs-2 fw-light text-uppercase tracking-wide text-dark">VEDARO</a>

    <!-- Navigation -->
    <nav class="d-none d-md-flex gap-4">
      <a class="nav-link text-dark text-uppercase" href="/index.html">Home</a>
      <a class="nav-link text-dark text-uppercase" href="/pages/about.html">About</a>
      <a class="nav-link text-dark text-uppercase" href="/category.html">Necklaces</a>
    </nav>

    <!-- Icons -->
    <div class="d-flex align-items-center gap-3">
      <!-- Login -->
      <a href="/login.html" class="text-dark">
        <i class="fas fa-user"></i>
      </a>

      <!-- Search -->
      <form class="d-none d-md-flex" role="search">
        <input class="form-control form-control-sm me-2" type="search" placeholder="Search..." aria-label="Search">
        <button class="btn btn-outline-secondary btn-sm" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>

      <!-- Cart -->
      <a href="/cart" class="position-relative text-dark">
        <i class="fas fa-shopping-cart"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          0
        </span>
      </a>
    </div>
  </div>
</header>

</body>

</html>
