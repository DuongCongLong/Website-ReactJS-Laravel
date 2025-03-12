@extends('layouts.admin')
@section('title', 'Giao hàng')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>QUẢN LÍ GIAO HÀNG</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quản lí giao hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <form action="{{ route('admin.shipping.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="shipping_id" class="form-control" placeholder="Mã vận chuyển" value="{{ request()->shipping_id }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="shipping_method" class="form-control" placeholder="Phương thức vận chuyển" value="{{ request()->shipping_method }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="cost" class="form-control" placeholder="Giá" value="{{ request()->cost }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col text-right">
                        <a class="btn btn-sm btn-success" href="{{ route('admin.shipping.create') }}">
                            <i class="fas fa-plus"></i> Thêm
                        </a>
                        <a class="btn btn-sm btn-danger" href="{{ route('admin.shipping.trash') }}">
                            <i class="fas fa-trash-alt"></i> Thùng rác
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mã vận chuyển</th>
                            <th>Phương thức vận chuyển</th>
                            <th>Giá</th>
                            <th class="text-center" style="width:200px">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($list->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning" role="alert">
                                        Không tìm thấy giao hàng nào phù hợp với tiêu chí lọc.
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($list as $row)
                                @php
                                    $args = ['shipping_id' => $row->shipping_id];
                                @endphp
                                <tr>
                                    <td>{{ $row->shipping_id }}</td>
                                    <td>{{ $row->shipping_method }}</td>
                                    <td>{{ number_format($row->cost * 1000, 0, ',', '.') }} ₫</td>
                                    <td class="text-center" style="width:220px">
                                        @if ($row->status == 1)
                                            <a href="{{ route('admin.shipping.status', $args ) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.shipping.status', $args ) }}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-toggle-off"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.shipping.show', $args ) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.shipping.edit', $args ) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.shipping.delete', $args ) }}" class="btn btn-sm btn-danger">
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
