@extends('layouts.admin')
@section('title', 'Sản phẩm')
@section('content')
<style>
    .pagination .pagination-info {
        display: none;
    }
    .pagination-info {
    display: none;
    }
</style>
<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <form action="{{ route('admin.product.index') }}" method="GET" class="form-inline">
                        <input type="text" name="product_name" class="form-control-sm mr-2" placeholder="Tên sản phẩm (chữ cái đầu)" value="{{ request()->get('product_name') }}">
                        <input type="text" name="price_min" class="form-control-sm mr-2" placeholder="Giá từ" value="{{ request()->get('price_min') }}">
                        <input type="text" name="price_max" class="form-control-sm mr-2" placeholder="Giá đến" value="{{ request()->get('price_max') }}">
                        <select name="category_id" class="form-control-sm mr-2">
                            <option value="">Danh mục</option>
                            {!! $htmlcategory !!}
                        </select>
                        <select name="brand_id" class="form-control-sm mr-2">
                            <option value="">Thương hiệu</option>
                            {!! $htmlbrand !!}
                        </select>
                        <button type="submit" class="btn-sm btn-primary">Lọc</button>
                    </form>
                </div>
                <div class="col text-right">
                    <form action="{{ route('admin.products.export') }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-sm btn-warning">
                            <i class="fas fa-file-excel"></i>
                            Xuất Excel
                        </button>
                    </form>
                    <a class="btn btn-sm btn-success" href="{{ route('admin.product.create') }}">
                        <i class="fas fa-plus"></i>
                        Thêm
                    </a>
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.product.trash') }}">
                        <i class="fas fa-trash-alt"></i>
                        Thùng rác
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($message)
                <div class="alert alert-warning">
                    {{ $message }}
                </div>
            @else
            <form action="{{ route('admin.product.delete_multiple') }}" method="POST" id="delete-form">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger" id="delete-selected">
                    <i class="fas fa-trash-alt"></i>
                    Xóa đã chọn
                </button>
            </form>
            
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:30px">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th class="text-center" style="width:70px">Hình</th>
                            <th style="width:300px">Tên sản phẩm</th>
                            <th class="text-center" style="width:100px">Giá nhập</th>
                            <th class="text-center" style="width:100px">Giảm giá</th>
                            <th class="text-center" style="white-space: nowrap;">Tồn kho</th>
                            <th style="width:150px">Danh mục</th>
                            <th style="width:150px">Thương hiệu</th>
                            <th class="text-center" style="width:180px">Chức năng</th>
                            <th class="text-center" style="width:50px">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $row)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="product-checkbox" value="{{ $row->product_id }}" name="checkId[]">
                                </td>
                                <td class="text-center">
                                    <img src="{{ asset('images/products/' . $row->image) }}" class="img-fluid" alt="{{ $row->image }}">
                                </td>
                                <td>{{ $row->product_name }}</td>
                                <td class="text-center">{{ number_format($row->price, 0, ',', '.') }}₫</td>
                                <td class="text-center">{{ $row->discount }}%</td>
                                <td class="text-center">{{ $row->product_stock }}</td>
                                <td>{{ $row->categoryname }}</td>
                                <td>{{ $row->brandname }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-success">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                    <a href="{{ route('admin.product.show', ['product_id' => $row->product_id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.product.edit', ['product_id' => $row->product_id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.product.delete', ['product_id' => $row->product_id]) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <td class="text-center">{{ $row->product_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $list->links('vendor.pagination.custom') }}
                </div>                
            @endif
        </div>
    </div>
</section>

<script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    document.getElementById('delete-selected').addEventListener('click', function(event) {
        event.preventDefault();
        
        var checkboxes = document.querySelectorAll('.product-checkbox:checked');
        var ids = [];
        
        checkboxes.forEach(function(checkbox) {
            ids.push(checkbox.value);
        });

        if (ids.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm.');
            return;
        }

        var form = document.getElementById('delete-form');
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids';
        input.value = ids.join(',');
        form.appendChild(input);
        
        form.submit();
    });
</script>
@endsection
