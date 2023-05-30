@extends('back-end.admin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User Account List</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">User Account List </li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    DataTable Example
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$userList) > 0)
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($userList as $ul)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$ul->name}}</td>
                                                    <td>{{$ul->role_name}}</td>
                                                    <td>@if($ul->status == 0) <span class="label text-danger">Inactive</span> @else <span class="label text-success">Active</span> @endif</td>
                                                    <td>{{$ul->email}}</td>
                                                    <td>{{$ul->phone}}</td>
                                                    <td>
{{--                                                        <a href="" class="text-primary">View</a>--}}
{{--                                                        <a href="" class="text-success">Edit</a>--}}
                                                        <form action="{{route('admin.delete.user')}}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="user_id" value="{{$ul->id}}">
                                                            <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this User?')" type="submit">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
