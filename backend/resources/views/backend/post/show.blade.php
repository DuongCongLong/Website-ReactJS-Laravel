@extends('layouts.admin')
@section('title', 'Chi tiết bài viết')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết bài viết</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Chi tiết bài viết</li>
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
                    <a href="{{ route('admin.post.edit', ['post_id' => $post->post_id]) }}" class="btn btn-sm btn-primary">
                        <i class="far fa-edit"></i> Sửa
                    </a>
                    <form action="{{ route('admin.post.destroy', ['post_id' => $post->post_id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                    <a class="btn btn-sm btn-info" href="{{ route('admin.post.index') }}">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width:30%;"><strong>Tên trường</strong></th>
                        <th class="text-center" style="width:70%;">Giá trị</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiêu đề</td>
                        <td>{{ $post->title }}</td>
                    </tr>
                    <tr>
                        <td>Chi tiết</td>
                        <td>{!! $post->detail !!}</td>
                    </tr>
                    <tr>
                        <td>Mô tả</td>
                        <td>{!! $post->description !!}</td>
                    </tr>
                    <tr>
                        <td>Chủ đề</td>
                        <td>{{ $post->topic->name ?? 'Không có chủ đề' }}</td>
                    </tr>
                    <tr>
                        <td>Kiểu</td>
                        <td>{{ $post->type == 'post' ? 'Bài viết' : 'Trang đơn' }}</td>
                    </tr>
                    <tr>
                        <td>Hình</td>
                        <td>
                            @if($post->image)
                                <img src="{{ asset('images/posts/' . $post->image) }}" alt="{{ $post->title }}" style="width:20%; max-width: 100%; height: auto;">
                            @else
                                Không có hình ảnh
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>{{ $post->status == 1 ? 'Xuất bản' : 'Chưa xuất bản' }}</td>
                    </tr>
                    <tr>
                        <td>Ngày tạo</td>
                        <td>{{ $post->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Người tạo</td>
                        <td>{{ $post->created_by }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
