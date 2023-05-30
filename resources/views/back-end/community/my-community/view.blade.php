@extends('back-end.community.main')
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
                                <div class="cover-bg" style="background-image:  url(@if($myCommunity->community_cover_image) {{url($myCommunity->cover_image_path.$myCommunity->community_cover_image)}} @else {{url('assets/back-end/vendor/cover/demo.jpg')}} @endif )">
                                </div>
                                <div class="bg-text">
                                    <img src="@if($myCommunity->shop_profile_image) {{url($myCommunity->profile_image_path.$myCommunity->shop_profile_image)}} @else {{url('assets/back-end/community/profile/my-community-profile.png')}} @endif" alt="">
                                    <h1>{{$myCommunity->community_name}}</h1>
                                    <b>{{$myCommunity->community_phone}}</b>
                                    <br>
                                    <b>{{$myCommunity->community_email}}</b>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h3>Shop Address</h3>
                            </div>
                            <div class="col-md-4 ">
                                <a href="{{route('edit.community')}}" class="btn btn-primary float-right"><i class="fas fa-edit"></i> Edit Community</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{--                                        Country--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="country" readonly value="{{$myCommunity->country}}">
                                    <label for="country">Country</label>
                                </div>
                            </div>
                            {{--                                        Devision--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="division" value="{{$myCommunity->division}}" />
                                    <label for="division">Division</label>
                                </div>
                            </div>
                            {{--                                        Districts--}}
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="district"  value="{{$myCommunity->district}}"/>
                                    <label for="district">District</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="upazila" type="text" value="{{$myCommunity->upazila}}"/>
                                    <label for="upazila">Upazila</label>
                                </div>
                            </div>

                        </div>
                        <div class="row md-3">
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="zip_code" value="{{$myCommunity->zip_code}}"/>
                                    <label for="zip_code">Zip Code</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="union"readonly value="{{$myCommunity->union}}"/>
                                    <label for="union">Union</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="word_no" value="{{$myCommunity->word}}"/>
                                    <label for="word_no">Word No.</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="village" value="{{$myCommunity->village}}"/>
                                    <label for="village">Village</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row md-3">
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="home" value="{{$myCommunity->home}}"/>
                                    <label for="home">Home No.</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="open" value="{{$myCommunity->community_type}}"/>
                                    <label for="open">Community Type</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" readonly id="close" value="@if($myCommunity->status == 1) {{"Active"}} @elseif($myCommunity->status == 2) {{"Incomplete"}} @elseif($myCommunity->status == 5) {{"Inactive"}} @endif"/>
                                    <label for="close">Community Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
