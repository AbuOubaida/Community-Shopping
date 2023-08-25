@extends('back-end.user.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <a href="{!! route("invoice.pdf",["orderID"=>encrypt($order->order_id),"userID"=>encrypt(\Illuminate\Support\Facades\Auth::user()->id)]) !!}" class="btn btn-outline-success btn-sm float-end"><i class="fas fa-download"></i> Download PDF</a>
            @if($order->order_status == 1)
                <a onclick="Obj.CancelOrder(this,'{!! encrypt($order->order_id) !!}')" class="btn btn-outline-danger btn-sm float-end" style="margin-right: 10px"><i class="fas fa-trash"></i> Cancel this order</a>
            @elseif($order->order_status == 0)
                <span class="float-end">Order Status: <span class="badge bg-danger">Canceled</span></span>
            @endif
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                        @if(isset($order))
                            <div class="row">
                                <div class="col-md-6">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>Invoice ID:</th>
                                            <td>#{!! $order->invoice_id !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Order ID:</th>
                                            <td>{!! $order->order_id !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Order Date:</th>
                                            <td>{!! date('d-M-y', strtotime($order->created_at)) !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <img class="logo-light" style="width: 30%" src="{{url("client-site/images/logo/cms.png")}}"/>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="w-50">From</th>
                                            <th class="w-50">To</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="box-text">
                                                    <p>{{str_replace('-', ' ', config('app.name'))}},</p>
                                                    <p>Dhaka,</p>
                                                    <p>Bangladesh</p>
                                                    <p>Contact: (+880) 1778-138 129</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="box-text">
                                                    <p> {!! $order->c_name !!},</p>
                                                    <p>{!! $order->delivery_address !!}</p>
                                                    <p>Contact: {!! $order->c_phone !!}</p>
                                                    <p>Email: {!! $order->c_email !!}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="w-50">Payment Method</th>
                                                <th class="w-50">Shipping Charge</th>
                                            </tr>
                                            <tr>
                                                <td>@if($order->payment_method == 1) {{"Online Payment"}} @elseif($order->payment_method == 2){{"Cash On
                    Delivery"}} @else {{"Undefine"}} @endif</td>
                                                <td>Community Shipping Charge BDT {!! $order->shipping_charge !!}/=</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 2%">No</th>
                                                <th style="width: 5%">Action</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 27%">Product Name</th>
                                                <th style="width: 10%">Price</th>
                                                <th style="width: 5%">Order Qty.</th>
                                                <th style="width: 5%">Delivery Qty.</th>
                                                <th style="width: 11%">Subtotal</th>
                                                <th style="width: 10%">Tax Amount</th>
                                                <th style="width: 15%">Grand Total</th>
                                            </tr>
                                            @php
                                                $n = 1;
                                                $total=0;
                                                $totalTax=0;
                                            @endphp
                                            <tr align="center">
                                                <td>{!! $n !!}</td>
                                                <td>
{{--                                            1=primary--}}
                                                @if($order->order_status == 1)
                                                    <button class="btn btn-outline-danger btn-sm" onclick="Obj.CancelProductOrder(this,'{!! encrypt($order->id) !!}')" ref="{!! encrypt($order->id) !!}">Cancel</button>
{{--                                             6=Community Request to Customer for receive product--}}
                                                @elseif($order->order_status == 6)
                                                    <form action="{!! route('user.accept.order.submit') !!}" method="post">
                                                        @csrf
                                                        {!! method_field('put') !!}
                                                        <input type="hidden" name="ref" value="{!! encrypt($order->id) !!}">
                                                        <input onclick="return confirm('Are you sure to accept this order?')" class="btn btn-outline-success btn-sm" type="submit" value="Accept" title="Accept this order">
                                                    </form>
                                                @endif
                                                </td>
                                                <td>
                                                @if($order->status_name)
                                                    <span class="badge {!! $order->badge !!}" title="{!! $order->title !!}">{!! $order->status_name !!}</span>
                                                @else
                                                    <span class="badge bg-danger">Unknown</span>
                                                @endif
                                                </td>
                                                <td><a target="_blank" href="{{route('client.single.product.view',['productSingleID'=>encrypt($order->p_id)])}}"><img style="height: 50px; border-radius: 5px" src="{!! url("assets/back-end/vendor/product/".$order->p_image) !!}" alt=""> &nbsp;{{$order->p_name}}</a></td>
                                                <td>BDT {!! $order->unite_price !!}/=</td>
                                                <td>{!! $order->order_quantity !!}</td>
                                                <td>{!! $order->delivery_quantity !!}</td>
                                                <td>BDT {!! $totalD = ($order->unite_price * $order->delivery_quantity) !!}/=</td>
                                                <td>BDT {!! $order->tax_amount !!}/=</td>
                                                <td>BDT {!! $totalTx = ($totalD + $order->tax_amount) !!}/=</td>
                                            </tr>

                                            <tr>
                                                <td colspan="10">
                                                    <div class="total-part float-right margin-right-9-minus">
                                                        <table>
                                                            <tbody>
                                                            <tr>
                                                                <th class="w-200-right">Sub Total:</th>
                                                                <td class="w-112-right">BDT {!! $totalTx !!}/=</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-200-right">Shipping Charge:</th>
                                                                <td class="w-112-right">BDT {!! $order->shipping_charge !!}/=</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-200-right">Total Payable:</th>
                                                                <td class="float-end">BDT {!! ($totalTx + $order->shipping_charge) !!}/=</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <div style="clear: both;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        @if($order->order_status == 6)
                                            <form action="{!! route('user.accept.order.submit') !!}" method="post">
                                                @csrf
                                                {!! method_field('put') !!}
                                                <input type="hidden" name="ref" value="{!! encrypt($order->id) !!}">
                                                <input onclick="return confirm('Are you sure to accept this order?')" class="btn btn-outline-success float-end" type="submit" value="Accept This Order" title="Accept this order">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                        @else
                            <h2 class="text-center text-danger">Not Found!</h2>
                        @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
