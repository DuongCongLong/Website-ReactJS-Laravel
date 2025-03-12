@extends('layouts.admin')
@section('title', 'Giao dịch và thanh toán')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>QUẢN LÍ PHƯƠNG THỨC THANH TOÁN</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quản lí giao dịch</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('admin.transaction.index') }}" method="GET" class="form-inline d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-wrap">
                                <input type="text" name="order_id" class="form-control mb-2 mr-2" placeholder="Tên giao dịch" value="{{ request()->order_id }}" style="max-width: 150px;">
                                <input type="text" name="amount" class="form-control mb-2 mr-2" placeholder="Giá tiền" value="{{ request()->amount }}" style="max-width: 150px;">
                                <select name="payment_method" class="form-control mb-2 mr-2" style="max-width: 150px;">
                                    <option value="">Phương thức thanh toán</option>
                                    <option value="credit_card" {{ request()->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="paypal" {{ request()->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <!-- Add other payment methods as needed -->
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary mb-2">Tìm kiếm</button>
                            </div>
                            <div class="d-flex">
                                <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.transaction.create') }}">
                                    <i class="fas fa-plus"></i> Thêm giao dịch
                                </a>
                                <a class="btn btn-sm btn-danger" href="{{ route('admin.transaction.trash') }}">
                                    <i class="fas fa-trash-alt"></i> Thùng rác
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:30px">#</th>
                            <th>Mã giao dịch</th>
                            <th>Giá tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th class="text-center" style="width:200px">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($list->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning" role="alert">
                                        Không tìm thấy giao dịch nào phù hợp với tiêu chí lọc.
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($list as $row)
                                @php
                                    $args = ['transaction_id' => $row->transaction_id];
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" id="checkId" value="{{ $row->transaction_id }}" name="checkId[]">
                                    </td>
                                    <td>{{ $row->order_id }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ $row->payment_method }}</td>
                                    <td class="text-center" style="width:220px">
                                        @if ($row->status == 1)
                                        <a href="{{ route('admin.transaction.status', $args ) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-toggle-on"></i>
                                        </a>
                                        @else
                                        <a href="{{ route('admin.transaction.status', $args ) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-toggle-off"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('admin.transaction.show', $args ) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.transaction.edit', $args ) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.transaction.delete', $args ) }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $list->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
