@extends('back-end.admin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-6">
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
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Invoice</th>
                                            <th><div title="Order ID">O.ID</div></th>
                                            <th>Status</th>
                                            <th><div title="Shop Name">S.Name</div></th>
                                            <th><div title="Shop Phone">S. Phone</div></th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Invoice</th>
                                            <th><div title="Order ID">O.ID</div></th>
                                            <th>Status</th>
                                            <th><div title="Shop Name">S.Name</div></th>
                                            <th><div title="Shop Phone">S. Phone</div></th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$order_products) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($order_products as $o)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{date('d-m-Y',strtotime($o->created_at))}}</td>
                                                    <td><a target="_blank" href=""><img style="height: 50px; border-radius: 5px" src="{!! url("assets/back-end/vendor/product/".$o->p_image) !!}" alt=""> &nbsp;{{$o->p_name}}</a></td>

                                                    <td><a href="{!! route('vendor.view.invoice',['invoiceID'=>encrypt($o->invoice_id)]) !!}">#{{$o->invoice_id}}</a></td>
                                                    <td><a href="{{route('vendor.view.order',['orderID'=>encrypt($o->id)])}}" title="Single order product view">{{$o->order_id}}</a></td>
                                                    <td>
                                                        @if($o->status_name)
                                                            <span class="badge {!! $o->badge !!}" title="{!! $o->title !!}">{!! $o->status_name !!}</span>
                                                        @else
                                                            <span class="badge bg-danger">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-capitalize"> {{$o->shop_name}}</td>
                                                    <td class="text-capitalize"> {{$o->shop_phone}}</td>
                                                    <td class="text-capitalize"> {{$o->shop_home}}, {!! $o->shop_vill !!}, {!! $o->shop_union !!}, {!! $o->shop_upazila !!}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <a href="{{route('community.to.admin.order.view',['orderID'=>encrypt($o->id)])}}" class="text-primary" title="View Order"><i class="fas fa-eye"></i></a>
                                                        </div>
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
