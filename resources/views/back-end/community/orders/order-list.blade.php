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
                                            <th>Product</th>
                                            <th>Customer name</th>
                                            <th>Order quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Address</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Order id</th>
                                            <th>Product</th>
                                            <th>Customer name</th>
                                            <th>Order quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Address</th>
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
                                                    <td>
{{--                                                        <img src="{{url('assets/back-end/vendor/product/').'/'.$o->image}}" alt="product Image" width="20%" class="tabel-image">--}}
                                                        <br> {{$o->product}}</td>
                                                    <td class="text-capitalize"> {{$o->customer_name}}</td>
                                                    <td>{{$o->order_quantity}}</td>
                                                    <td>BDT {{$o->price}}</td>
                                                    <td>@if($o->order_complete_status == 0) <spen class="text-warning">Pending</spen> @else <span class="text-success">Complete</span> @endif</td>
                                                    <td>{{$o->delivery_address}}</td>
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
