@extends('layouts.admin')
@section('title', 'Quản lý menu')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quản lý menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 text-right">
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.menu.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:30%;">
                                <strong>Tên trường</strong>
                            </th>
                            <th class="text-center" style="width:70%;">Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ID</td>
                            <td>{{ $menu->id }}</td>
                        </tr>
                        <tr>
                            <td>Tên menu</td>
                            <td>{{ $menu->name }}</td>
                        </tr>
                        <tr>
                            <td>Liên kết</td>
                            <td>{{ $menu->link }}</td>
                        </tr>
                        <tr>
                            <td>Ngày tạo</td>
                            <td>{{ $menu->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ngày cập nhật</td>
                            <td>{{ $menu->updated_at }}</td>
                        </tr>
                        <tr>
                            <td>Trạng thái</td>
                            <td>{{ $menu->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
