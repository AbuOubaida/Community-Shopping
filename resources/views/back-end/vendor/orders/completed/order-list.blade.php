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
                                                @if($o->order_status == 0)
                                                    <span class="badge bg-danger">Canceled</span>
                                                @elseif($o->order_status == 1)
                                                    <span class="badge bg-primary">Primary</span>
                                                @elseif($o->order_status == 2)
                                                    <span class="badge bg-info">Accepted</span>
                                                @elseif($o->order_status == 3)
                                                    <span class="badge bg-primary" title="Handed over on vendor site logistic partner">H/O Logistic</span>
                                                @elseif($o->order_status == 4)
                                                    <span class="badge bg-success">Admin Hub</span>
                                                @elseif($o->order_status == 5)
                                                    <span class="badge bg-warning" title="Handed over on your community partner">H/O Community</span>
                                                @elseif($o->order_status == 6)
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($o->order_status == 7)
                                                    <span class="badge bg-info">Received</span>
                                                @elseif($o->order_status == 8)
                                                    <span class="badge bg-warning">Reviewed</span>
                                                @elseif($o->order_status == 9)
                                                    <span class="badge bg-warning">Vendor to Admin</span>
                                                @elseif($o->order_status == 10)
                                                    <span class="badge bg-info">Admin to Admin</span>
                                                @elseif($o->order_status == 11)
                                                    <span class="badge bg-info">vendor to community</span>
                                                @elseif($o->order_status == 12)
                                                    <span class="badge bg-info" title="Vendor site community Hub">vendor community Hub</span>
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
