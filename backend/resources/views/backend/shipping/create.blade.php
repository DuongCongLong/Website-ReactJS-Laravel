@extends('layouts.admin')
@section('title', 'Thêm giao hàng')
@section('content')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm giao hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.shipping.index') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Thêm giao hàng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <form action="{{ route('admin.shipping.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" name="create" class="btn btn-sm btn-success">
                                <i class="fa fa-save"></i> Lưu
                            </button>
                            <a class="btn btn-sm btn-info" href="{{ route('admin.shipping.index') }}">
                                <i class="fa fa-arrow-left"></i> Về danh sách
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="shipping_id">Mã vận chuyển</label>
                                <input type="text" value="{{ old('shipping_id') }}" name="shipping_id" id="shipping_id"
                                    class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="shipping_method">Phương thức thanh toán</label>
                                <textarea name="shipping_method" id="shipping_method" class="form-control">{{ old('shipping_method') }}</textarea>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="cost">Giá</label>
                                <textarea name="cost" id="cost" class="form-control">{{ old('cost') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
