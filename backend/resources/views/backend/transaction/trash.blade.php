@extends('layouts.admin')
@section('title', 'Thùng rác phương thức thanh toán')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thùng rác phương thức tahnh toán</h1>
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
                        <a class="btn btn-sm btn-info" href="{{ route('admin.transaction.index') }}">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            Quay về trang
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:30px">#</th>
                                    <th>Mã giao dịch</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Giá tiền</th>
                                    <th class="text-center" style="width:200px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $row)
                                    <tr>
                                        @php
                                            $args = ['transaction_id' => $row->transaction_id];
                                        @endphp
                                        <td class="text-center">
                                            <input type="checkbox" id="checkId" value="1" name="checkId[]">
                                        </td>
                                        <td>{{ $row->transaction_id }}</td>
                                        <td>{{ $row->order_id }}</td>
                                        <td>{{ $row->payment_method }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td class="text-center">

                                            <a href="{{ route('admin.transaction.show', $args) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.transaction.restore', $args) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                            <form action="{{ route('admin.transaction.destroy', $args) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger d-inline" name="delete"
                                                    type="submit">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
