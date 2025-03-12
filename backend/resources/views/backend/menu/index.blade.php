@extends('layouts.admin')
@section('title','Menu')
@section('content')

  <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản lý menu</h1>
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
                    <a class="btn btn-sm btn-danger" href="{{ route('admin.menu.trash') }}">
                        <i class="fas fa-trash"></i> Thùng rác
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form action="{{ route('admin.menu.store')}}" method="post">
                        @csrf
                        <div class="accordion" id="accordionExample">
                          <div class="card p-3">
                        </div>
                            <!-- end card -->
                            <div class="card">
                                <div class="card-header" id="headingCustom">
                                    <a class="d-block" data-toggle="collapse"
                                        data-target="#collapseCustom" aria-expanded="true"
                                        aria-controls="collapseCustom">
                                        Tùy liên kết
                                    </a>
                                </div>
                                <div id="collapseCustom" class="collapse"
                                    aria-labelledby="headingCustom" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name">Tên menu</label>
                                            <input type="text" value="" name="name" id="name" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="link">Liên kết</label>
                                            <input type="text" value="" name="link" id="link" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <input type="submit" value="Thêm menu" name="createCustom" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                            <div class="card p-3">
                                <label for="status">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="2">Chưa xuất bản</option>
                                    <option value="1">Xuất bản</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Link</th>
                            <th>Vị trí</th>
                            <th class="text-center" style="width:200px">Chức năng</th>
                            <th class="text-center" style="width:30px">ID</th>
                        </tr>
                    </thead>
                        <tbody>
                          @foreach ($list as $row)
                          @php
                            $args = ['id' => $row->id]
                          @endphp
                          <tr>
                              <td>{{ $row->name }}</td>
                              <td>{{ $row->link }}</td>
                              <td>{{ $row->position }}</td>
                              <td class="text-center">
                                @if ($row->status == 1)
                                <a href="{{ route('admin.menu.status', $args ) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-toggle-on"></i>
                                </a>
                                @else
                                <a href="{{ route('admin.menu.status', $args ) }}" class="btn btn-sm btn-danger">
                                  <i class="fas fa-toggle-off"></i>
                                </a>
                                @endif
                                  <a href="{{ route('admin.menu.show', $args ) }}" class="btn btn-sm btn-info">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="{{ route('admin.menu.delete', $args ) }}" class="btn btn-sm btn-danger">
                                      <i class="fas fa-trash"></i>
                                  </a>
                              </td>
                              <td class="text-center">{{ $row->id }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <div class="pagination-wrapper">
                        {{ $list->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection