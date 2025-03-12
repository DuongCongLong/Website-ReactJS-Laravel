@extends('layouts.admin')
@section('title','Banner')
@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.banner.index') }}" method="GET" class="form-inline">
                        <input type="text" name="description" value="{{ request('description') }}" class="form-control mr-2" placeholder="Tìm kiếm danh mục">
                        <select name="status" class="form-control mr-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Xuất bản</option>
                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Chưa xuất bản</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.banner.trash') }}">
                        <i class="fas fa-trash-alt"></i> Thùng rác
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($list->isEmpty())
            <div class="alert alert-warning" role="alert">
                Không tìm thấy kết quả nào.
            </div>
        @else
            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Tên banner</label>
                            <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="link">Liên kết</label>
                            <input type="text" value="{{ old('link') }}" name="link" id="link" class="form-control">
                            @error('link')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{  $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image">Hình</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Chưa xuất bản</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Thêm banner</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:90px">Hình</th>
                                <th>Tên</th>
                                <th>Link</th>
                                <th>Mô tả</th>
                                <th class="text-center" style="width:200px">Chức năng</th>
                                <th class="text-center" style="width:30px">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $row)
                                @php
                                    $args = ['banner_id' => $row->banner_id];
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('images/banners/'.$row->image) }}" class="img-fluid" alt="{{ $row->name }}">
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->link }}</td>
                                    <td>{!! $row->description !!}</td>
                                    <td class="text-center">
                                        @if ($row->status == 1)
                                            <a href="{{ route('admin.banner.status', $args) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-toggle-on"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.banner.status', $args) }}" class="btn btn-sm btn-danger">
                                                <i class="fas fa-toggle-off"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.banner.show', $args) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.banner.edit', $args) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.banner.delete', $args) }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $row->banner_id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper">
                        {{ $list->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<script src="https://cdn.tiny.cloud/1/fxgjwcfyo3azis0k1leo2scs3jr41e6p5lvohyl3psd4i11o/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'advlist autolink lists link image charmap preview anchor textcolor',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: 'https://www.tiny.cloud/css/codepen.min.css'
    });
</script>
@endsection
