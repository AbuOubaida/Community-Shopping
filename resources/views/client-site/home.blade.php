@extends('client-site.main')
@section('content')
<x-client._home_slider /> {{--<header slider section>--}}

<section id="shop2" class="shop shop-4 bg-white pt-0">
    <div class="container">
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                <div class="heading heading-3 mb-30 mt-10 text--center">
                    <p class="heading--subtitle">Discover</p>
                    <h2 class="heading--title mb-0">Latest Dishes</h2>
                    <div class="divider--shape-4"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 shop-filter">
                <ul class="list-inline">
                    <li><a class="active-filter" href="#" data-filter="*">All</a></li>
                    @if(isset($uniques) && count($uniques) > 0)
                        @foreach($uniques as $category)
                            <li><a href="#" data-filter=".filter-{{$category['category_id']}}">{{$category['category_name']}}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
{{--        Latest Dishes start here--}}
        <div id="shop-all" class="row" style="display: flex; flex-wrap: wrap">
    @if(isset($products) && count($products)>0)
        @foreach($products as $p)
            <div class="col-xs-12 col-sm-6 col-md-3 productFilter filter-{{$p->category_id}}">
                <div class="product-item">
                    <div class="product--img">
                        <img class="product-img-list" src="{{url("assets/back-end/vendor/product/").'/'.$p->p_image}}" alt="Product"/>
                        <div class="product--hover">
                            <div class="product--action">
{{--                                <a href="{{route('name.add.to.cart'/*Route Name*/,['PID'=>$p->id])}}">Add To Cart</a>--}}
                                @php
                                    $cart = session()->get('cart')
                                @endphp
                                @if(isset($cart[$p->id]))
                                        <a style="cursor: pointer" href="{{route('view.cart')}}">View Cart</a>
                                @else
                                    <a style="cursor: pointer" onclick="return Product.addToCard(this,'shopping-card')" ref="{{encrypt($p->id)}}">Add To Cart</a>
                                @endif
                            </div>
                        </div>

                        <div class="divider--shape-1down">
                        </div>
                    </div>

                    <div class="product--content">
                        <a href="{{route('client.single.product.view',['productSingleID'=>encrypt($p->id)])}}">
                            <div class="product--title">
                                <span><a href="#"><div class="product--type text--capitalize"><span>{{$p->category_name}}</span></div></a></span>
                                <h3>{{$p->p_name}}</h3>
                                <small>
                                    @if($p->shop_name)
                                        <span>A Product by</span><br>
                                        <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($p->vendor_id)])}}">
                                            <strong class="text-info"><img width="20" height="20" style="border-radius: 20px;" src="{{url($p->v_img_path.$p->v_image)}}" alt="{{\Illuminate\Support\Str::limit($p->p_name,$limit = 1,$end='')}}"> {!! $p->shop_name !!}✔️</strong>
                                        </a>
                                    @else
                                        <span>Vendor Name</span><br>
                                        <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($p->vendor_id)])}}">
                                            <strong class="text-info">
                                                <strong class="vendor-name" style=" @if($p->vendor_id % 2 == 0) {{'background:red'}} @elseif($p->vendor_id % 3 == 0) {{'background: hotpink'}} @elseif($p->vendor_id % 2 == 1) {{'background: lightblue'}} @elseif($p->vendor_id % 3 == 1) {{'background: #a0a0a0'}} @else {{'background: #0d6efd'}} @endif">{{\Illuminate\Support\Str::limit($p->vendor_name,$limit = 1,$end='')}}</strong>
                                                {!! $p->vendor_name !!} <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            </strong>
                                        </a>
                                    @endif
                                </small>
                            </div>
                            @if($p->p_details)
                                <div class="product--type"><span>{{ \Illuminate\Support\Str::limit($p->p_details, $limit = 40, $end = '...')}}</span></div>
                            @else
                                <br><br>
                            @endif
                            <div class="product--price">
                                @if($p->offer_status)
                                    <small class="text-red"><del>BDT {{$p->p_price}}/=</del>
                                        @php
                                            $offer = $p->offer_percentage;
                                            $discount = (($p->p_price * $offer)/100)
                                        @endphp
                                        <span>(-@if($offer <=0 ) 0 @else {{$offer}} @endif%)</span>
                                    </small>
                                    <br>
                                    <br>
                                    <span>BDT {{($p->p_price - $discount)}}/=</span>
                                @else
                                    <br><br>
                                    <span>BDT {{$p->p_price}}/=</span>
                                @endif
                            </div>
                        </a>
                        <br>
{{--                        single product view--}}
                        <div class="product--action">
                            <a href="{{route('client.single.product.view',['productSingleID'=>encrypt($p->id)])}}" class="view-product-btn">View Product</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
{{--        Latest Dishes end here--}}
        </div>
    </div>
</section>

<section id="counter1" class="counter counter-1 bg-overlay bg-overlay-dark bg-parallax">
    <div class="bg-section">
        <img src="{{url("client-site//images/counter/1.jpg")}}" alt="Background" />
    </div>
    <div class="divider--shape-1up"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-3 col-md-3">
                <div class="count-box text-center">
                    <div class="counting">15423</div>
                    <div class="count-title">Clients Served</div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-3 col-md-3">
                <div class="count-box text-center">
                    <div class="counting">165</div>
                    <div class="count-title">Dishes in Menu</div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-3 col-md-3">
                <div class="count-box text-center">
                    <div class="counting">59</div>
                    <div class="count-title">Working Hands</div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-3 col-md-3">
                <div class="count-box text-center">
                    <div class="counting">286</div>
                    <div class="count-title">Positive Reviews</div>
                </div>
            </div>
        </div>

        <div class="divider--shape-1down"></div>
    </div>
</section>

<section id="shop" class="shop shop-4 bg-white">
    <div class="container">
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                <div class="heading heading-3 mb-30 text--center">
                    <p class="heading--subtitle">Don’t miss</p>
                    <h2 class="heading--title mb-0">Product List</h2>
                    <div class="divider--shape-4"></div>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex; flex-wrap: wrap">
{{--            Product List Start Here--}}
            @include('client-site.product._product-list')
{{--            Product List End Here--}}
        </div>
    </div>
</section>
@stop
