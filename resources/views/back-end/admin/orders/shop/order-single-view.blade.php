@extends('back-end.admin.main')
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
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                            <tr class="table-warning">
                                                <th>Invoice ID:</th>
                                                <th>Order ID:</th>
                                                <th>Order Date:</th>
                                            </tr>
                                            <tr class="table-info">
                                                <td><a href="{!! route('vendor.view.invoice',['invoiceID'=>encrypt($order_product->invoice_id)]) !!}">#{!! $order_product->invoice_id !!}</a></td>
                                                <td>{!! $order_product->order_id !!}</td>
                                                <td>{!! date('d-M-y', strtotime($order_product->created_at)) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-borderless text-justify table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="4"><h4><i class="fas fa-users"></i> User information associated with the order</h4></th>
                                            </tr>
                                        </thead>
                                        <colgroup>
                                            <col span="1" class="col-group-1" style="background-color: papayawhip">
                                            <col span="1" class="col-group-1" style="background-color: #f8f8f8">
                                            <col span="1" class="col-group-2" style="background-color: #ffeeee">
                                            <col span="1" class="col-group-3" style="background-color: #e5eefc">
                                        </colgroup>
                                        <thead>
                                            <tr class="">
                                                <th><h5 title="Heading">#</h5></th>
                                                <th><h5>Shop Information</h5></th>
                                                <th><h5>Customer Information</h5></th>
                                                <th><h5>Delivery Community Info.</h5></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>User:</th>
{{--                                                Shop--}}
                                                <td>
                                                    <strong>Vendor Name: </strong>{!! $order_product->vendor !!}
                                                    <strong>Phone: </strong>{!! $order_product->vendor_phone !!}
                                                </td>

{{--                                                User--}}
                                                <td>
                                                    <strong>Name: </strong>{!! $order_product->customer !!}
                                                    <strong>Phone: </strong>{!! $order_product->customer_phone !!}
                                                </td>
{{--                                                Community--}}
                                                <td>
                                                    <strong>Name: </strong>{!! $order_product->community_user_name !!}
                                                    <strong>Phone: </strong>{!! $order_product->community_user_phone !!}
                                                </td>

                                            </tr>

                                            <tr>
                                                <th>Name:</th>
{{--                                                Shop--}}
                                                <td>{!! $order_product->shop_name !!} @if($order_product->shop_active_status ==1) <span class="badge bg-success" title="Shop Status Active">Active</span> @else <span class="badge bg-danger" title="Shop Status Inactive">Inactive</span> @endif</td>

{{--                                                User--}}
                                                <td><strong>Receiver Name: </strong> {!! $order_product->receiver_name !!}</td>
{{--                                                Community--}}
                                                <td> {!! $order_product->community_name !!} <span class="badge bg-info" title="Community Type">{!! $order_product->community_type !!}</span></td>

                                            </tr>

                                            <tr>
                                                <th>Contact:</th>
{{--                                                Shop--}}
                                                <td>
                                                    <Strong>Phone:</Strong>{!! $order_product->shop_phone !!}
                                                    <Strong>Email:</Strong>{!! $order_product->shop_email !!}
                                                </td>
{{--                                                User--}}
                                                <td>
                                                    <strong>Phone:</strong> {!! $order_product->receiver_phone !!}
                                                    <strong>Email:</strong> {!! $order_product->receiver_email !!}
                                                </td>
{{--                                                Community--}}
                                                <td>
                                                    <strong>Phone:</strong> {!! $order_product->community_phone !!}
                                                    <strong>Email:</strong> {!! $order_product->community_email !!}
                                                </td>

                                            </tr>
{{--                                        Address--}}
                                            <tr>
                                                <th>Address:</th>
{{--                                                Shop--}}
                                                <td class="text-justify">Home: {!! $order_product->shop_home !!}, Village: {!! $order_product->shop_vill !!}, Union: {!! $order_product->shop_union !!}, Upa-Zilla: {!! $order_product->shop_upazila !!}</td>

{{--                                                Customer--}}
                                                <td class="text-justify"><strong>Delivery: </strong>{!! $order_product->delivery_address !!}</td>

{{--                                                Delivery Community--}}
                                                <td class="text-justify">Village: {!! $order_product->community_village !!}, Union: {!! $order_product->community_union !!}, Upa-Zilla: {!! $order_product->community_upazila !!}, District: {!! $order_product->community_district !!}, Division: {!! $order_product->community_division !!}, Country: {!! $order_product->community_country !!}</td>

                                            </tr>
                                            <tr>
                                                <th>Action:</th>
{{--                                                Shop--}}
                                                <td class="text-center">
                                                    <button class="btn btn-outline-success d-inline-block">Message<i class="fas fa-paper-plane"></i></button>
                                                    @if($order_product->order_status == 9)
                                                        <form class="d-inline-block" action="" method="post">
                                                            @csrf
                                                            {!! method_field('put') !!}
                                                            <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                            <input onclick="return confirm('Are you sure?')" type="submit" name="" class="btn btn-info" value="Received Order">
                                                        </form>
                                                    @endif
                                                </td>
{{--                                                Customer--}}
                                                <td class="text-center"><button class="btn btn-outline-success">Message <i class="fas fa-paper-plane"></i></button></td>
{{--                                                Community--}}
                                                <td class="text-center">
                                                    <button class="btn btn-outline-success d-inline-block">Message <i class="fas fa-paper-plane"></i></button>
                                        @if($order_product->order_status == 3)
                                            @if($order_product->delivery_district == \Illuminate\Support\Facades\Auth::user()->district)
                                                <form class="d-inline-block" action="" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="button" onclick="return confirm('Are you sure?')" name="" class="btn btn-primary" value="Send to Community">
                                                </form>
                                            @else
                                                <form class="d-inline-block" action="{!! route('admin.shop.order.admin') !!}" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                    <input type="submit" name="" class="btn btn-warning" value="Send to Admin" onclick="return confirm('Are you sure?')" title="Send Order to Customer Site Admin">
                                                </form>
                                            @endif
                                        @elseif($order_product->order_status == 10)
                                                <form class="d-inline-block" action="" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                    <input type="submit" name="" class="btn btn-info" value="Received Order" onclick="return confirm('Are you sure?')" title="Admin Order Received From Vendor Site Admin">
                                                </form>
                                        @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                                    @if($order_product->status_name)
                                                        <span class="badge {!! $order_product->badge !!}" title="{!! $order_product->title !!}">{!! $order_product->status_name !!}</span>
                                                    @else
                                                        <span class="badge bg-danger">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{route('vendor.edit.product',['productID'=>$order_product->product_id])}}">
                                                        {!! $order_product->p_name !!}
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
{{--                                                        @if(count($vendorCommunities))--}}
{{--                                                            @foreach($vendorCommunities as $c)--}}
{{--                                                                <option value="{{encrypt($c->id)}}">Name: {!! $c->community  !!} || ( Type:{!! $c->community_type !!}) || (Address: #Home-{!! $c->home !!}, Village-{!! $c->village !!}, Word-{!! $c->word !!}, Union-{!! $c->union !!}, Upazila-{!! $c->upazilla !!}, District-{!! $c->district !!}, Division-{!! $c->division !!})</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        @endif--}}
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
