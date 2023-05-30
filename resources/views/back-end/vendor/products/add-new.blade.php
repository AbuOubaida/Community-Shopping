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
                    <div class="card border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form method="POST" action="{{ route('vendor.add.product') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="pname" id="pname" type="text" placeholder="Enter your product name" value="{{old('pname')}}" required/>
                                            <label for="pname">Product name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="price" id="price" type="number" placeholder="Enter your product price" value="{{old('price')}}" required/>
                                            <label for="pname">Product Price <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="p_quantity" id="p_quantity" type="number" placeholder="Enter your product quantity" value="{{old('p_quantity')}}" required/>
                                            <label for="p_quantity">Product Quantity <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea class="form-control" name="p_details" id="p_details" type="text" placeholder="Enter your product details" cols="10" rows="10">{{old('p_details')}}</textarea>
                                            <label for="p_details">Product Details</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="p_category" id="p_category">
                                                <option></option>
                                        @if(count($categories) > 0)
                                            @foreach($categories as $c)
                                                <option value="{{$c->id}}" @if(old('p_category') == $c->id) selected @endif>{{$c->c_name}}</option>
                                            @endforeach
                                        @endif
                                            </select>
                                            <label for="p_category">Product Category <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="p_status" id="p_status">
                                                <option></option>
                                                <option value="1" @if(old('p_status') == '1') selected @endif>Active</option>
                                                <option value="0" @if(old('p_status') == '0') selected @endif>Inactive</option>
                                            </select>
                                            <label for="p_status">Product Status <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="o_status" id="o_status">
                                                <option value="0" @if(old('o_status') == '0') selected @endif>Unavailable</option>
                                                <option value="1" @if(old('o_status') == '1') selected @endif>Available</option>
                                            </select>
                                            <label for="o_status">Offer Status <b class="text-danger">*</b></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="p_image" id="p_image" type="file" placeholder="Product image" />
                                            <label for="p_image">Product Image</label>
                                            <input type="checkbox" name="is_slider" value="1"> <b class="text-info">Is show on slider?</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-info"><b >Note:</b> If product offer status in available then please fill-up all field below</span>
                                    </div>
                                </div>
                                <div class="row md-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="offer_percentage" id="offer_percentage" type="number" placeholder="e.x. 0% to 100%" value="{{old('offer_percentage')}}"/>
                                            <label for="p_quantity">Offer Percentage [1% to 99%]</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="offer_quantity" id="offer_quantity" type="number" placeholder="Product offer quantity" value="{{old('offer_quantity')}}"/>
                                            <label for="p_quantity">Offer Quantity</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="offer_start_time" id="offer_start_time" type="datetime-local" placeholder="Product offer start date" value="{{old('offer_start_time')}}"/>
                                            <label for="p_quantity">Offer Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="offer_end_time" id="offer_end_time" type="datetime-local" placeholder="Product offer end date" value="{{old('offer_end_time')}}"/>
                                            <label for="p_quantity">Offer End Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0 float-end">
                                    <input class="btn btn-primary" type="submit" value="Create Product">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
