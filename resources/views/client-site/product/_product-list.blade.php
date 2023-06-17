    <style>
        .product-item .product--content .product--title h3 {
            margin-bottom: 5px;
        }
    </style>
@if(isset($productLists) && count($productLists)>0)
    @foreach($productLists as $pl)
        <div class="col-xs-12 col-sm-6 col-md-3 productFilter filter-{{$pl->category_name}}">
            <div class="product-item">
                <div class="product--img">
                    <img class="product-img-list" src="{{url("assets/back-end/vendor/product/").'/'.$pl->p_image}}" alt="Product"/>
                    <div class="product--hover">
                        <div class="product--action">

                            @php
                                $cart = session()->get('cart')
                            @endphp
                            @if(isset($cart[$pl->id]))
                                <a style="cursor: pointer" href="{{route('view.cart')}}">View Cart</a>
                            @else
                                <a style="cursor: pointer" onclick="return Product.addToCard(this,'shopping-card')" ref="{{encrypt($pl->id)}}">Add To Cart</a>
                            @endif
                        </div>
                    </div>

                    <div class="divider--shape-1down"></div>
                </div>

                <div class="product--content">
                    <a href="{{route('client.single.product.view',['productSingleID'=>encrypt($pl->id)])}}">

                        <div class="product--title">
                            <span><a href="#"><div class="product--type text--capitalize"><span>{{$pl->category_name}}</span></div></a></span>
                            <h3>{{$pl->p_name}}</h3>
                            <small>
                            @if($pl->shop_name)
                                <span>A Product by</span><br>
                                <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($pl->vendor_id)])}}">
                                    <strong class="text-info"><img width="20" height="20" style="border-radius: 20px;" src="{{url($pl->v_img_path.$pl->v_image)}}" alt="{{\Illuminate\Support\Str::limit($pl->p_name,$limit = 1,$end='')}}"> {!! $pl->shop_name !!}✔️</strong>
                                </a>
                            @else
                                <span>Vendor Name</span><br>
                                <a href="{{route('byVendor.product.list',['vendorId'=>encrypt($pl->vendor_id)])}}">
                                    <strong class="text-info">
                                        <strong class="vendor-name" style=" @if($pl->vendor_id % 2 == 0) {{'background:red'}} @elseif($pl->vendor_id % 3 == 0) {{'background: hotpink'}} @elseif($pl->vendor_id % 2 == 1) {{'background: lightblue'}} @elseif($pl->vendor_id % 3 == 1) {{'background: #a0a0a0'}} @else {{'background: #0d6efd'}} @endif">{{\Illuminate\Support\Str::limit($pl->vendor_name,$limit = 1,$end='')}}</strong>
                                         {!! $pl->vendor_name !!} <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    </strong>
                                </a>
                            @endif
                            </small>
                        </div>
                        @if($pl->p_details)
                            <div class="product--type"><span>{{ \Illuminate\Support\Str::limit($pl->p_details, $limit = 40, $end = '...')}}</span></div>
                        @else
                            <br><br>
                        @endif
                        <div class="product--price">
                            @if($pl->offer_status)
                                <delete>BDT {{$pl->p_price}}/=</delete>
                                @php
                                $offer = $pl->offer_percentage;
                                $discount = (($pl->p_price * $offer)/100)
                                @endphp
                                <span>Discount  {{$discount}}</span>
                                <span>BDT {{($pl->p_price - $discount)}}/=</span>
                            @else
                                <span>BDT {{$pl->p_price}}/=</span>
                            @endif

                        </div>
                    </a>
                    <br>
                    {{--                        single product view--}}
                    <div class="product--action">
                        <a href="{{route('client.single.product.view',['productSingleID'=>encrypt($pl->id)])}}" class="view-product-btn">View Product</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
