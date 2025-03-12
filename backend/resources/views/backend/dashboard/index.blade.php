@extends('layouts.admin')
@section('title', 'Bảng điều khiển')
@section('content')
    <section class="content" style="padding-left: 0;">
        <div class="container-fluid" style="padding-left: 0;">
            <div class="content-wrapper" style="margin-left: 0;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Bảng điều khiển</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Bảng điều khiển</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <div class="content">
                    <!-- Các nút nằm ngang -->
                    <div class="d-flex justify-content-start flex-wrap mb-4">
                        <a href="{{ route('admin.product.index') }}" class="btn btn-primary m-2">
                            <i class="fas fa-box-open nav-icon"></i> Sản phẩm
                        </a>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-primary m-2">
                            <i class="fas fa-tasks nav-icon"></i> Danh mục
                        </a>
                        <a href="{{ route('admin.brand.index') }}" class="btn btn-primary m-2">
                            <i class="fab fa-shopify nav-icon"></i> Thương Hiệu
                        </a>
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-primary m-2 {{ request()->is('admin/banner*') ? 'active' : '' }}">
                            <i class="fas fa-image nav-icon"></i> Banner
                        </a>
                        <a href="{{ route('admin.post.index') }}" class="btn btn-primary m-2 {{ request()->is('admin/post*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt nav-icon"></i> Bài viết
                        </a>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-primary m-2 {{ request()->is('admin/menu*') ? 'active' : '' }}">
                            <i class="fas fa-list nav-icon"></i> Menu
                        </a>
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-primary m-2 {{ request()->is('admin/contact*') ? 'active' : '' }}">
                            <i class="fas fa-phone nav-icon"></i> Liên hệ
                        </a>
                    </div>
                </div>
                <!-- Main content -->
            </div>
        </div>
    </section>
    <style>
        /* Style cho các nút */

/* Khi nút đang ở trạng thái active */
.d-flex a.active {
    background-color: #28a745;
    color: #fff;
}

/* Nút đặc biệt */
.special-btn {
    background-color: #dc3545; /* Màu đỏ */
    color: #fff;
}

/* Khi hover nút đặc biệt */
.special-btn:hover {
    background-color: #c82333; /* Màu đỏ đậm */
    transform: translateY(-2px);
}

/* Icon cho các nút */
.nav-icon {
    margin-right: 10px;
}

    </style>
@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mapael@2.2.0/jquery.mapael.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mapael@2.2.0/maps/world_countries.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
