@extends('layouts.admin')
@section('title','shipping')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cập nhật shipping</h1>
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
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.shipping.delete', ['shipping_id' => $shipping->shipping_id] ) }}">
                        <i class="fas fa-trash"></i> Thùng rác
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.shipping.index') }}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping.update',['shipping_id'=>$shipping->shipping_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("put")
                <div class="mb-3">
                  <label for="shipping_id">Mã shipping</label>
                  <input type="text" value="{{ old('shipping_id',$shipping->shipping_id) }}" name="shipping_id" id="shipping_id" class="form-control">
                </div>

                <div class="mb-3">
                  <label for="order_id">Mã đơn hàng</label>
                  <textarea name="order_id" value="{{ old('order_id',$shipping->order_id) }}" id="order_id" class="form-control">{{ old('order_id',$shipping->order_id) }}</textarea>
                </div>

                <div class="mb-3">
                  <label for="shipping_method">Phương thức thanh toán</label>
                  <textarea name="shipping_method" value="{{ old('shipping_method',$shipping->shipping_method) }}" id="shipping_method" class="form-control">{{ old('shipping_method',$shipping->shipping_method) }}</textarea>
                </div>

                <div class="mb-3">
                  <label for="cost">Giá</label>
                  <textarea name="cost" value="{{ old('cost',$shipping->cost) }}" id="cost" class="form-control">{{ old('cost',$shipping->cost) }}</textarea>
                </div>

                <div class="mb-3">
                  <label for="status">Trạng thái</label>
                  <select name="status" id="status" class="form-control">
                      <option value="2" {{ $shipping->status == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                      <option value="1" {{ $shipping->status == 1 ? 'selected' : '' }}>Xuất bản</option>
                  </select>
                </div>

                <div class="mb-3">
                  <button type="submit" name="create" class="btn btn-success">Cập nhập shipping</button>
                </div>
              </form>
        </div>
    </div>
</section>
@endsection