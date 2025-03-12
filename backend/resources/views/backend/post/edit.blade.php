@extends('layouts.admin')
@section('title', 'Bài viết')
@section('content')
<form action="{{ route('admin.post.update', $post->post_id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Sử dụng phương thức PUT cho cập nhật -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa bài viết</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa bài viết</li>
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
                        <button type="submit" name="update" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i> Lưu
                        </button>
                        <a class="btn btn-sm btn-info" href="{{ route('admin.post.index')}}">
                            <i class="fa fa-arrow-left"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="title">Tiêu đề</label>
                            <input type="text" value="{{ old('title', $post->title) }}" name="title" id="title" class="form-control">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="detail">Chi tiết</label>
                            <textarea name="detail" id="detail" rows="8" class="form-control">{{ old('detail', $post->detail) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $post->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="topic_id">Chủ đề</label>
                            <select name="topic_id" id="topic_id" class="form-control">
                                <option value="">Chọn chủ đề</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}" {{ $post->topic_id == $topic->id ? 'selected' : '' }}>
                                        {{ $topic->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type">Kiểu</label>
                            <select name="type" id="type" class="form-control">
                                <option value="post" {{ $post->type == 'post' ? 'selected' : '' }}>Bài viết</option>
                                <option value="page" {{ $post->type == 'page' ? 'selected' : '' }}>Trang đơn</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image">Hình</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if ($post && $post->image)
                                <img src="{{ asset('images/posts/' . $post->image) }}" alt="{{ $post->image }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="2" {{ $post->status == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                                <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!-- Thêm mã JavaScript của TinyMCE -->
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
