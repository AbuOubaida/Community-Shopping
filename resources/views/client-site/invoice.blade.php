<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{str_replace('-', ' ', config('app.name'))}} | Invoice</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    p{
        margin-block-start: 0;
        margin-block-end: 0;
    }
    .m-0-auto{
        margin: 0 auto;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:200px;
        position: absolute;
        top: -50px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:20px;
    }
    .float-left{
        float:left;
    }
    .float-right{
        float: right;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
    .download-btn {
        font-size: 16px;
        background: green;
        color: #FFFFFF;
        padding: 5px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }
    .download-btn:hover
    {
        background: #003f00;
        color: #949494;
    }
    .header{
        height: 80px;
        display : flex;
        align-items : center;
        justify-content: space-between;
    }
    .header a {
        text-decoration: none;
        font-weight: bold;
        color: black;
        display: inline-block!important;
    }
    .header a:hover {
        color: #0a53be;
    }
    .position-relative {
        position: relative;
    }
    .logo-light {
        width: 100%;
    }
    .logo-bg {
        width: 200px;
    }
    .alert{
        z-index: 10000;
    }
    .alert-success{
        background: #00a86e;
        border: none;
        color: #003f04;
    }
    .margin-right-9-minus{
        margin-right: -9px;
    }
    .w-200-right {
        width: 200px;
        text-align: right;
    }
    .w-112-right {
        width: 112px;
        text-align: right;
    }
</style>
<body class="m-0-auto w-85">
@if(isset($order) && isset($order_products))
@if(($order == null && count($order_products) <= 0))
    <h4 style="display: block;text-align: center"><strong>404!</strong> Not Found!</h4>
@else
    <div class="header">
        <a href="{{route('root')}}" class="logo-bg"><img class="logo-light" src="{{url("client-site/images/logo/cms.png")}}"/></a>
        <a href=" {!! route('login') !!}" >View order</a>
    </div>
    <div class="head-title">
        <h4 class="text-center m-0 p-0" style="color: #1abc9c">Order submit successfully!</h4>
        <h1 class="text-center m-0 p-0">Invoice</h1>
        <a href="{{route("invoice.pdf",["orderID"=>encrypt($order->order_id),encrypt(\Illuminate\Support\Facades\Auth::user()->id),])}}" class="float-right download-btn"> Download PDF</a>
    </div>
        <div class="add-detail mt-10">
            <div class="w-50 float-left mt-10">
                <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">#{!! $order->invoice_id !!}</span></p>
                <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">{!! $order->order_id !!}</span></p>
                <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{!! date('d-M-y', strtotime($order->created_at)) !!}</span></p>
            </div>
            {{--    <div class="w-50 float-left logo mt-10 position-relative">--}}
            {{--        <img class="logo-light " src="{{url("client-site/images/logo/cms.png")}}"/>--}}
            {{--    </div>--}}
            <div style="clear: both;"></div>
        </div>
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
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
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tr>
                    <th class="w-50">Payment Method</th>
                    <th class="w-50">Shipping Method</th>
                </tr>
                <tr>
                    <td>@if($order->payment_method == 1) {{"Online Payment"}} @elseif($order->payment_method == 2) {{"Cash On
                        Delivery"}}@else {{"Undefined"}} @endif</td>
                    <td>Community Shipping Charge BDT {!! $order->shipping_charge !!}/=</td>
                </tr>
            </table>
        </div>
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tr>
                    <th style="width: 2%">No</th>
                    <th style="width: 40%">Product Name</th>
                    <th style="width: 10%">Price</th>
                    <th style="width: 3%">Qty</th>
                    <th style="width: 15%">Subtotal</th>
                    <th style="width: 15%">Tax Amount</th>
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
                            <td>{!! $op->product_name !!}</td>
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
                    <td colspan="7">
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
                                        <td class="w-112-right">BDT {!! ($total + $totalTax + $order->shipping_charge) !!}/=</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="clear: both;"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endif
@else
    <h4 style="display: block;text-align: center"><strong>404!</strong> Not Found!</h4>
@endif
</body>
</html>
