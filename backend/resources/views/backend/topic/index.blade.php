@extends('layouts.admin')
@section('title', 'Chủ đề')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>QUẢN LÍ CHỦ ĐỀ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quản lí chủ đề</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
               <div class="row">
    <div class="col-md-6">
        <form action="{{ route('admin.topic.index') }}" method="GET" class="form-inline">
            <input type="text" name="name" value="{{ request('name') }}" class="form-control mr-2" placeholder="Tìm kiếm chủ đề (chữ cái đầu)">
            <select name="status" class="form-control mr-2">
                <option value="">Tất cả trạng thái</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Xuất bản</option>
                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Chưa xuất bản</option>
            </select>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-sm btn-success" href="{{ route('admin.topic.create') }}">
            <i class="fas fa-plus"></i>
            Thêm
        </a>
        <a class="btn btn-sm btn-danger" href="{{ route('admin.topic.trash') }}">
            <i class="fas fa-trash-alt"></i>
            Thùng rác
        </a>
    </div>
</div>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tên chủ đề</th>
                            <th>Mô tả</th>
                            <th class="text-center" style="width:200px">Chức năng</th>
                            <th class="text-center" style="width:30px">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $row)
                            @php
                                $args = ['topic_id' => $row->topic_id];
                            @endphp
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{!! $row->description !!}</td>
                                <td class="text-center" style="width:220px">
                                    @if ($row->status == 1)
                                    <a href="{{ route('admin.topic.status', $args ) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-toggle-on"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.topic.status', $args ) }}" class="btn btn-sm btn-danger">
                                      <i class="fas fa-toggle-off"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.topic.show', $args ) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.topic.edit', $args ) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.topic.delete', $args ) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                              </td>
                                <td class="text-center">{{ $row->topic_id }}</td>
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
