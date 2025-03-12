@extends('layouts.admin')
@section('title', 'Cập nhật sản phẩm')
@section('content')
    <form action="{{ route('admin.product.update', $product->product_id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cập nhật sản phẩm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Cập nhật sản phẩm</li>
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
                            <a href="{{ route('admin.product.clone', $product->product_id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-copy"></i> Sao chép sản phẩm
                            </a>
                            <button type="submit" name="update" class="btn btn-sm btn-success">
                                <i class="fa fa-save"></i> Lưu
                            </button>
                            <a class="btn btn-sm btn-info" href="{{ route('admin.product.index') }}">
                                <i class="fa fa-arrow-left"></i> Về danh sách
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="product_name">Tên sản phẩm</label>
                                <input type="text" value="{{ old('product_name', $product->product_name) }}" name="product_name" id="product_name" class="form-control">
                                @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description">Mô tả</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rating">Xếp hạng</label>
                                <input type="number" step="0.1" value="{{ old('rating', $product->rating) }}" name="rating" id="rating" class="form-control">
                                @error('rating')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price">Giá nhập</label>
                                <input type="number" step="0.01" value="{{ old('price', $product->price) }}" name="price" id="price" class="form-control">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="discount">Giảm giá (%)</label>
                                <input type="number" step="0.01" value="{{ old('discount', $product->discount) }}" name="discount" id="discount" class="form-control">
                                @error('discount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_stock">Tồn kho</label>
                                <input type="number" value="{{ old('product_stock', $product->product_stock) }}" name="product_stock" id="product_stock" class="form-control">
                                @error('product_stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category_id">Danh mục</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Chọn danh mục</option>
                                    {!! $htmlcategoryid !!}
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="brand_id">Thương hiệu</label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="">Chọn thương hiệu</option>
                                    {!! $htmlbrandid !!}
                                </select>
                                @error('brand_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image">Hình ảnh</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @if ($product->image)
                                    <img src="{{ asset('images/product/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-thumbnail mt-2" width="100">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="status">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="2" {{ old('status', $product->status) == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Xuất bản</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    
    <script src="https://cdn.tiny.cloud/1/fxgjwcfyo3azis0k1leo2scs3jr41e6p5lvohyl3psd4i11o/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'advlist autolink lists link image charmap preview anchor textcolor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: 'https://www.tiny.cloud/css/codepen.min.css',
            language: 'vi_VN',  // Thiết lập ngôn ngữ tiếng Việt nếu bạn muốn
        });
    </script>
@endsection
