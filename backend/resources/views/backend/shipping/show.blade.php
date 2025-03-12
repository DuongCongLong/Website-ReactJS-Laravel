@extends('layouts.admin')
@section('title','Giao hàng')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết giao hàng</h1>
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
                    <a href="{{ route('admin.shipping.edit', $shipping->shipping_id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <form action="{{ route('admin.shipping.destroy', $shipping->shipping_id) }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                    
                    <a class="btn btn-sm btn-info" href="{{ route('admin.shipping.index')}}">
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
                        <td>{{ $shipping->shipping_id }}</td>
                    </tr>
                    <tr>
                        <td>Đơn hàng</td>
                        <td>{{ $shipping->order_id }}</td>
                    </tr>
                    <tr>
                        <td>Phương thức vận chuyển</td>
                        <td>{{ $shipping->shipping_method }}</td>
                    </tr>
                    <tr>
                        <td>Giá</td>
                        <td>{{ $shipping->cost }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $shipping->status }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $shipping->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Created_by</td>
                        <td>{{ $shipping->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection