@extends('layouts.admin')
@section('title', 'Liên hệ')
@section('content')
    <section class="content">
        <div class="card">

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tên liên hệ</th>
                            <th>Tin nhắn</th>
                            <th>Email</th>
                            <th class="text-center" style="width:30px">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $row)
                            @php
                                $args = ['contact' => $row->id];
                            @endphp
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->message }}</td>
                                <td>{!! $row->email !!}</td>
                                
                                <td class="text-center">{{ $row->id }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
