@extends('layouts.admin')
@section('title', 'Thêm phương thức thanh toán')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm phương thức thanh toán</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transaction.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Thêm giao dịch</li>
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
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.transaction.trash') }}">
                        <i class="fas fa-trash-alt"></i> Thùng rác
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.transaction.index') }}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.transaction.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="order_id">Tên giao dịch</label>
                    <input type="text" value="{{ old('order_id') }}" name="order_id" id="order_id" class="form-control">
                    @error('order_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="amount">Số tiền</label>
                    <input type="number" value="{{ old('amount') }}" name="amount" id="amount" class="form-control">
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="payment_method">Phương thức thanh toán</label>
                    <select name="payment_method" id="payment_method" class="form-control">
                        <option value="">Chọn phương thức</option>
                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <!-- Add other payment methods as needed -->
                    </select>
                    @error('payment_method')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Thêm giao dịch</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
