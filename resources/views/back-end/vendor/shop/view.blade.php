@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="cover-bg" style="background-image:  url(@if($myshop->shop_cover_image) {{url($myshop->cover_image_path.$myshop->shop_cover_image)}} @else {{url('assets/back-end/vendor/cover/demo.jpg')}} @endif )">
                                </div>
                                <div class="bg-text">
                                    <img src="@if($myshop->shop_profile_image) {{url($myshop->profile_image_path.$myshop->shop_profile_image)}} @else {{url('assets/back-end/vendor/profile/demo.png')}} @endif" alt="">
                                    <h1>{{$myshop->shop_name}}</h1>
                                    <b>{{$myshop->shop_phone}}</b>
                                    <br>
                                    <b>{{$myshop->shop_email}}</b>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h3>Shop Address</h3>
                            </div>
                            <div class="col-md-4 ">
                                <a href="{{route('edit.shop')}}" class="btn btn-primary float-right"><i class="fas fa-edit"></i> Edit Shop</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{--                                        Country--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="country" readonly value="{{$myshop->country}}">
                                    <label for="country">Country</label>
                                </div>
                            </div>
                            {{--                                        Devision--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="division" value="{{$myshop->division}}" />
                                    <label for="division">Division</label>
                                </div>
                            </div>
                            {{--                                        Districts--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="district"  value="{{$myshop->district}}"/>
                                    <label for="district">District</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="upazila" type="text" value="{{$myshop->upazila}}"/>
                                    <label for="upazila">Upazila</label>
                                </div>
                            </div>

                        </div>
                        <div class="row md-3">
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="zip_code" value="{{$myshop->zip_code}}"/>
                                    <label for="zip_code">Zip Code</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="union"readonly value="{{$myshop->union}}"/>
                                    <label for="union">Union</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="word_no" value="{{$myshop->word_no}}"/>
                                    <label for="word_no">Word No.</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="village" value="{{$myshop->village}}"/>
                                    <label for="village">Village</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row md-3">
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="home" value="{{$myshop->home}}"/>
                                    <label for="home">Home No.</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="open" value="{{date('h:i A', strtotime($myshop->open_at))}}"/>
                                    <label for="open">Shop open time</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="close" value="{{date('h:i A',strtotime($myshop->closed_at))}}"/>
                                    <label for="close">Shop close time</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
