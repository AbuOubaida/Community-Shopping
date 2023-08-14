@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-capitalize">{{str_replace('.', ' ', \Route::currentRouteName())}}</h1>
            @if($order_product->order_status != 0)
                <a href="{!! route("vendor.invoice.pdf.product",['orderID'=>encrypt($order_product->id)]) !!}" class="float-end btn btn-outline-success btn-sm"><i class="fas fa-file"></i> Download PDF</a>
            @endif
            <ol class="breadcrumb mb-4 bg-none">
                <li class="breadcrumb-item">
                    <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="text-capitalize text-chl">Previous</a>
                </li>
                <li class="breadcrumb-item">
                    <a style="text-decoration: none;" href="#" class="text-capitalize text-active">{{str_replace('.', ' ', \Route::currentRouteName())}}</a>
                </li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                        @if(isset($order_product))
                            <div class="row">
                                <div class="col-md-6">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th>Invoice ID:</th>
                                            <td><a href="{!! route('vendor.view.invoice',['invoiceID'=>encrypt($order_product->invoice_id)]) !!}">#{!! $order_product->invoice_id !!}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Order ID:</th>
                                            <td>{!! $order_product->order_id !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Order Date:</th>
                                            <td>{!! date('d-M-y', strtotime($order_product->created_at)) !!}</td>
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
                                                    <p>Mr./Ms. {!! $order_product->customer_name !!},</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 2%">No</th>
                                            <th style="width: 5%">Action</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 30%">Product Name</th>
                                            <th style="width: 10%">Price</th>
                                            <th style="width: 3%">Qty</th>
                                            <th style="width: 15%">Subtotal</th>
                                            <th style="width: 10%">Tax Amount</th>
                                            <th style="width: 15%">Grand Total</th>
                                        </tr>
                                        @if($order_product)
                                            @php
                                                $n = 1;
                                                $total=0;
                                                $totalTax=0;
                                            @endphp
                                            <tr align="center">
                                                <td>{!! $n !!}</td>
                                                <td>
                                                @if($order_product->order_status == 1)
                                                    <form action="{{route('vendor.delete.order')}}" method="post" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="product_id" value="{{encrypt($order_product->id)}}">
                                                        <button title="Cancel Order" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure cancel this Order?')" type="submit"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @elseif($order_product->order_status == 2)
                                                    <form action="{!! route("submit.order.admin") !!}" method="post" class="d-inline-block">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="order_id" value="{{encrypt($order_product->id)}}">
                                                        <button title="Send request to admin" class="btn-style-none d-inline-block text-success" onclick="return confirm('Are you sure submit this order to admin?')" type="submit"><i class="fas fa-check"></i></button>
                                                    </form>
                                                @endif
                                                </td>
                                                <td>
                                                    @if($order_product->order_status == 0)
                                                        <span class="badge bg-danger">Canceled</span>
                                                    @elseif($order_product->order_status == 1)
                                                        <span class="badge bg-primary">Primary</span>
                                                    @elseif($order_product->order_status == 2)
                                                        <span class="badge bg-info">Accepted</span>
                                                    @elseif($order_product->order_status == 3)
                                                    <span class="badge bg-primary" title="Handed over on vendor site logistic partner">H/O Logistic</span>
                                                    @elseif($order_product->order_status == 4)
                                                    <span class="badge bg-success">Admin Hub</span>
                                                    @elseif($order_product->order_status == 5)
                                                    <span class="badge bg-warning" title="Handed over on your community partner">H/O Community</span>
                                                    @elseif($order_product->order_status == 6)
                                                    <span class="badge bg-success">Received delivery community</span>
                                                    @elseif($order_product->order_status == 7)
                                                    <span class="badge bg-info">Received</span>
                                                    @elseif($order_product->order_status == 8)
                                                    <span class="badge bg-warning">Reviewed</span>
                                                    @elseif($order_product->order_status == 9)
                                                    <span class="badge bg-warning" title="Vendor request to admin">Request to Admin</span>
                                                    @elseif($order_product->order_status == 10)
                                                    <span class="badge bg-info">Admin to Admin</span>
                                                    @elseif($order_product->order_status == 11)
                                                    <span class="badge bg-warning" title="Vendor request to community">Request to community </span>
                                                    @elseif($order_product->order_status == 12)
                                                    <span class="badge bg-info" title="Vendor site community Hub">vendor community Hub</span>
                                                    @elseif($order_product->order_status == 13)
                                                        <span class="badge bg-warning" title="Vendor site community Hub">Community to Customer</span>
                                                    @else
                                                    <span class="badge bg-danger">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{route('vendor.edit.product',['productID'=>$order_product->product_id])}}">
                                                        {!! $order_product->product_name !!}
                                                    </a>
                                                </td>
                                                <td>BDT {!! $order_product->unite_price !!}/=</td>
                                                <td>{!! $order_product->order_quantity !!}</td>
                                                <td>BDT {!! $order_product->total_price !!}/=</td>
                                                <td>BDT {!! $order_product->tax_amount !!}/=</td>
                                                <td>BDT {!!($order_product->total_price + $order_product->tax_amount) !!}/=</td>
                                            </tr>
                                            @php
                                                $total += $order_product->total_price;
                                                $totalTax += $order_product->tax_amount;
                                            @endphp

                                        @else
                                            <tr align="center">
                                                <td colspan="1">Not Found!</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td colspan="9">
                                                <div class="total-part float-right margin-right-9-minus">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <th class="w-200-right">Sub Total:</th>
                                                            <td class="w-112-right">BDT {!! $total !!}/=</td>
                                                        </tr>
{{--                                                        <tr>--}}
{{--                                                            <th class="w-200-right">Shipping Charge:</th>--}}
{{--                                                            <td class="w-112-right">BDT {!! $order->shipping_charge !!}/=</td>--}}
{{--                                                        </tr>--}}
                                                        <tr>
                                                            <th class="w-200-right">Tax (0%):</th>
                                                            <td class="w-112-right">BDT {!! $totalTax !!}/=</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-200-right">Total Payable:</th>
                                                            <td class="float-end">BDT {!! ($total + $totalTax) !!}/=</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="clear: both;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @if($order_product->order_status == 1)
                                    <form action="{!! route("accepted.order") !!}" method="post" class="d-inline-block">
                                        {!! method_field('put') !!}
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="product_id" value="{{encrypt($order_product->id)}}">
                                        <button title="Accept Order" class="btn btn-outline-success float-end" onclick="return confirm('Are you sure accept this Order?')" type="submit"><i class="fas fa-check"></i> Accept Order</button>
                                    </form>
                                @elseif ($order_product->order_status == 2 )
                                    <div class="row">
                                        <div class="col-md-10">
                                            <form action="{!! route('vendor.submit.order.community') !!}" method="post">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="hidden" name="order_id" value="{{encrypt($order_product->id)}}">
                                                    <select class="form-control" name="community" id="community">
                                                        <option value="">--Select Option--</option>
                                                        @if(count($vendorCommunities))
                                                            @foreach($vendorCommunities as $c)
                                                                <option value="{{encrypt($c->id)}}">Name: {!! $c->community  !!} || ( Type:{!! $c->community_type !!}) || (Address: #Home-{!! $c->home !!}, Village-{!! $c->village !!}, Word-{!! $c->word !!}, Union-{!! $c->union !!}, Upazila-{!! $c->upazilla !!}, District-{!! $c->district !!}, Division-{!! $c->division !!})</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <button class="btn btn-outline-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-check"></i> Submit to community <i class="fas fa-people-group"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <form action="{!! route("submit.order.admin") !!}" method="post" class="d-inline-block float-end">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="order_id" value="{{encrypt($order_product->id)}}">
                                                <button title="Accept Order" class="btn btn-outline-primary mr--30" onclick="return confirm('Are you sure accept this Order?')" type="submit"><i class="fas fa-check"></i> Submit to admin</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif

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
