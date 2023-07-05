@extends('client-site.main')
@section('content')
<x-client._page_header :pageInfo="$pageInfo" />{{--<header slider section>--}}
<style>
    h1,h2,h3,h4,h5,h6 {
        font-family: raleway,sans-serif!important;
    }
    .shop-product .product-title h3 {
        margin-bottom: 5px;
    }
</style>
{{--product section--}}
<section id="product" class="shop shop-product bg-gray pb-60">
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-sm-4  col-md-4">
                <div class="img-zoom-container">
                    <img id="product-src" class="img-responsive d-inline-block" src="{{url("assets/back-end/vendor/product/").'/'.$product->p_image}}" width="100%" alt="product image">
                </div>
            </div>
            <div class="col-md-1">
                <div id="product-preview" class="product-preview"></div>
            </div>
            <div class="col-xs-7 col-sm-7  col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <h5>Product Info</h5>
                            <div class="product-title">
                                <h3>{{$product->p_name}}</h3>
                                <small>
                                    @if($product->shop_name)
                                        <span>A Product by</span><br>
                                        <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($product->vendor_id)])}}">
                                            <strong class="text-info"><img width="20" height="20" style="border-radius: 20px;" src="{{url($product->v_img_path.$product->v_image)}}" alt="{{\Illuminate\Support\Str::limit($product->p_name,$limit = 1,$end='')}}"> {!! $product->shop_name !!}✔️</strong>
                                        </a>
                                    @else
                                        <span>Vendor Name</span><br>
                                        <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($product->vendor_id)])}}">
                                            <strong class="text-info">
                                                <strong class="vendor-name" style=" @if($product->vendor_id % 2 == 0) {{'background:red'}} @elseif($product->vendor_id % 3 == 0) {{'background: hotpink'}} @elseif($product->vendor_id % 2 == 1) {{'background: lightblue'}} @elseif($product->vendor_id % 3 == 1) {{'background: #a0a0a0'}} @else {{'background: #0d6efd'}} @endif">{{\Illuminate\Support\Str::limit($product->vendor_name,$limit = 1,$end='')}}</strong>
                                                {!! $product->vendor_name !!} <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            </strong>
                                        </a>
                                    @endif
                                </small>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="product-meta mb-30">
                                <div class="product-price pull-left pull-none-xs">
                                    @if($product->offer_status && $product->offer_percentage != null && $product->offer_percentage > 0)
                                        <small class="text-red"><del>BDT {{$product->p_price}}/=</del>
                                            @php
                                                $offer = $product->offer_percentage;
                                                $discount = (($product->p_price * $offer)/100)
                                            @endphp
                                            <span>(-@if($offer <=0 ) 0 @else {{$offer}} @endif%)</span>
                                        </small>
                                        <br>
                                        <br>
                                        <span>BDT {{round($product->p_price - $discount)}}/=</span>
                                    @else
                                        <br><br>
                                        <span>BDT {{$product->p_price}}/=</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="product-action clearfix">
                                <div class="product-cta">
                                    @php
                                        $cart = session()->get('cart')
                                    @endphp
                                    @if(isset($cart[$product->id]))
                                        <a style="cursor: pointer" href="{{route('view.cart')}}" class="btn btn--primary">View Cart</a>
                                    @else
                                        <a style="cursor: pointer" onclick="return Product.addToCard(this,'shopping-card')" ref="{{encrypt($product->id)}}" class="btn btn--primary">Add To Cart</a>
                                    @endif
                                </div>
                            </div>
{{--                            <strong>Product Details</strong>--}}
                            <div class="product-details">
                                <ul class="list-unstyled">
                                    <li>Category : <span>{{$product->category_name}}</span></li>
                                    {{--                        <li>Code : <span>#0214</span></li>--}}
                                    <li>Availabiltity : <span>@if($product->p_status == '1') <span class="text-success">Available</span> @else <span class="text-danger">Unavailable</span>@endif</span></li>
                                    {{--                        <li>Brand : <span>Book</span></li>--}}
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12  col-md-12">
                <hr>
                <h5>Product Details :</h5>
                <div class="product-desc">
                    <p>{{$product->p_details}}</p>
                </div>

            </div>
        </div>
    </div>
</section>
@stop
