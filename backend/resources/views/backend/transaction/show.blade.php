@extends('layouts.admin')
@section('title','Thanh toán')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết phương thức thanh toán</h1>
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
                    <a href="{{ route('admin.transaction.edit', $transaction->transaction_id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <form action="{{ route('admin.transaction.destroy', $transaction->transaction_id) }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.transaction.index')}}">
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
                        <td>{{ $transaction->transaction_id }}</td>
                    </tr>
                   
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>{{ $transaction->payment_method }}</td>
                    </tr>
                    <tr>
                        <td>Số lượng </td>
                        <td>{{ $transaction->amount }}</td>
                    </tr>
                    <tr>
                        <td>Order_id</td>
                        <td>{{ $transaction->order_id }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $transaction->status }}</td>
                    </tr>
                    <tr>
                        <td>Created_at</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Created_by</td>
                        <td>{{ $transaction->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection