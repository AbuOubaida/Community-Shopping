@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-12">
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
            <div class="row">
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
                                        <th>Status</th>
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
                                        <th>Status</th>
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
                                            <td><a target="_blank" href="{{route('vendor.edit.product',['productID'=>$o->product_id])}}"><img style="height: 50px; border-radius: 5px" src="{!! url("assets/back-end/vendor/product/".$o->p_image) !!}" alt=""> &nbsp;{{$o->p_name}}</a></td>
                                            <td>
                                                @if($o->status_name)
                                                    <span class="badge {!! $o->badge !!}" title="{!! $o->title !!}">{!! $o->status_name !!}</span>
                                                @else
                                                    <span class="badge bg-danger">Unknown</span>
                                                @endif
                                            </td>
                                            <td>{{date('d-m-Y',strtotime($o->created_at))}}</td>
                                            <td><a href="{!! route('vendor.view.invoice',['invoiceID'=>encrypt($o->invoice_id)]) !!}">{{$o->invoice_id}}</a></td>
                                            <td><a href="{{route('vendor.view.order',['orderID'=>encrypt($o->id)])}}">{{$o->order_id}}</a></td>
                                            <td>{{$o->order_quantity}}</td>
                                            <td>BDT {{$o->unite_price}}/=</td>
                                            <td class="text-capitalize"> {{$o->customer_name}}</td>
                                            <td>{{$o->p_quantity}}</td>
                                            <td>
                                                <a href="{{route('vendor.view.order',['orderID'=>encrypt($o->id)])}}" class="text-primary" title="View Order"><i class="fas fa-eye"></i></a>
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
    </main>
@stop
