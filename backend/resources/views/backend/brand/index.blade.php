@extends('layouts.admin')
@section('title', 'Thương hiệu')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">

                        <!-- Form lọc nằm ngang -->
                        <form method="GET" action="{{ route('admin.brand.index') }}" class="form-inline">
                            <div class="form-group mr-2">
                                <label for="name" class="sr-only">Tên thương hiệu</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Tên thương hiệu" value="{{ request('name') }}">
                            </div>
                            <div class="form-group mr-2">
                                <label for="status" class="sr-only">Trạng thái</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Vô hiệu hóa</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </form>
                        <!-- Các nút hành động nằm ngang -->
                        <div class="btn-group">
                            <a class="btn btn-sm btn-success" href="{{ route('admin.brand.create') }}">
                                <i class="fas fa-plus"></i> Thêm
                            </a>
                            <a class="btn btn-sm btn-danger" href="{{ route('admin.brand.trash') }}">
                                <i class="fas fa-trash-alt"></i> Thùng rác
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <form action="{{ route('admin.brand.delete_multiple') }}" method="POST" id="delete-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" id="delete-selected">
                        <i class="fas fa-trash-alt"></i>
                        Xóa đã chọn
                    </button>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:30px">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="text-center" style="width:90px">Hình</th>
                                <th style="white-space: nowrap;">Tên thương hiệu</th>
                                <th>Mô tả</th>
                                <th>Slug</th>
                                <th class="text-center" style="width:200px">Chức năng</th>
                                <th class="text-center" style="width:30px">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $row)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="brand-checkbox" value="{{ $row->id }}" name="checkId[]">
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset('images/brands/'.$row->image) }}" class="img-fluid" alt="{{ $row->name }}">
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{!! $row->description !!}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td class="text-center">
                                        @if ($row->status == 1)
                                            <a href="{{ route('admin.brand.status', ['id' => $row->id]) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.brand.status', ['id' => $row->id]) }}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-toggle-off"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.brand.show', ['id' => $row->id]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.brand.edit', ['id' => $row->id]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.brand.delete', ['id' => $row->id]) }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ $row->id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                <div class="pagination-wrapper">
                    {{ $list->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
    <script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.brand-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    document.getElementById('delete-selected').addEventListener('click', function(event) {
        event.preventDefault();
        
        var checkboxes = document.querySelectorAll('.brand-checkbox:checked');
        var ids = [];
        
        checkboxes.forEach(function(checkbox) {
            ids.push(checkbox.value);
        });

        if (ids.length === 0) {
            alert('Vui lòng chọn ít nhất một thương hiệu.');
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

