@extends('layouts.admin')
@section('title','Banner')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết banner</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
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
                           <!-- Nút Sửa -->
                        <a href="{{ route('admin.banner.edit', ['banner_id' => $banner->banner_id]) }}" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i> Sửa
                        </a>

                        <!-- Nút Xóa -->
                        <a href="{{ route('admin.banner.delete', ['banner_id' => $banner->banner_id]) }}" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.banner.index') }}">
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
                        <td>Id</td>
                        <td>{{ $banner->banner_id }}</td>
                    </tr>
                    <tr>
                        <td>Hình ảnh</td>
                        <td><img style="width:20%" src="{{ asset('images/banners/'.$banner->image) }}" alt="{{ $banner->name }}" style="max-width: 100%; height: auto;"></td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td>{{ $banner->name }}</td>
                    </tr>
                   
                    <tr>
                        <td>Mô tả</td>
                        <td>{!! $banner->description !!}</td>
                    </tr>
                    <tr>
                        <td>Position </td>
                        <td>{{ $banner->position }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $banner->status }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $banner->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </section>
@endsection