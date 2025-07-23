

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title', 'Default Title')</title>
<link rel="stylesheet" href="{{ asset('public/assets/css/admin.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

		    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

  <style>
    :root {
      --base-clr: #11121a;
      --line-clr: #42434a;
      --hover-clr: #222533;
      --text-clr: #e6e6ef;
      --accent-clr: #5e63ff;
      --secondary-text-clr: #b0b3c1;
    }

    * {
      margin: 0;
      padding: 0;
    }

    html {
      font-family: Poppins, "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.5rem;
    }

    body {
      min-height: 100vh;
      /* background-color: var(--base-clr);
      color: var(--text-clr); */
      display: grid;
      grid-template-columns: auto 1fr;
    }

    #sidebar {
      height: 100vh;
      width: 250px;
      padding: 5px 1em;
      background-color: var(--base-clr);
      border-right: 1px solid var(--line-clr);
      position: sticky;
      top: 0;
      align-self: start;
      transition: 300ms ease-in-out;
      overflow: hidden;
    }

    #sidebar.close {
      padding: 5px;
      width: 60px;
    }

    #sidebar.close ul a span,
    #sidebar.close .dropdown-btn span {
      display: none;
    }

    #sidebar ul {
      list-style: none;
      padding-left: 0;
    }

    #sidebar > ul > li:first-child {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 16px;
    }

    #sidebar ul li.active a {
      color: var(--accent-clr);
      svg {
        fill: var(--accent-clr);
      }
    }

    #sidebar a,
    #sidebar .dropdown-btn,
    #sidebar .logo {
      border-radius: 0.5em;
      padding: 0.85em;
      text-decoration: none;
      color: var(--text-clr);
      display: flex;
      align-items: center;
      gap: 1em;
    }

    .dropdown-btn {
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      font: inherit;
      cursor: pointer;
    }

    #sidebar svg {
      flex-shrink: 0;
      fill: var(--text-clr);
    }

    #sidebar a span,
    #sidebar .dropdown-btn span {
      flex-grow: 1;
    }

    #sidebar a:hover,
    #sidebar .dropdown-btn:hover {
      background-color: var(--hover-clr);
    }

    #sidebar .sub-menu {
      display: none;
      grid-template-rows: 0fr;
      transition: 300ms ease-in-out;
    }

    #sidebar .sub-menu.show {
      display: block;
    }

    #sidebar .sub-menu a {
      padding-left: 2em;
      display: flex;
      gap: 1em;
      align-items: center;
    }

    #sidebar .sub-menu i {
      flex-shrink: 0;
    }

    #toggle-btn {
      margin-left: auto;
      padding: 1em;
      border: none;
      border-radius: 0.5em;
      background: none;
      cursor: pointer;
      svg {
        transition: rotate 150ms ease;
      }
    }

    #toggle-btn:hover {
      background-color: var(--hover-clr);
    }

    main {
      padding: 0px;
    }

    .container {
      /*border: 1px solid var(--line-clr);*/
      /*border-radius: 1em;*/
      margin-bottom: 20px;
      padding: 2em;
    }

    @media (max-width: 800px) {
      body {
        grid-template-columns: 1fr;
      }

      main {
        padding: 2em 1em;
      }

      #sidebar {
        height: 60px;
        width: 100%;
        border-right: none;
        border-top: 1px solid var(--line-clr);
        padding: 0;
        position: fixed;
        top: unset;
        bottom: 0;
        > ul {
          display: grid;
          grid-auto-columns: 60px;
          grid-auto-flow: column;
          align-items: center;
          overflow-x: auto;
        }

        ul li {
          height: 100%;
        }

        ul a,
        ul .dropdown-btn {
          width: 60px;
          height: 60px;
          padding: 0;
          border-radius: 0;
          justify-content: center;
        }

        ul li span,
        ul li:first-child {
          display: none;
        }

        ul li .sub-menu.show {
          position: fixed;
          bottom: 60px;
          left: 0;
          box-sizing: border-box;
          height: 60px;
          width: 100%;
          background-color: var(--hover-clr);
          border-top: 1px solid var(--line-clr);
          display: flex;
          justify-content: center;
        }
      }
    }
  </style>
</head>
<body>
  <nav id="sidebar">
<ul>
  <li>
    <span class="logo">Sidebar Menu</span>
    <button onclick="toggleSidebar()" id="toggle-btn">
      <i class="fas fa-bars" style="color: white;"></i>
    </button>
  </li>



  <li>
    <a href="/admin/dashboard">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li>
    <button onclick="toggleSubMenu(this)" class="dropdown-btn">
      <i class="fas fa-box"></i>
      <span>Orders</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <ul class="sub-menu">
      <li>
        <a href="/admin/pending_orders">
          <i class="fas fa-hourglass-half"></i> Pending Orders
        </a>
      </li>
      <li>
        <a href="/admin/completed_orders">
          <i class="fas fa-check-circle"></i> Completed Orders
        </a>
      </li>
      <li>
        <a href="/admin/canceled_orders">
          <i class="fas fa-times-circle"></i> Cancelled Orders
        </a>
      </li>
    </ul>
  </li>

  <li>
    <button onclick="toggleSubMenu(this)" class="dropdown-btn">
      <i class="fas fa-tags"></i>
      <span>Products</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <ul class="sub-menu">
      <li>
        <a href="/admin/add-product">
          <i class="fas fa-plus-square"></i> Add Product
        </a>
      </li>
      <li>
        <a href="/admin/manage-products">
          <i class="fas fa-edit"></i> Manage Products
        </a>
      </li>
      <li>
        <a href="/admin/gift-product">
          <i class="fas fa-gift"></i> Add Gift Products
        </a>
      </li>
      <li>
        <a href="/admin/manage-gift-product">
          <i class="fas fa-tasks"></i> Manage Gift Products
        </a>
      </li>
    </ul>
  </li>

  <li>
    <button onclick="toggleSubMenu(this)" class="dropdown-btn">
      <i class="fas fa-th-large"></i>
      <span>Categories</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <ul class="sub-menu">
      <li>
        <a href="/admin/categories">
          <i class="fas fa-plus-square"></i> Add Categories
        </a>
      </li>
      <li>
        <a href="/admin/manage-categories">
          <i class="fas fa-cogs"></i> Manage Categories
        </a>
      </li>
    </ul>
  </li>
  <!-- Add banner links-->
  <li>
    <button onclick="toggleSubMenu(this)" class="dropdown-btn">
      <i class="fas fa-bullhorn"></i>
      <span>Banners</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <ul class="sub-menu">
      <li>
        <a href="{{route('banners.create')}}">
          <i class="fas fa-plus-square"></i> Add Banners
        </a>
      </li>
      <li>
        <a href="{{route('banners.index')}}">
          <i class="fas fa-cogs"></i> Manage Banners
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a href="{{ route('limited-banners.index') }}" class="nav-link">
        <i class="fas fa-fire text-danger"></i> <!-- Icon -->
        <span class="ms-2">Limited Edition</span>
    </a>
</li>

  <li>
    <a href="/admin/registered-users">
      <i class="fas fa-users"></i>
      <span>Users</span>
    </a>
  </li>
  <li>
    <a href="{{route('admin.inquiries.index')}}">
      <i class="fas fa-users"></i>
      <span>Users Inquiry</span>
    </a>
  </li>

  <li>
    <a href="#">
      <i class="fas fa-user-circle"></i>
      <span>Profile</span>
    </a>
  </li>
  
    <li>
    <a href="#">
  <form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit" class="dropdown-item">
        <i class="fas fa-sign-out-alt me-2"></i> Logout
    </button>
        </a>
  </li>
</form>
</ul>
  </nav>

 
    <main id="admin_main">
        @yield('content')
    </main>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      sidebar.classList.toggle("close");
    }

    function toggleSubMenu(button) {
      const submenu = button.nextElementSibling;
      submenu.classList.toggle("show");
      button.querySelector('i:last-child').classList.toggle("fa-chevron-up");
    }
  </script>
</body>
</html>