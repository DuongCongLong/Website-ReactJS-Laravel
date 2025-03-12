@extends('layouts.admin')

@section('title', 'Đơn hàng')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>QUẢN LÍ ĐƠN HÀNG</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quản lí đơn hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <!-- Form tìm kiếm -->
                <form method="GET" action="{{ route('admin.order.index') }}" class="form-inline d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-wrap">
                        <input type="text" name="date_range" class="form-control mb-2 mr-2" placeholder="Ngày đặt" value="{{ request()->input('date_range') }}" style="max-width: 150px;">
                        <input type="text" name="order_id" class="form-control mb-2 mr-2" placeholder="ID Đơn" value="{{ request()->input('order_id') }}" style="max-width: 150px;">
                        <input type="number" name="quantity" class="form-control mb-2 mr-2" placeholder="Số lượng" value="{{ request()->input('quantity') }}" style="max-width: 150px;">
                        <input type="text" name="address" class="form-control mb-2 mr-2" placeholder="Địa chỉ" value="{{ request()->input('address') }}" style="max-width: 150px;">
                        <input type="text" name="shipping_method" class="form-control mb-2 mr-2" placeholder="Vận chuyển" value="{{ request()->input('shipping_method') }}" style="max-width: 150px;">
                        <input type="text" name="payment_method" class="form-control mb-2 mr-2" placeholder="Thanh toán" value="{{ request()->input('payment_method') }}" style="max-width: 150px;">
                        <input type="text" name="shipping_status" class="form-control mb-2 mr-2" placeholder="Giao hàng" value="{{ request()->input('shipping_status') }}" style="max-width: 150px;">
                        <button type="submit" class="btn btn-sm btn-primary mb-2">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <!-- Hiển thị tổng cộng ở trên -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-success">
                            <strong>Số lượng đơn hàng theo trạng thái:</strong><br>
                            @foreach ($statusCounts as $status => $count)
                                {{ $status }}: {{ $count }}<br>
                            @endforeach
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">ID</th>
                            <th style="white-space: nowrap;">Số lượng</th>
                            <th style="width:200px">Địa chỉ</th>
                            <th style="white-space: nowrap;">Phương pháp vận chuyển</th>
                            <th style="white-space: nowrap;">Phương thức thanh toán</th>
                            <th style="white-space: nowrap;">Trạng thái giao hàng</th>
                            <th class="text-center" style="width:350px">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>
                                    {{ $order->totalorder }}
                                </td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->shipping_method }}</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>{{ $order->shipping_status }}</td>
                                <td class="text-center" style="width:290px">
                                    <a href="{{ route('admin.order.show', ['order_id' => $order->order_id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $list->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
