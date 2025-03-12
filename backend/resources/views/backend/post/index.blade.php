@extends('layouts.admin')
@section('title', 'Bài viết')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.post.index') }}" method="GET" class="form-inline">
                            <input type="text" name="title" value="{{ request('title') }}" class="form-control mr-2" placeholder="Tìm kiếm bài viết (chữ cái đầu)">
                            <select name="status" class="form-control mr-2">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Xuất bản</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Chưa xuất bản</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-sm btn-success" href="{{ route('admin.post.create') }}">
                            <i class="fas fa-plus"></i>
                            Thêm
                        </a>
                        <a class="btn btn-sm btn-danger" href="{{ route('admin.post.trash') }}">
                            <i class="fas fa-trash-alt"></i>
                            Thùng rác
                        </a>
                    </div>
                </div>
           </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:90px">Hình</th>
                            <th>Tên bài viết</th>
                            <th>Chi tiết bài viết</th>
                            <th>Mô tả</th>
                            <th class="text-center" style="width:200px">Chức năng</th>
                            <th class="text-center" style="width:30px">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $row)
                            @php
                                $args = ['post_id' => $row->post_id];
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('images/posts/' . $row->image) }}"class="img-fluid"
                                        alt="{{ $row->image }}">
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($row->title, 50) }}</td>
<td>{{ \Illuminate\Support\Str::limit($row->detail, 50) }}</td>
<td>{!! \Illuminate\Support\Str::limit($row->description, 100) !!}</td>

                                <td class="text-center" style="width:220px">
                                    @if ($row->status == 1)
                                    <a href="{{ route('admin.post.status', $args ) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.post.status', $args ) }}" class="btn btn-sm btn-danger">
                                      <i class="fas fa-toggle-off"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.post.show', $args ) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.post.edit', $args ) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.post.delete', $args ) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                              </td>
                                <td class="text-center">{{ $row->post_id }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $list->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>
@endsection
