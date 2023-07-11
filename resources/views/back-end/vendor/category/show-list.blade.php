@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    {{$headerData['title']}}
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Category Name</th>
                                            <th>Create by</th>
                                            <th>Status</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Category Name</th>
                                            <th>Create by</th>
                                            <th>Status</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$categories) > 0)
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($categories as $c)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$c->c_name}}</td>
                                                    <td>@if(\Illuminate\Support\Facades\Auth::user()->name == $c->creater_name) <span class="badge bg-danger">{{\Illuminate\Support\Facades\Auth::user()->name}} (Me)</span> @else *** @endif</td>
                                                    <td>@if($c->status == 0) <span class="label text-danger">Inactive</span> @else <span class="label text-success">Active</span> @endif</td>
                                                    <td>
                                                        {{$c->c_description}}
                                                    </td>
                                                    <td>
                                                        <a href="{{route('vendor.view.category',['categoryID'=>$c->id])}}" class="text-primary"><i class="fas fa-eye"></i></a>
                                                        @if(\Illuminate\Support\Facades\Auth::user()->name == $c->creater_name) <a href="{{route('vendor.edit.category',['categoryID'=>$c->id])}}" class="text-success"> <i class="fas fa-edit"></i></a> @endif

{{--                                                        <form action="{{route('vendor.delete.category')}}" method="post" class="d-inline-block">--}}
{{--                                                            {!! method_field('delete') !!}--}}
{{--                                                            {!! csrf_field() !!}--}}
{{--                                                            <input type="hidden" name="category_id" value="{{$c->id}}">--}}
{{--                                                            <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this Apply Category?')" type="submit">Delete</button>--}}
{{--                                                        </form>--}}
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
