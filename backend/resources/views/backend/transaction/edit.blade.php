@extends('layouts.admin')
@section('title', 'Chỉnh sửa phương thức thanh toán')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh sửa phương thức thanh toán</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transaction.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa giao dịch</li>
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
                        <i class="fas fa-trash"></i> Thùng rác
                    </a>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.transaction.index') }}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.transaction.update', $transaction->transaction_id) }}" method="post" enctype="multipart/form-data">
               @csrf
               @method('PUT')
           
               <div class="mb-3">
                   <label for="order_id">Mã đơn hàng</label>
                   <input type="text" value="{{ old('order_id', $transaction->order_id) }}" name="order_id" id="order_id" class="form-control">
                   @error('order_id')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
           
               <div class="mb-3">
                   <label for="amount">Số tiền</label>
                   <input type="number" value="{{ old('amount', $transaction->amount) }}" name="amount" id="amount" class="form-control">
                   @error('amount')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
           
               <div class="mb-3">
                   <label for="payment_method">Phương thức thanh toán</label>
                   <input type="text" value="{{ old('payment_method', $transaction->payment_method) }}" name="payment_method" id="payment_method" class="form-control">
                   @error('payment_method')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
               </div>
           
               <div class="mb-3">
                   <button type="submit" class="btn btn-success">Cập nhật giao dịch</button>
               </div>
           </form>

        </div>
    </div>
</section>
@endsection
