@extends('layouts.admin')
@section('title','Danh mục')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết danh mục</h1>
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
                    <a href="{{ route('admin.category.edit', ['id' => $category->id] ) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit">Sửa</i>
                    </a>
                    <a href="{{ route('admin.category.delete', ['id' => $category->id] ) }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash">Xóa</i>
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.category.index')}}">
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
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <td>Hình ảnh</td>
                        <td><img style="width:20%" src="{{ asset('images/categorys/'.$category->image) }}" alt="{{ $category->name }}" style="max-width: 100%; height: auto;"></td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td>{{ $category->name }}</td>
                    </tr>
                   
                    <tr>
                        <td>Chi tiết danh mục</td>
                        <td>{!! $category->description !!}</td>
                    </tr>
                    <tr>
                        <td>Slug </td>
                        <td>{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <td>Parent_id</td>
                        <td>{{ $category->parent_id }}</td>
                    </tr>
                    <tr>
                        <td>Sort_order</td>
                        <td>{{ $category->sort_order }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $category->status }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $category->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Created_by</td>
                        <td>{{ $category->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection