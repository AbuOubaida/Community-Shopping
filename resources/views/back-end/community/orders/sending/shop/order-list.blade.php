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
            <div class="row">
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
                                        <th>Shop</th>
                                        <th><span title="Shop Address">Shop Address</span></th>
                                        <th><span title="Shop Phone">Shop Phone</span></th>
                                        <th>Qut.</th>
                                        <th>Status</th>
                                        <th><span title="Shop Open">S. Open</span></th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Shop</th>
                                        <th title="Shop Address">Shop Address</th>
                                        <th><span title="Shop Phone">Shop Phone</span></th>
                                        <th>Qut.</th>
                                        <th>Status</th>
                                        <th title="Shop Open">S. Open</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                @if(count(@$shopOrders) > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($shopOrders as $o)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{date('d-M-y',strtotime($o->request_time))}}</td>
                                            <td><a target="_blank" href="">{{$o->shop_name}}</a></td>
                                            <td>
                                                <span title="Home: {{$o->shop_home}},Vill: {{$o->shop_vill}}, Word: {{$o->shop_word}}, Union: {{$o->shop_union}}, Upazila: {{$o->shop_upazilla}}, District: {{$o->shop_dist}}, Division: {{$o->shop_div}}, Country: {{$o->shop_country}}">
                                                    Home: {{$o->shop_home}},Vill: {{$o->shop_vill}}, Word: {{$o->shop_word}}, Union: {{$o->shop_union}}, Upazila: {{$o->shop_upazilla}}, District: {{$o->shop_dist}}, Division: {{$o->shop_div}}, Country: {{$o->shop_country}}
                                                </span>
                                            </td>
                                            <td>{{$o->shop_phone}}</td>
                                            <td>{{$o->order_quantity}}</td>
                                            <td>
                                                @if($o->status_name)
                                                    <span class="badge {!! $o->badge !!}" title="{!! $o->title !!}">{!! $o->status_name !!}</span>
                                                @else
                                                    <span class="badge bg-danger">Unknown</span>
                                                @endif
                                            </td>
                                            <td>{{date('h:i a',strtotime($o->open_at))}} To {{date('h:i a',strtotime($o->closed_at))}}</td>
                                            <td>
                                                <a href="{{route('community.shop.request.view',['orderID'=>encrypt($o->id)])}}" class="text-primary" title="View Order"><i class="fas fa-eye"></i></a>
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
    </main>
@stop
