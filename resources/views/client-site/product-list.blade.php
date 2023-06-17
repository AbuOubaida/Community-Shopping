@extends('client-site.main')
@section('content')
<x-client._page_header :pageInfo="$pageInfo" />{{--<header slider section>--}}
<section id="shop" class="shop shop-3 bg-gray pb-90">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12  col-md-12">
                        <div class="shop-options">
                            <div class="product-options2 pull-left pull-none-xs">
                                <ul class="list-inline">
                                    <li>
                                        <div class="product-sort mb-15-xs">
                                            <span>Sort by:</span>
                                            <i class="fa fa-angle-down"></i>
                                            <select>
                                                <option selected="" value="Default">Product Name</option>
                                                <option value="Larger">Newest Items</option>
                                                <option value="Larger">oldest Items</option>
                                                <option value="Larger">Hot Items</option>
                                                <option value="Small">Highest Price</option>
                                                <option value="Medium">Lowest Price</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-options2 pull-right pull-none-xs">
                                <ul class="list-inline">
                                    <li>
                                        <div class="product-sort">
                                            <span>Show:</span>
                                            <i class="fa fa-angle-down"></i>
                                            <select>
                                                <option selected="" value="10">10 items / page</option>
                                                <option value="25">25 items / page</option>
                                                <option value="50">50 items / page</option>
                                                <option value="100">100 items / page</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex; flex-wrap: wrap">
                    @include('client-site.product._product-list')
                </div>

            </div>
        </div>
    </div>
</section>
@stop
