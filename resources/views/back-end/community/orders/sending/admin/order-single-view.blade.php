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
                                        <th>Order Quantity</th>
                                        <th>Received Quantity</th>
                                        <th>User</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{date('d-M-y',strtotime($singleOrder->updated_at))}}</td>
                                        <td>{{(int)((strtotime(now()) - strtotime($singleOrder->updated_at))/86400)}} Days' Past</td>
                                        <td>#{{$singleOrder->invoice_id}}</td>
                                        <td>{{$singleOrder->order_id}}</td>
                                        <td>
                                            @if($singleOrder->status_name)
                                                <span class="badge {!! $singleOrder->badge !!}" title="{!! $singleOrder->title !!}">{!! $singleOrder->status_name !!}</span>
                                            @else
                                                <span class="badge bg-danger">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{$singleOrder->order_quantity}}</td>
                                        <td>@if($singleOrder->delivery_quantity) {{$singleOrder->delivery_quantity}} @else 0 @endif</td>
                                        <td>{{$singleOrder->c_name}}</td>
                                        <td>{{$singleOrder->admin_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card-header text-capitalize">
                                Admin Info
                            </div>
                            <div class="card-body text-justify">
                                <table>
                                    <tr>
                                        <th title="Community Name">Name: </th>
                                        <td>{!! $singleOrder->admin_name !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone: </th>
                                        <td>{!! $singleOrder->admin_phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Admin Address: </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Home: {{$singleOrder->admin_home}}, Vill: {{$singleOrder->admin_village}}, Word: {{$singleOrder->admin_word}}, Union: {{$singleOrder->admin_union}}, Upazila: {{$singleOrder->admin_upazila}}, District: {{$singleOrder->admin_district}}, Division: {{$singleOrder->d_division}}, Country: {{$singleOrder->admin_country}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
{{--        //5=Received delivery community --}}
            @if($singleOrder->order_status == 5)
                <div class="row">
                    <div class="col-md-12">
                        <form action="{!! route('delivery.direct.customer') !!}" method="post">
                            @csrf
                            {{ method_field('put') }}
                            <input type="hidden" name="ref" value="{!! encrypt($singleOrder->id) !!}">
                            <button class="btn btn-outline-success float-end" type="submit" onclick="return confirm('Are you sure!')"><i class="fas fa-check"></i> Send Delivery Request to Customer</button>
                        </form>
                    </div>
                </div>
            @elseif($singleOrder->order_status == 4)
                <div class="row">
                    <div class="col-md-12">
                        <form action="{!! route('community.accepted.order.from.admin') !!}" method="post">
                            @csrf
                            {{ method_field('put') }}
                            <input type="hidden" name="ref" value="{!! encrypt($singleOrder->id) !!}">
                            <button class="btn btn-outline-success float-end" type="submit" onclick="return confirm('Are you sure to accept this order from admin!')"><i class="fas fa-check"></i> Accept Order</button>
                        </form>
                    </div>
                </div>
            @endif
                </div>
                <br>
                <br>
            </div>
        </div>
    </main>
@stop
