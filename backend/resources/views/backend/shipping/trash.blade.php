@extends('layouts.admin')
@section('title', 'Danh sách giao hàng đã xóa')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách giao hàng đã xóa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.shipping.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh sách giao hàng đã xóa</li>
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
                        <a class="btn btn-sm btn-info" href="{{ route('admin.shipping.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách chính
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã vận chuyển</th>
                            <th>Phương thức thanh toán</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $shipping)
                            <tr>
                                <td>{{ $shipping->shipping_id }}</td>
                                <td>{{ $shipping->shipping_method }}</td>
                                <td>{{ $shipping->cost }}</td>
                                <td>{{ $shipping->status == 1 ? 'Xuất bản' : 'Chưa xuất bản' }}</td>
                                <td class="text-center">
                                  <a href="{{ route('admin.shipping.show', $shipping->shipping_id) }}" class="btn btn-sm btn-info">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="{{ route('admin.shipping.restore', $shipping->shipping_id) }}" class="btn btn-sm btn-primary">
                                      <i class="fas fa-undo"></i>
                                  </a>
                                  <form action="{{ route('admin.shipping.destroy', $shipping->shipping_id) }}" method="post" class="d-inline" >
                                      @csrf
                                      @method('delete')
                                      <button class="btn btn-sm btn-danger d-inline" name="delete" type="submit" >
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
    </section>
@endsection
