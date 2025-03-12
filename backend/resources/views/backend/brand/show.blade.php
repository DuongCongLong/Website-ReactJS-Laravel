@extends('layouts.admin')
@section('title','Thương hiệu')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết thương hiệu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Chi tiết thương hiệu</li>
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
                    <a href="{{ route('admin.brand.edit', ['id' => $brand->id]) }}" class="btn btn-sm btn-primary">
                        <i class="far fa-edit"></i> Sửa
                    </a>
                    <form action="{{ route('admin.brand.destroy', ['id' => $brand->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này không?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.brand.index') }}">
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
                        <td>{{ $brand->id }}</td>
                    </tr>
                    <tr>
                        <td>Hình ảnh</td>
                        <td><img style="width:20%" src="{{ asset('images/brands/'.$brand->image) }}" alt="{{ $brand->name }}" style="max-width: 100%; height: auto;"></td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td>{{ $brand->name }}</td>
                    </tr>
                    <tr>
                        <td>Chi tiết danh mục</td>
                        <td>{!! $brand->description !!}</td>
                    </tr>
                    <tr>
                        <td>Slug</td>
                        <td>{{ $brand->slug }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $brand->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $brand->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Created_by</td>
                        <td>{{ $brand->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
