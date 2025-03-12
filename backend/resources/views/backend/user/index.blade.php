@extends('layouts.admin')
@section('title', 'Tài khoản')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Người dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Người dùng</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-body">
            @if ($list->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Không tìm thấy người dùng nào.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tài khoản</th>
                                <th>Email</th>
                                <th>Quyền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $row)
                            @php
                              $args = ['user_id' => $row->id];
                            @endphp
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->role }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper">
                        {{ $list->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
