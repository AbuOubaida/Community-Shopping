@extends('back-end.superadmin.main')
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
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <form action="{!! route("set.order.status") !!}" method="post">
                                @csrf
                                {!! method_field('post') !!}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="statusName" id="statusName" type="text" placeholder="Enter Status Name" value="{{old('statusName')}}"/>
                                            <label for="statusName">Status Name</label>
                                            <small>e.g. primary, accept, Vendor regional admin etc.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="statusValue" id="statusValue" type="number" placeholder="Enter Status Value" value="{{old('statusValue')}}"/>
                                            <label for="statusValue">Status Value</label>
                                            <small>e.g. 1, 2, 3, 4 etc.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="badge" id="badge">
                                                <option value="0">--Select Option--</option>
                                                <option value="bg-primary">bg-primary</option>
                                                <option value="bg-success">bg-success</option>
                                                <option value="bg-info">bg-info</option>
                                                <option value="bg-warning">bg-warning</option>
                                                <option value="bg-danger">bg-danger</option>
                                            </select>
                                            <label for="badge">Status badge/label/bg-color</label>
                                            <small>
                                                e.g.
                                                <span class="badge bg-primary">bg-primary</span>
                                                <span class="badge bg-success">bg-success</span>
                                                <span class="badge bg-info">bg-info</span>
                                                <span class="badge bg-warning">bg-warning</span>
                                                <span class="badge bg-danger">bg-danger</span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="title" id="title" type="text" placeholder="Enter Status Title" value="{{old('title')}}"/>
                                            <label for="title">Status Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <button type="submit" class="btn btn-outline-success float-end"> <i class="fas fa-plus"></i> Add to list </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        Slider Image show--}}
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Order Status List
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status Name</th>
                                            <th>Status Value</th>
                                            <th>BADGE / BG-Color</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Status Name</th>
                                            <th>Status Value</th>
                                            <th>BADGE / BG-Color</th>
                                            <th>Title</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                @if(count($statuses))
                                    @php
                                    $i=count($statuses);
                                    @endphp
                                    @foreach($statuses as $status)
                                        <tr>
                                            <td>{!! $i-- !!}</td>
                                            <td>{!! $status->status_name !!}</td>
                                            <td>{!! $status->status_value !!}</td>
                                            <td><span class="badge {!! $status->badge !!}">{!! $status->badge !!}</span></td>
                                            <td>{!! $status->title !!}</td>
                                            <td>
                                                <form action="" method="post" class="d-inline-block">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="order_id" value="">
                                                    <button title="Send request to admin" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure to delete this data?')" type="submit"><i class="fas fa-trash"></i></button>
                                                </form>
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
        </div>
    </main>
@stop
