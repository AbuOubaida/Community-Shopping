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
                                        <th>Invoice ID</th>
                                        <th>Order ID</th>
                                        <th>Admin</th>
{{--                                        <th><span title="Shop Address">Admin Address</span></th>--}}
                                        <th><span title="Shop Phone">Admin Phone</span></th>
                                        <th>Qut.</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Invoice ID</th>
                                        <th>Order ID</th>
                                        <th>Admin</th>
{{--                                        <th><span title="Shop Address">Admin Address</span></th>--}}
                                        <th><span title="Shop Phone">Admin Phone</span></th>
                                        <th>Qut.</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                @if(count(@$adminOrders) > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($adminOrders as $o)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{date('d-M-y',strtotime($o->updated_at))}}</td>
                                            <td>{!! $o->invoice_id !!}</td>
                                            <td>{!! $o->order_id !!}</td>
                                            <td><a target="_blank" href="">{{$o->admin_name}}</a></td>
{{--                                            <td>--}}
{{--                                                <span title="Home: {{$o->admin_home}},Vill: {{$o->admin_village}}, Word: {{$o->admin_word}}, Union: {{$o->admin_union}}, Upazila: {{$o->admin_upazila}}, District: {{$o->admin_district}}, Division: {{$o->admin_division}}, Country: {{$o->admin_country}}">--}}
{{--                                                    {{$o->admin_home}}, {{$o->admin_village}}, {{$o->admin_word}}, {{$o->admin_union}}, {{$o->admin_upazila}}, {{$o->admin_district}}, {{$o->admin_division}}, {{$o->admin_country}}--}}
{{--                                                </span>--}}
{{--                                            </td>--}}
                                            <td>{{$o->admin_phone}}</td>
                                            <td>{{$o->delivery_quantity}}</td>
                                            <td>
                                                @if($o->status_name)
                                                    <span class="badge {!! $o->badge !!}" title="{!! $o->title !!}">{!! $o->status_name !!}</span>
                                                @else
                                                    <span class="badge bg-danger">Unknown</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-block text-center">
                                                    <a href="{{route('admin.to.community.request.view',['orderID'=>encrypt($o->id)])}}" class="text-primary" title="View Order"><i class="fas fa-eye"></i></a>
                                                </div>
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
