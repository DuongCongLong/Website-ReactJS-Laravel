<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bảng điều khiển</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">

  <link rel="stylesheet" href="{{ asset('public/resources/css/app.css')}}">
  
  <style>
    .navbar { background-color: #090a0b; }
    .navbar a.nav-link { color: #ffffff; }
    .main-sidebar { background-color: #23272b; }
    .main-sidebar .nav-link { color: #c2c7d0; }
    .main-sidebar .nav-link.active { background-color: #007bff; color: #ffffff; }
    .main-sidebar .nav-header { color: #ffffff; }
    .content-wrapper { background-color: #f8f9fa; }
    .footer { background-color: #343a40; color: #ffffff; }
    .footer a { color: #ffffff; }
    .brand-link { background-color: #343a40; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard.index') }}" class="nav-link">Trang chủ</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        
     </li>
     <li class="nav-item">
       <a class="nav-link" data-widget="fullscreen" href="#" role="button">
         <i class="fas fa-expand-arrows-alt"></i>
       </a>
     </li>
     <!-- New Items -->
     
     <li class="nav-item dropdown">
      
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <a href="#" class="dropdown-item">
           <div class="media">
             <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
             <div class="media-body">
               <h3 class="dropdown-item-title">
                 John Doe
                 <span class="float-right text-sm text-muted"><i class="fas fa-clock"></i> 4 hrs</span>
               </h3>
               <p class="text-sm">New message</p>
             </div>
           </div>
         </a>
         <div class="dropdown-divider"></div>
         <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
       </div>
     </li>
     <li class="nav-item">
      <a class="nav-link" href="http://localhost:3000/"> 
        <i class="fas fa-arrow-left"></i>
        <span class="d-none d-md-inline">Quay về trang chủ</span>
    </a>
     </li>
     <li class="nav-item">
        <a class="nav-link" id="darkModeToggle" href="#" role="button">
          <i class="fas fa-moon"></i>
          <span class="d-none d-md-inline">Đổi chế độ</span>
        </a>
      </li>


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Quản trị viên</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/admin1.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block">Trang quản trị</a>
        </div>
      </div>
     <!-- Tìm kiếm trong Sidebar -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard Section -->
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Bảng điều khiển
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.index') }}" class="nav-link active">
                            <i class="fas fa-columns nav-icon"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Products Management -->
            <li class="nav-item {{ request()->is('admin/product*') || request()->is('admin/productreview*') || request()->is('admin/category*') || request()->is('admin/brand*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                  <i class="fas fa-gifts nav-icon"></i>
                  <p>
                      Quản lý Sản phẩm
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ route('admin.product.index') }}" class="nav-link {{ request()->routeIs('admin.product.index') ? 'active' : '' }}">
                         <i class="fas fa-box-open nav-icon"></i>
                         <p>Sản phẩm</p>
                     </a>
                  </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.category.index') }}" class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                            <i class="fas fa-tasks nav-icon"></i>
                            <p>Danh mục</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.brand.index') }}" class="nav-link {{ request()->is('admin/brand*') ? 'active' : '' }}">
                            <i class="fab fa-shopify nav-icon"></i>
                            <p>Thương Hiệu</p>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Marketing and Content -->
             <li class="nav-item {{ request()->is('admin/banner*') || request()->is('admin/post*') || request()->is('admin/topic*') || request()->is('admin/menu*') || request()->is('admin/promotion*') ? 'menu-open' : '' }}">
               <a href="#" class="nav-link">
                   <i class="fas fa-bullhorn nav-icon"></i>
                   <p>
                       Marketing và Nội dung
                       <i class="right fas fa-angle-left"></i>
                   </p>
               </a>
               <ul class="nav nav-treeview" style="{{ request()->is('admin/banner*') || request()->is('admin/post*') || request()->is('admin/topic*') || request()->is('admin/menu*') || request()->is('admin/promotion*') ? 'display: block;' : '' }}">
                   <li class="nav-item">
                       <a href="{{ route('admin.banner.index') }}" class="nav-link {{ request()->is('admin/banner*') ? 'active' : '' }}">
                           <i class="fas fa-image nav-icon"></i>
                           <p>Banner</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('admin.post.index') }}" class="nav-link {{ request()->is('admin/post*') ? 'active' : '' }}">
                           <i class="fas fa-file-alt nav-icon"></i>
                           <p>Bài viết</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('admin.menu.index') }}" class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                           <i class="fas fa-list nav-icon"></i>
                           <p>Menu</p>
                       </a>
                   </li>
                   <li class="nav-item">
                    <a href="{{ route('admin.contact.index') }}" class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                      <i class="fas fa-phone nav-icon"></i>

                        <p>Liên hệ</p>
                    </a>
                </li>
               </ul>
              </li>

            <!-- Transactions and Payments -->
            <li class="nav-item {{ request()->is('admin/transaction*') || request()->is('admin/payment*') || request()->is('admin/shipping*') || request()->is('admin/order*') || request()->is('admin/orderdetail*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                  <i class="fas fa-cash-register nav-icon"></i>
                  <p>
                      Giao dịch và Thanh toán
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview" style="{{ request()->is('admin/transaction*') || request()->is('admin/payment*') || request()->is('admin/shipping*') || request()->is('admin/order*') || request()->is('admin/orderdetail*') ? 'display: block;' : '' }}">
                  <li class="nav-item">
                      <a href="{{ route('admin.transaction.index') }}" class="nav-link {{ request()->is('admin/transaction*') ? 'active' : '' }}">
                          <i class="fas fa-exchange-alt nav-icon"></i>
                          <p>Thanh toán</p>
                      </a>
                  </li>
                  
                  <li class="nav-item">
                      <a href="{{ route('admin.shipping.index') }}" class="nav-link {{ request()->is('admin/shipping*') ? 'active' : '' }}">
                          <i class="fas fa-truck nav-icon"></i>
                          <p>Giao hàng</p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.order.index') }}" class="nav-link {{ request()->is('admin/order*') && !request()->is('admin/orderdetail*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart nav-icon"></i>
                        <p>Đơn hàng</p>
                    </a>
                  </li>
              </ul>
            </li>
            <li class="nav-item {{ request()->is('admin/user*') || request()->is('admin/usernew*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>
                      Quản lý Người dùng
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview" style="{{ request()->is('admin/user*') || request()->is('admin/usernew*') ? 'display: block;' : '' }}">
                  <li class="nav-item">
                      <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                          <i class="fas fa-users nav-icon"></i>
                          <p>Người dùng</p>
                      </a>
                  </li>
              </ul>
          </li>
          
          
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- CONTENT -->
    @yield('content')
    <!-- /.CONTENT -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Được hỗ trợ bởi &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jQuery Mapael -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', (event) => {
      const darkModeToggle = document.getElementById('darkModeToggle');
      const body = document.body;
  
      // Kiểm tra nếu chế độ Dark Mode đã được bật từ trước
      if (localStorage.getItem('darkMode') === 'enabled') {
          body.classList.add('dark-mode');
          darkModeToggle.classList.add('dark-mode');
      }
  
      darkModeToggle.addEventListener('click', () => {
          if (body.classList.contains('dark-mode')) {
              body.classList.remove('dark-mode');
              darkModeToggle.classList.remove('dark-mode');
              localStorage.setItem('darkMode', 'disabled');
          } else {
              body.classList.add('dark-mode');
              darkModeToggle.classList.add('dark-mode');
              localStorage.setItem('darkMode', 'enabled');
          }
      });
  });
  </script>
</body>
</html>
