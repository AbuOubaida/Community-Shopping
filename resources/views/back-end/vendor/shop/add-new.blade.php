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
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <i class='fas fa-exclamation-triangle' style='color:red'></i>
                                You are not eligible for the next step without fulfilling this information.
                            </div>
                            <form method="POST" action="{{route('create.shop')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="shop_name" id="shop_name" type="text" placeholder="Enter your shop name" value="{{old('shop_name')}}"/>
                                            <label for="shop_name">Shop name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="shop_phone" id="shop_phone" type="text" placeholder="Enter your shop phone" value="{{old('shop_phone')}}"/>
                                            <label for="shop_phone">Shop phone <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="shop_email" id="shop_email" type="text" placeholder="Enter your shop email" value="{{old('shop_email')}}"/>
                                            <label for="shop_email">Shop Email </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    {{--                                        Country--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="countrylist" name="country" id="country" value="{{old('country')}}" onchange="return Obj.country(this,'divisionlist')">
                                            <datalist id="countrylist">
                                                @foreach($countries as $c)
                                                    <option value="{{$c->nicename}}"></option>
                                                @endforeach
                                            </datalist>
                                            <label for="country">Country<b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    {{--                                        Devision--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="divisionlist" name="division" id="division" type="text" placeholder="division" value="{{old('division')}}" onchange="return Obj.division(this,'districtlist')"/>
                                            <datalist id="divisionlist">
                                                <option></option>
                                            </datalist>
                                            <label for="division">Division<b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    {{--                                        Districts--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="districtlist" name="district" id="district" type="text" placeholder="district" value="{{old('district')}}" onchange="return Obj.district(this,'upazilalist')"/>
                                            <datalist id="districtlist">
                                                <option></option>
                                                <option>Sadar</option>
                                            </datalist>
                                            <label for="district">District<b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="upazilalist" name="upazila" id="upazila" type="text" placeholder="upazila" onchange="return Obj.upazilla(this,'ziplist','unionlist')" value="{{old('upazila')}}"/>
                                            <datalist id="upazilalist">
                                                <option></option>
                                            </datalist>
                                            <label for="upazila">Upazila<b class="text-danger">*</b></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row md-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="ziplist" name="zip_code" id="zip_code" type="number" placeholder="zip code" value="{{old('zip_code')}}"/>
                                            <datalist id="ziplist">
                                                <option></option>
                                            </datalist>
                                            <label for="zip_code">Zip Code<b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="unionlist" name="union" id="union" type="text" placeholder="union" value="{{old('union')}}"/>
                                            <datalist id="unionlist">
                                                <option></option>
                                            </datalist>
                                            <label for="union">Union</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="word_no" id="word_no" type="number" placeholder="word no" value="{{old('word_no')}}"/>
                                            <label for="word_no">Word No.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="village" id="village" type="text" placeholder="village" value="{{old('village')}}"/>
                                            <label for="village">Village</label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row md-3">
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="home" id="home" type="number" placeholder="home" value="{{old('home')}}"/>
                                            <label for="home">Home No.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="open" id="open" type="time" placeholder="Shop open time" value="{{old('open')}}"/>
                                            <label for="open">Shop open time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="close" id="close" type="time" placeholder="Shop close time" value="{{old('close')}}"/>
                                            <label for="close">Shop close time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" onchange="return Obj.priview(this,'previewProfile')" name="profile" id="profile" type="file" placeholder="Shop profile image" value="{{old('profile')}}"/>
                                            <label for="profile">Shop profile image</label>
                                            <img src="" id="previewProfile" class="img-rounded" width="100%">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" onchange="return Obj.priview(this,'previewCover')" name="cover" id="cover" type="file" placeholder="Shop cover image" value="{{old('cover')}}"/>
                                            <label for="cover">Shop cover image</label>
                                            <img src="" id="previewCover" class="img-rounded" width="100%">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Create Shop"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
