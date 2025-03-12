@extends('layouts.admin')
@section('title','Đơn hàng')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết đơn hàng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
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
                    <a class="btn btn-sm btn-info" href="{{ route('admin.order.index')}}">
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
                        <td>{{ $order->order_id }}</td>
                    </tr>
                    <tr>
                        <td>Ngày đặt hàng</td>
                        <td>{{ $order->order_date }}</td>
                    </tr>
                    <tr>
                        <td>Tổng số đơn hàng</td>
                        <td>{{ $order->totalorder }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>Phương pháp vận chuyển</td>
                        <td>{{ $order->shipping_method }}</td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <td>Trạng thái giao hàng</td>
                        <td>{{ $order->shipping_status }}</td>
                    </tr>
                    <tr>
                        <td>Ngày tạo</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Người tạo</td>
                        <td>{{ $order->created_by }}</td>
                    </tr>
                    <tr>
                        <td>Ngày cập nhật</td>
                        <td>{{ $order->updated_at }}</td>
                    </tr>
                    <tr>
                        <td>Người cập nhật</td>
                        <td>{{ $order->updated_by }}</td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    <!-- Bảng chi tiết sản phẩm trong đơn hàng -->
                    <tr>
                        <td>Chi tiết sản phẩm</td>
                        <td>
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Mã sản phẩm</th>
                                        <th style="width: 20%;">Số lượng</th>
                                        <th style="width: 25%;">Giá</th>
                                        <th style="width: 25%;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($order->orderDetails->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Không có sản phẩm nào trong đơn hàng.</td>
                                        </tr>
                                    @else
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td>{{ $detail->product_id }}</td>
                                                <td>{{ $detail->amount }}</td>
                                                <td>{{ $detail->price }}</td>
                                                <td>{{ $detail->amount * $detail->price }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
