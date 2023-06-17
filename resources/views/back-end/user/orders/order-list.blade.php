@extends('back-end.user.main')
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
                                            <th>Order id</th>
                                            <th>Product Count</th>
                                            <th>Customer name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Order id</th>
                                            <th>Product Count</th>
                                            <th>Customer name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$orders) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($orders as $o)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$o->order_id}}</td>
                                                    <td>{{$o->nop}}</td>
                                                    <td class="text-capitalize"> {{$o->customer_name}}</td>
                                                    <td>BDT {{$o->price}}</td>
                                                    <td>@if($o->order_status == 1) <spen class="text-success">Active</spen> @else <span class="text-danger">Inactive</span> @endif</td>
{{--                                                    <td>{{$o->delivery_address}}</td>--}}
                                                    <td class="text-center">
                                                        <a title="View" href="{{route("order.single",['orderID'=>$o->order_id])}}" class="text-primary"><i class="fas fa-eye"></i></a>
{{--                                                        <a title="Edit" href="" class="text-success"><i class="fas fa-edit"></i></a>--}}
{{--                                                        <form action="" method="post" class="d-inline-block">--}}
{{--                                                            {!! method_field('delete') !!}--}}
{{--                                                            {!! csrf_field() !!}--}}
{{--                                                            <input type="hidden" name="user_id" value="">--}}
{{--                                                            <button title="Delete" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this User?')" type="submit"><i class="fas fa-trash"></i></button>--}}
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
