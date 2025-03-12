@extends('layouts.admin')
@section('title', 'Cập nhập danh mục')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật danh mục</h1>
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
                        <a class="btn btn-sm btn-danger" href="brand_trash.html">
                            <i class="fas fa-trash"></i> Thùng rác
                        </a>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.category.index') }}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update', ['id' => $category->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="name">Tên danh mục</label>
                        <input type="text" value="{{ old('name', $category->name) }}" name="name" id="name"
                            class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" value="{{ old('description', $category->description) }}" id="description"
                            class="form-control">{{ old('description', $category->description) }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="image">Hình ảnh</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($category->image)
                            <img src="{{ asset('images/categorys/' . $category->image) }}"
                                alt="{{ $category->category_name }}" class="img-thumbnail mt-2" width="100">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="2" {{ old('status', $category->status) == 2 ? 'selected' : '' }}>Chưa xuất
                                bản</option>
                            <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Xuất bản
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="create" class="btn btn-success">Cập nhập danh mục</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Include TinyMCE library -->
    <script src="https://cdn.tiny.cloud/1/fxgjwcfyo3azis0k1leo2scs3jr41e6p5lvohyl3psd4i11o/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- Initialize TinyMCE on the textarea -->
    <script>
        tinymce.init({
            selector: '#description',
            menubar: false,
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            plugins: 'lists',
            height: 300
        });
    </script>
@endsection
