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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Order Information:</h3>
                                            <table style="width:100%">
                                                <tr>
                                                    <th>Order ID:</th>
                                                    <td>{{$order->order_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><a target="_blank" href="{{route('vendor.view.product',["productID"=>$order->products_id])}}">{{$order->product}}</a></td>
                                                </tr>
                                                <tr>
                                                    <th>Customer:</th>
                                                    <td>{{$order->customer_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Order Status:</th>
                                                    <td>@if($order->order_status == 1) <span class="badge badge-primary">Primary Label</span> @endif</td>
                                                </tr>
                                                <tr>
                                                    <th>Order Price Total:</th>
                                                    <td>BDT {{$order->price}}/=</td>
                                                </tr>
                                                <tr>
                                                    <th>Order Quantity:</th>
                                                    <td>{{$order->order_quantity}} Unit</td>
                                                </tr>

                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Customer Information:</h3>
                                            <table style="width:100%">
                                                <tr>
                                                    <th>Order ID:</th>
                                                    <td>{{$order->order_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td>{{$order->customer_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone:</th>
                                                    <td>{{$order->c_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email:</th>
                                                    <td>{{$order->c_email}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address:</th>
                                                    <td>{{$order->delivery_address}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Product Information:</h3>
                                            <table style="width:100%">
                                                <tr>
                                                    <th>Order ID:</th>
                                                    <td>{{$order->order_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><a target="_blank" href="{{route('vendor.view.product',["productID"=>$order->products_id])}}">{{$order->product}}</a></td>
                                                </tr>
                                                <tr>
                                                    <th>Image:</th>
                                                    <td><a href="{{url("assets/back-end/vendor/product/".$order->image)}}" target="_blank"><img width="20%" src="{{url("assets/back-end/vendor/product/".$order->image)}}" alt="{{$order->product}}"></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Present Price:</th>
                                                    <td>BDT {{$order->p_price}}/=</td>
                                                </tr>
                                                <tr>
                                                    <th>Available quantity:</th>
                                                    <td>{{$order->p_quantity}} Unit</td>
                                                </tr>
                                            @if(($order->offer_quantity))
                                                <tr>
                                                    <th>Offer quantity:</th>
                                                    <td>{{$order->offer_quantity}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Offer percentage:</th>
                                                    <td>{{$order->offer_percentage}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Offer start time:</th>
                                                    <td>{{$order->offer_start_time}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Offer end time:</th>
                                                    <td>{{$order->offer_end_time}}</td>
                                                </tr>
                                            @endif
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
