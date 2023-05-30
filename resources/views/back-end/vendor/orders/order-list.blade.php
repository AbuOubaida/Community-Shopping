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
                                        <tr >
                                            <th>No</th>
                                            <th>Order ID</th>
                                            <th>Product</th>
                                            <th>Qnt</th>
                                            <th>Price</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Order ID</th>
                                            <th>Product</th>
                                            <th>Qnt</th>
                                            <th>Price</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Action</th>
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
                                                    <td><a href="{{route('vendor.view.order',['orderID'=>$o->id])}}">{{$o->order_id}}</a></td>
                                                    <td><a href="{{route('vendor.view.product',['productID'=>$o->products_id])}}" target="_blank">{{$o->product}}</a></td>
                                                    <td>{{$o->order_quantity}}</td>
                                                    <td>BDT {{$o->price}}</td>
                                                    <td class="text-capitalize"> {{$o->customer_name}}</td>
                                                    <td>{{$o->c_phone}}</td>
                                                    <td>{{$o->c_email}}</td>
                                                    @if($o->order_complete_status == 0)
{{--                                                    <td>--}}
{{--                                                        <a href="{{route('order.delivery',['oID'=>$o->id])}}" class="text-success"> Delivery</a>--}}

{{--                                                    </td>--}}
                                                    <td>
                                                        <a href="{{route('vendor.view.order',['orderID'=>$o->id])}}" class="text-primary">View</a>
                                                        <form action="{{route('vendor.delete.order')}}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="product_id" value="{{$o->id}}">
                                                            <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure Cancel this Order?')" type="submit">Cancel</button>
                                                        </form>
                                                    </td>
                                                    @endif
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
