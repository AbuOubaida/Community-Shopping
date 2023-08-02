@extends('back-end.community.main')
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
            <div class="card border-0 rounded-lg">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header text-capitalize">
                            <i class="fas fa-table me-1"></i>
                            Ordered Product Information
                        </div>
                        <div class="card-body">
{{--                            <span>{!! print_r("<pre>"); print_r($singleOrder);print_r("<pre>"); !!}</span>--}}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Requested Date</th>
                                        <th>Requested Day</th>
                                        <th>Invoice ID</th>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                        <th>User</th>
                                        <th>Shop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{date('d-M-y',strtotime($singleOrder->request_time))}}</td>
                                        <td>{{(int)((strtotime(now()) - strtotime($singleOrder->request_time))/86400)}} Days' Past</td>
                                        <td>#{{$singleOrder->invoice_id}}</td>
                                        <td>{{$singleOrder->product_order_id}}</td>
                                        <td>
                                            @if($singleOrder->order_status == 0)
                                                <span class="badge bg-danger">Canceled</span>
                                            @elseif($singleOrder->order_status == 1)
                                                <span class="badge bg-primary">Primary</span>
                                            @elseif($singleOrder->order_status == 2)
                                                <span class="badge bg-info">Accepted</span>
                                            @elseif($singleOrder->order_status == 3)
                                                <span class="badge bg-primary" title="Handed over on vendor site logistic partner">H/O Logistic</span>
                                            @elseif($singleOrder->order_status == 4)
                                                <span class="badge bg-success">Admin Hub</span>
                                            @elseif($singleOrder->order_status == 5)
                                                <span class="badge bg-warning" title="Handed over on your community partner">H/O Community</span>
                                            @elseif($singleOrder->order_status == 6)
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($singleOrder->order_status == 7)
                                                <span class="badge bg-info">Received</span>
                                            @elseif($singleOrder->order_status == 8)
                                                <span class="badge bg-warning">Reviewed</span>
                                            @elseif($singleOrder->order_status == 9)
                                                <span class="badge bg-warning" title="Vendor request to admin">Request to Admin</span>
                                            @elseif($singleOrder->order_status == 10)
                                                <span class="badge bg-info">Admin to Admin</span>
                                            @elseif($singleOrder->order_status == 11)
                                                <span class="badge bg-warning" title="Vendor request to community">Request to community </span>
                                            @elseif($singleOrder->order_status == 12)
                                                <span class="badge bg-info" title="Vendor site community Hub">Vendor community Hub</span>
                                            @else
                                                <span class="badge bg-danger">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{$singleOrder->order_quantity}}</td>
                                        <td>{{$singleOrder->c_name}}</td>
                                        <td>{{$singleOrder->shop_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card-header text-capitalize">
                                Customer Information
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th>Name: </th>
                                        <td>{!! $singleOrder->c_name !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{!! $singleOrder->c_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td>{!! $singleOrder->c_email !!}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Delivery Address: </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{!! $singleOrder->delivery_address !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card-header text-capitalize">
                                Customer Community Info
                            </div>
                            <div class="card-body">
                            @if($singleOrder->d_c_owner_id == \Illuminate\Support\Facades\Auth::user()->id)
                                <table>
                                    <tr>
                                        <th class="text-center" colspan="2"> You are the customer choices community! </th>
                                    </tr>
                                </table>
                            @else
                                <table>
                                    <tr>
                                        <th title="Community Name">Name: </th>
                                        <td>{!! $singleOrder->community_name !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Type: </th>
                                        <td>{!! $singleOrder->community_type !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{!! $singleOrder->community_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td>{!! $singleOrder->community_email !!}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Community Address: </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Home: {{$singleOrder->d_home}}, Vill: {{$singleOrder->d_village}}, Word: {{$singleOrder->d_word}}, Union: {{$singleOrder->d_union}}, Upazila: {{$singleOrder->d_upazila}}, District: {{$singleOrder->d_district}}, Division: {{$singleOrder->d_division}}, Country: {{$singleOrder->d_country}}</td>
                                    </tr>
                                </table>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card-header text-capitalize">
                                Requested Shop Info
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th title="Shop Name">Name: </th>
                                        <td>{!! $singleOrder->shop_name !!}</td>
                                    </tr>
                                    <tr>
                                        <th title="Shop Name">Open: </th>
                                        <td>{{date('h:i a',strtotime($singleOrder->open_at))}} To {{date('h:i a',strtotime($singleOrder->closed_at))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{!! $singleOrder->shop_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td>{!! $singleOrder->shop_email !!}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Shop Address: </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Home: {{$singleOrder->shop_home}}, Vill: {{$singleOrder->shop_vill}}, Word: {{$singleOrder->shop_word}}, Union: {{$singleOrder->shop_union}}, Upazila: {{$singleOrder->shop_upazilla}}, District: {{$singleOrder->shop_dist}}, Division: {{$singleOrder->shop_div}}, Country: {{$singleOrder->shop_country}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{!! route('shop.order.accepted') !!}" method="post">
                        @csrf
                        {{ method_field('put') }}
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input class="form-control" name="qnt" id="qnt" type="number" placeholder="Received Quantity" value="{{old('qnt')}}"/>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" name="ref" value="{!! encrypt($singleOrder->id) !!}">
                                <button class="btn btn-outline-success">Received Order</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </form>
                </div>
                <br>
                <br>
            </div>
        </div>
    </main>
@stop
