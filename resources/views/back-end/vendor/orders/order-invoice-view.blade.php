@extends('back-end.vendor.main')
@section('content')
<main>
    <div class="container-fluid px-4">
            <h1 class="mt-4 text-capitalize">{{str_replace('.', ' ', \Route::currentRouteName())}}</h1>
            @if($order->order_status == 1 || $order->order_status == 2 || $order->order_status == 9)
                <a href="{!! route("vendor.view.invoice.pdf",["invoiceID"=>encrypt($order->invoice_id)]) !!}" class="btn btn-outline-success btn-sm float-end"><i class="fas fa-download"></i> Download PDF</a>
            @elseif($order->order_status == 0)
                <span class="float-end">Order Status: <span class="badge bg-danger">Canceled</span></span>
            @endif
        <ol class="breadcrumb mb-4 bg-none">
            <li class="breadcrumb-item">
                <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="text-capitalize text-chl">Previous</a>
            </li>
            <li class="breadcrumb-item">
                <a style="text-decoration: none;" href="#" class="text-capitalize text-active">{{str_replace('.', ' ', \Route::currentRouteName())}}</a>
            </li>
        </ol>
        <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 rounded-lg">
                <div class="card-body">
                    @if(isset($order) && isset($order_products))
                        @if(count($order_products))
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
                                            <td>
                                                <a href="{{route('vendor.view.order',['orderID'=>encrypt($order->id)])}}">
                                                    {!! $order->order_id !!}
                                                </a>
                                            </td>
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
                                        @if(count($order_products))
                                            @php
                                                $n = 1;
                                                $total=0;
                                                $totalTax=0;
                                            @endphp
                                            @foreach($order_products as $op)
                                                <tr align="center">
                                                    <td>{!! $n++ !!}</td>
                                                    <td>
                                                        @if($op->order_status == 1)
                                                            <form action="{!! route("accepted.order") !!}" method="post" class="d-inline-block">
                                                                {!! method_field('put') !!}
                                                                {!! csrf_field() !!}
                                                                <input type="hidden" name="product_id" value="{{encrypt($op->id)}}">
                                                                <button title="Accept Order" class="btn-style-none d-inline-block text-success" onclick="return confirm('Are you sure accept this Order?')" type="submit"><i class="fas fa-check"></i></button>
                                                            </form>
                                                            <form action="{{route('vendor.delete.order')}}" method="post" class="d-inline-block">
                                                                {!! method_field('delete') !!}
                                                                {!! csrf_field() !!}
                                                                <input type="hidden" name="product_id" value="{{encrypt($op->id)}}">
                                                                <button title="Cancel Order" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure cancel this Order?')" type="submit"><i class="fas fa-trash"></i></button>
                                                            </form>
                                                        @elseif($op->order_status == 2)
                                                            <form action="{!! route("submit.order.admin") !!}" method="post" class="d-inline-block">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="order_id" value="{{encrypt($op->id)}}">
                                                                <button title="Send request to admin" class="btn-style-none d-inline-block text-success" onclick="return confirm('Are you sure submit this order to admin?')" type="submit"><i class="fas fa-check"></i></button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($op->order_status == 0)
                                                            <span class="badge bg-danger">Canceled</span>
                                                        @elseif($op->order_status == 1)
                                                            <span class="badge bg-primary">Primary</span>
                                                        @elseif($op->order_status == 2)
                                                            <span class="badge bg-info">Accepted</span>
                                                        @elseif($op->order_status == 3)
                                                            <span class="badge bg-primary" title="Handed over on vendor site logistic partner">H/O Logistic</span>
                                                        @elseif($op->order_status == 4)
                                                            <span class="badge bg-success">Admin Hub</span>
                                                        @elseif($op->order_status == 5)
                                                            <span class="badge bg-warning" title="Handed over on your community partner">H/O Community</span>
                                                        @elseif($op->order_status == 6)
                                                            <span class="badge bg-success">Delivered</span>
                                                        @elseif($op->order_status == 7)
                                                            <span class="badge bg-info">Received</span>
                                                        @elseif($op->order_status == 8)
                                                            <span class="badge bg-warning">Reviewed</span>
                                                        @elseif($op->order_status == 9)
                                                            <span class="badge bg-warning">Vendor to Admin</span>
                                                        @elseif($op->order_status == 10)
                                                            <span class="badge bg-info">Admin to Admin</span>
                                                        @else
                                                            <span class="badge bg-danger">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{route('vendor.edit.product',['productID'=>$op->product_id])}}">
                                                            {!! $op->product_name !!}
                                                        </a>
                                                    </td>
                                                    <td>BDT {!! $op->unite_price !!}/=</td>
                                                    <td>{!! $op->order_quantity !!}</td>
                                                    <td>BDT {!! $op->total_price !!}/=</td>
                                                    <td>BDT {!! $op->tax_amount !!}/=</td>
                                                    <td>BDT {!!($op->total_price + $op->tax_amount) !!}/=</td>
                                                </tr>
                                                @php
                                                    $total += $op->total_price;
                                                    $totalTax += $op->tax_amount;
                                                @endphp
                                            @endforeach
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
                                                        <tr>
                                                            <th class="w-200-right">Shipping Charge:</th>
                                                            <td class="w-112-right">BDT {!! $order->shipping_charge !!}/=</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-200-right">Tax (0%):</th>
                                                            <td class="w-112-right">BDT {!! $totalTax !!}/=</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-200-right">Total Payable:</th>
                                                            <td class="float-end">BDT {!! ($total + $totalTax + $order->shipping_charge) !!}/=</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="clear: both;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        @endif
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
