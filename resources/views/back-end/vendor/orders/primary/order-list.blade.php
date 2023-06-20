@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="mt-4 text-capitalize">{{str_replace('.', ' ', \Route::currentRouteName())}}</h1>
                    <ol class="breadcrumb mb-4 bg-none">
                        <li class="breadcrumb-item">
                            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="text-capitalize text-chl">Previous</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none;" href="#" class="text-capitalize text-active">{{str_replace('.', ' ', \Route::currentRouteName())}}</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header text-capitalize">
                                    <i class="fas fa-table me-1"></i>
                                    {{str_replace('.', ' ', \Route::currentRouteName())}}
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr >
                                            <th>No</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Invoice</th>
                                            <th>Order ID</th>
                                            <th>Qnt</th>
                                            <th>Unit Price</th>
                                            <th>Customer</th>
                                            <th>Stoke</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Invoice</th>
                                            <th>Order ID</th>
                                            <th>Qnt</th>
                                            <th>Unit Price</th>
                                            <th>Customer</th>
                                            <th>Stoke</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$primaryOrders) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($primaryOrders as $o)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td><a href=""><img style="height: 50px; border-radius: 5px" src="{!! url("assets/back-end/vendor/product/".$o->p_image) !!}" alt=""> &nbsp;{{$o->p_name}}</a></td>
                                                    <td>{{date('d-m-Y',strtotime($o->created_at))}}</td>
                                                    <td><a href="">{{$o->invoice_id}}</a></td>
                                                    <td><a href="{{route('vendor.view.order',['orderID'=>$o->id])}}">{{$o->order_id}}</a></td>
                                                    <td>{{$o->order_quantity}}</td>
                                                    <td>BDT {{$o->unite_price}}/=</td>
                                                    <td class="text-capitalize"> {{$o->customer_name}}</td>
                                                    <td>{{$o->p_quantity}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('vendor.view.order',['orderID'=>$o->id])}}" class="text-primary" title="View Order"><i class="fas fa-eye"></i></a>
                                                        <form action="#" method="post" class="d-inline-block">
                                                            {!! method_field('put') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="product_id" value="{{$o->id}}">
                                                            <button title="Accept Order" class="btn-style-none d-inline-block text-success" onclick="return confirm('Are you sure Accept this Order?')" type="submit"><i class="fas fa-check"></i></button>
                                                        </form>
                                                        <form action="{{route('vendor.delete.order')}}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="product_id" value="{{$o->id}}">
                                                            <button title="Cancel Order" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure Cancel this Order?')" type="submit"><i class="fas fa-trash"></i></button>
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
