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
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="pname" type="text" placeholder="Enter your product name" value="{{$product->p_name}}" readonly/>
                                            <label for="pname">Product name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="price" type="number" placeholder="Enter your product price" value="{{$product->p_price}}" readonly/>
                                            <label for="pname">Product Price <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="p_quantity" type="number" placeholder="Enter your product quantity" value="{{$product->p_quantity}}" readonly/>
                                            <label for="p_quantity">Product Quantity <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea class="form-control" id="p_details" type="text" placeholder="Enter your product details" cols="10" rows="10" readonly>{{$product->p_details}}</textarea>
                                            <label for="p_details">Product Details</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" id="p_category" readonly disabled="true">
                                                @if(count($categories) > 0)
                                                    @foreach($categories as $c)
                                                        <option value="{{$c->id}}" @if($product->creater_id == $c->id) selected @endif>{{$c->c_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="p_category">Product Category <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" id="p_status" readonly disabled="true">
                                                <option value="1" @if($product->p_status == '1') selected @endif>Active</option>
                                                <option value="0" @if($product->p_status == '0') selected @endif>Inactive</option>
                                            </select>
                                            <label for="p_status">Product Status <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" id="o_status" readonly disabled="true">
                                                <option value="0" @if($product->offer_status == '0') selected @endif>Unavailable</option>
                                                <option value="1" @if($product->offer_status  == '1') selected @endif>Available</option>
                                            </select>
                                            <label for="o_status">Offer Status <b class="text-danger">*</b></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0 text-center">
                                            <img src="{{url('assets/back-end/vendor/product/').'/'.$product->p_image}}" alt="product Image" width="50%" class="tabel-image"><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row md-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="offer_percentage" type="number" placeholder="e.x. 0% to 100%" value="{{$product->offer_percentage}}" readonly/>
                                            <label for="p_quantity">Offer Percentage [1% to 99%]</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="offer_quantity" type="number" placeholder="Product offer quantity" value="{{$product->offer_quantity}}" readonly/>
                                            <label for="p_quantity">Offer Quantity</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="offer_start_time" type="datetime-local" placeholder="Product offer start date" value="{{$product->offer_start_time}}" readonly/>
                                            <label for="p_quantity">Offer Start Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="offer_end_time" type="datetime-local" placeholder="Product offer end date" value="{{$product->offer_end_time}}" readonly/>
                                            <label for="p_quantity">Offer End Date</label>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
