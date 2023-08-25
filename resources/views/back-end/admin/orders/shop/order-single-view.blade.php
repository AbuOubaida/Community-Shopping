@extends('back-end.admin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-capitalize">{{str_replace('.', ' ', \Route::currentRouteName())}}</h1>
{{--            @if($order_product->order_status != 0)--}}
{{--                <a href="{!! route("vendor.invoice.pdf.product",['orderID'=>encrypt($order_product->id)]) !!}" class="float-end btn btn-outline-success btn-sm"><i class="fas fa-file"></i> Download PDF</a>--}}
{{--            @endif--}}
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
                                        <thead>
                                            <tr class="table-warning">
                                                <th>Order Active Status:</th>
                                                <th>Invoice ID:</th>
                                                <th>Order ID:</th>
                                                <th>Order Date:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>
                                                    @if($order_product->order_active_status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td><a href="{!! route('vendor.view.invoice',['invoiceID'=>encrypt($order_product->invoice_id)]) !!}">#{!! $order_product->invoice_id !!}</a></td>
                                                <td>{!! $order_product->order_id !!}</td>
                                                <td>{!! date('d-M-y', strtotime($order_product->created_at)) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="table-warning">
                                                <th colspan="9"><i class="fas fa-qrcode"></i> Order Product Information</th>
                                            </tr>
                                        </thead>
                                        <tr >
                                            <th style="width: 20%">Product</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 8%" title="Order Quantity">O. Qty.</th>
                                            <th style="width: 8%" title="Delivery Quantity">D. Qty.</th>
                                            <th style="width: 10%">Price</th>
                                            <th style="width: 10%">Discount</th>
                                            <th style="width: 12%">Subtotal</th>
                                            <th style="width: 10%">Tax</th>
                                            <th style="width: 12%" class="text-center">Total</th>
                                        </tr>
                                        @if($order_product)
                                            @php
                                                $n = 1;
                                                $total=0;
                                                $totalTax=0;
                                            @endphp
                                            <tr align="center" class="table-secondary">
                                                <td>
                                                    <img width="50%" src="{!! url('assets/back-end/vendor/product').'/'.$order_product->p_image !!}" alt="">
                                                    <a href="">
                                                        {!! $order_product->p_name !!}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($order_product->status_name)
                                                        <span class="badge {!! $order_product->badge !!}" title="{!! $order_product->title !!}">{!! $order_product->status_name !!}</span>
                                                    @else
                                                        <span class="badge bg-danger">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! $order_product->order_quantity !!}
                                                </td>
                                                <td>
                                                    {!! $order_product->delivery_quantity !!}
                                                </td>
                                                <td>BDT {!! $order_product->total_price !!}/=</td>
                                                <td>BDT {!! $order_product->discount !!}/=</td>
                                                <td>BDT {!! $order_product->total_price !!}/=</td>
                                                <td>BDT {!! $order_product->tax_amount !!}/=</td>
                                                <td class="text-end">BDT {!!($order_product->total_price + $order_product->tax_amount) !!}/=</td>
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
                                        <tr class="table-success">
                                            <td colspan="9">
                                                <div class="total-part float-right margin-right-9-minus">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <th class="w-200-right">Sub Total:</th>
                                                            <td class="w-112-right text-end">BDT {!! $total !!}/=</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="clear: both;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <thead>
                                        <tr>
                                            <th colspan="9" class="table-warning"><i class="fas fa-credit-card"></i> Payment Information</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-info">
                                        <tr>
                                            <th colspan="3">Payment Method</th>
                                            <th colspan="3" class="text-center">Payment Status</th>
                                            <th colspan="3" class="text-end">Delivery Charge</th>
{{--                                            <th colspan="1" class="text-center">Grand Total</th>--}}
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                @if($order_product->payment_method == 1)
                                                    <strong class="text-danger">Online Payment</strong>
                                                @elseif($order_product->payment_method == 2)
                                                    <strong class="text-success">Cash On Delivery</strong>
                                                @endif
                                            </td>
                                            <td colspan="3" class="text-center">
                                                @if($order_product->payment_status)
                                                    <strong class="badge bg-success">Paid</strong>
                                                @else
                                                    <strong class="badge bg-danger">Unpaid</strong>
                                                @endif
                                            </td>
                                            <td colspan="3" class="text-end">BDT {!! $order_product->shipping_charge !!}/=</td>
{{--                                            <td colspan="1" class="text-end">BDT {!! ($total + $totalTax + $order_product->shipping_charge) !!}/=</td>--}}
                                        </tr>
                                        </tbody>
                                        <tr class="table-secondary">
                                            <td colspan="9">
                                                <div class="total-part float-right margin-right-9-minus">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <th class="w-200-right">Delivery Charge: </th>
                                                            <td class="w-112-right text-end">BDT {!! $order_product->shipping_charge !!}/=</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-200-right">Tax (0%):</th>
                                                            <td class="w-112-right text-end">BDT {!! $totalTax !!}/=</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-200-right">Grand Total: </th>
                                                            <td class="float-end text-end">BDT {!! ($total + $totalTax + $order_product->shipping_charge) !!}/=</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="clear: both;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">

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
                                                        <form class="d-inline-block" action="{!! route('admin.received.order.from.shop') !!}" method="post">
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
                                        @if($order_product->order_status == 3 || $order_product->order_status == 13)
                                            @if($order_product->delivery_district == \Illuminate\Support\Facades\Auth::user()->district)
                                                <form class="d-inline-block" action="{!! route('admin.shop.order.request.delivery.community') !!}" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                    <input type="submit" name="" class="btn btn-info" value="Send to community" onclick="return confirm('Are you sure?')" title="Admin send request to delivery community">
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
                                            @if($order_product->delivery_district == \Illuminate\Support\Facades\Auth::user()->district)
                                                <form class="d-inline-block" action="{!! route('admin.to.admin.order.received') !!}" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                    <input type="submit" name="" class="btn btn-info" value="Received Order" onclick="return confirm('Are you sure?')" title="Admin Order Received From Vendor Site Admin">
                                                </form>
                                            @endif
                                        @elseif($order_product->order_status == 14)
                                            @if($order_product->delivery_district == \Illuminate\Support\Facades\Auth::user()->district)
                                                <form class="d-inline-block" action="{!! route('community.to.admin.order.received') !!}" method="post">
                                                    @csrf
                                                    {!! method_field('put') !!}
                                                    <input type="hidden" name="orderId" value="{!! encrypt($order_product->id) !!}">
                                                    <input type="submit" name="" class="btn btn-info" value="Received Order" onclick="return confirm('Are you sure to received order from vendor site community?')" title="Admin Received Order From Vendor Site Community">
                                                </form>
                                            @endif
                                        @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
