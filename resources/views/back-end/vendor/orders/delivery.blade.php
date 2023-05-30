@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form method="POST" action="{{ route('update.order') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="oid" type="text"  value="{{$order->order_id}}" readonly/>
                                            <label for="oid">Order ID </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="oid" value="{{$order->id}}">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="del" id="del">
                                        @isset($deliveryPerson)
                                            @foreach($deliveryPerson  as $d)
                                                <option value="{{$d->user_id}}">{{$d->delivery_p_n}}</option>
                                            @endforeach
                                        @endisset
                                            </select>
                                            <label for="del"> Delivery person selection</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Delivered"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
