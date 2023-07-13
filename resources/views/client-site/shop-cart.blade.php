@extends('client-site.main')
@section('content')
<x-client._page_header :pageInfo="$pageInfo" />{{--<header slider section>--}}
<style>
    h1,h2,h3,h4,h5,h6 {
        font-family: raleway,sans-serif;
    }
    section {
        padding-top: 30px;
    }
</style>
<section id="shopcart" class="shop shop-cart bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5 class="text-center">Your Cart Info</h5>
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="cart-product">
                            <th class="cart-product-item" style="width:40%">Product</th>
                            <th class="cart-product-price" style="width: 13%">Price</th>
                            <th class="cart-product-quantity" style="width: 20%">Quantity</th>
                            <th class="cart-product-total" style="width: 14%">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($total = 0)
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                            <?php
                            $total += $details['price'] * $details['quantity']
                            ?>
                            <tr class="cart-product">
                                <td class="cart-product-item" class="actions" data-th="">
                                    <button class="cart-product-remove" data-id="{{ $id }}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <a href="{{route('client.single.product.view',['productSingleID'=>encrypt($id)])}}" target="_blank">
                                        <div class="cart-product-img">
                                            <img width="100px" src="{{url("assets/back-end/vendor/product/").'/'.$details['photo']}}" alt="product" />
                                        </div>
                                        <div class="cart-product-name">
                                            <strong>{{$details['name']}}</strong>
                                            <br>
                                            <small>Product by {{$details['vendor']}}</small>

                                        </div>
                                    </a>

                                </td>
                                <td class="cart-product-price" data-th="Price">
                                    @if($details['discount'])
                                        <small class="text-red"> (With Discount)</small><br>
                                    @endif
                                    BDT {{$details['price']}} </td>
                                <td class="cart-product-quantity">
                                    <div class="product-quantity" data-th="Quantity">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn-custom btn--secondary update-cart-minus" data-price="{{$details['price']}}" data-id="{{ $id }}">-</button>
                                                <input width="100" readonly value="{{ $details['quantity'] }}" class="quantity" id="pro1-qunt">
                                                <button class="btn-custom btn--secondary update-cart-plus" data-price="{{$details['price']}}" data-id="{{ $id }}">+</button>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="cart-product-total" id="p-{{$id}}"> BDT {{ $details['price'] * $details['quantity'] }}</td>
                            </tr>
                    @endforeach
                @endif
                        <tr class="cart-product-action">
                            <td colspan="4">
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-6 col-md-6">

                                    </div>

                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12  col-md-12">
                <div class="cart-total-amount">

                    <div class="contact-form">
                    @if(session('cart'))

                        @if($user = \Illuminate\Support\Facades\Auth::user())
                            <form action="{{route("order.checkout")}}" method="post">
                                @csrf
                                <div class="row">
                                    @if ($errors->any())
                                        <div class="col-md-12">
                                            <div class="alert alert-danger alert-dismissible show z-index-1 w-auto error-alert right-0" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{$error}}</div>
                                                @endforeach
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    {{--                For Insert message Showing--}}
                                    @if (session('success'))
                                        <div class="col-12">
                                            <div class="alert alert-success alert-dismissible show z-index-1 right-0 w-auto error-alert" role="alert">
                                                <div>{{session('success')}}</div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    {{--                For Insert message Showing--}}
                                    @if (session('error'))
                                        <div class="col-12">
                                            <div class="alert alert-danger alert-dismissible show z-index-1 right-0 w-auto error-alert" role="alert">
                                                <div>{{session('error')}}</div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    @if (session('warning'))
                                        <div class="col-12">
                                            <div class="alert alert-warning alert-dismissible show z-index-1 right-0 w-auto error-alert" role="alert">
                                                <div>{{session('warning')}}</div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <h5>Delivery Information</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_name" id="name" placeholder="Name:" required @if(old('customer_name')) value="{{old('customer_name')}}" @else @isset($user->name) value="{{$user->name}}" @endisset @endif>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" value="@if(old('email')) {{old('email')}} @else @isset($user->email) {{$user->email}} @endisset @endif" placeholder="Email:" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone">Phone <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="phone" id="phone" @if(old('phone')) value="{{old('phone')}}" @else @isset($user->phone) value="{{$user->phone}}" @endisset @endif placeholder="Phone:" required>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="country">Country <span class="text-danger">*</span></label>
                                            <input class="form-control" list="countrylist" name="country" id="country" @if(old('country')) value="{{old('country')}}" @else @isset($user->country) value="{{$user->country}}" @endisset @endif onchange="return Obj.country(this,'divisionlist'), Obj.changeAddress(this,'1','country','division','district','upazila','union')" required>
                                            <datalist id="countrylist">
                                                @foreach($countries as $c)
                                                    <option value="{{$c->nicename}}"></option>
                                                @endforeach
                                            </datalist>

                                        </div>
                                    </div>
                                    {{--                                        Devision--}}
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="division">Division <span class="text-danger">*</span></label>
                                            <input class="form-control" list="divisionlist" name="division" id="division" type="text" placeholder="division" @if(old('division')) value="{{old('division')}}" @else @isset($user->division) value="{{$user->division}}" @endisset @endif onchange=" Obj.division(this,'districtlist'), Obj.changeAddress(this,'2','country','division','district','upazila','union')" required/>
                                            <datalist id="divisionlist">
                                                @if(count($divisions))
                                                    @foreach($divisions as $d)
                                                        <option value="{{$d->name}}"></option>
                                                    @endforeach
                                                @endif
                                            </datalist>

                                        </div>
                                    </div>
                                    {{--                                        Districts--}}
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="district">District <span class="text-danger">*</span></label>
                                            <input class="form-control" list="districtlist" name="district" id="district" type="text" placeholder="district" @if(old('district'))value="{{old('district')}}"@else @isset($user->district) value="{{$user->district}}"@endisset @endif onchange="return Obj.district(this,'upazilalist'), Obj.changeAddress(this,'1','country','division','district','upazila','union')" required/>
                                            <datalist id="districtlist">
                                                @if(count($districts))
                                                    @foreach($districts as $dt)
                                                        <option value="{{$dt->name}}"></option>
                                                    @endforeach
                                                @endif
                                            </datalist>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="upazila">Upazila <span class="text-danger">*</span></label>
                                            <input class="form-control" list="upazilalist" name="upazila" id="upazila" type="text" placeholder="upazila" onchange="return Obj.upazilla(this,'ziplist','unionlist'), Obj.changeAddress(this,'1','country','division','district','upazila','union')" @if(old('upazila')) value="{{old('upazila')}}" @else @isset($user->upazila) value="{{$user->upazila}}" @endisset @endif required/>
                                            <datalist id="upazilalist">
                                                @if(count($upazilas))
                                                    @foreach($upazilas as $u)
                                                        <option value="{{$u->name}}"></option>
                                                    @endforeach
                                                @endif
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="zip_code">Zip Code</label>
                                            <input class="form-control" list="ziplist" name="zip_code" id="zip_code" type="number" placeholder="zip code" @if(old('zip_code')) value="{{old('zip_code')}}" @else @isset($user->zip_code) value="{{$user->zip_code}}" @endisset @endif"/>
                                            <datalist id="ziplist">
                                                @if(count($zip_codes))
                                                    @foreach($zip_codes as $z)
                                                        <option value="{{$z->PostCode}}">{{$z->SubOffice}}</option>
                                                    @endforeach
                                                @endif
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="union">Union</label>
                                            <input class="form-control" list="unionlist" name="union" id="union" type="text" placeholder="union" onchange="Obj.changeAddress(this,'1','country','division','district','upazila','union')" @if(old('union')) value="{{old('union')}}" @else @isset($user->union) value="{{$user->union}}" @endisset @endif/>
                                            <datalist id="unionlist">
                                                @if(count($unions))
                                                    @foreach($unions as $u)
                                                        <option value="{{$u->name}}"></option>
                                                    @endforeach
                                                @endif
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="word_no">Word No</label>
                                            <input class="form-control" name="word_no" id="word_no" type="number" placeholder="word no" onchange="Obj.changeAddress(this,'1','country','division','district','upazila','union')" @if(old('word_no')) value="{{old('word_no')}}" @else @isset($user->word_no) value="{{$user->word_no}}" @endisset @endif"/>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="village">Village</label>
                                            <input class="form-control" name="village" id="village" type="text" placeholder="village" onchange="Obj.changeAddress(this,'1','country','division','district','upazila','union')" @if(old('village')) value="{{old('village')}}" @else @isset($user->village) value="{{$user->village}}" @endisset @endif/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="road">Road No</label>
                                            <input class="form-control" name="road" id="road" type="text" placeholder="e.g. Road no 1" @if(old('road')) value="{{old('road')}}" @endif/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="house">House No</label>
                                            <input class="form-control" name="house" id="house" type="text" placeholder="e.g. House no 110" @if(old('house')) value="{{old('house')}}" @endif/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <label for="extra">Extra Information</label>
                                            <input class="form-control" name="extra" id="extra" type="text" placeholder="e.g. Plot number, Flat number" value="@if(old('extra')) {{old('extra')}} @endif"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="card_total">
                                    @include('layouts.front-end._card_total')
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Please select your payment option</h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="online" title="Online Payment">
                                                    Online Payment
                                                    <input type="radio" id="online" name="payment" value="1" required>
                                                    <img src="{{url("assets/img/online payment icon.png")}}" width="100%" alt="Online Payment">

                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="cash" title="Cash on Delivery">
                                                    Cash on Delivery
                                                    <input type="radio" id="cash" name="payment" value="2" checked required>
                                                    <img src="{{url("assets/img/cash on delivery icon.png")}}" width="100%" alt="Cash On Delivery">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input onclick="return confirm('Your Total order amount is BDT {{($total+$shippingCharge->amount)}}/=. Are you sure to submit this order? Because this step is final step. ')" type="submit" value="Checkout" class="btn btn--primary pull-right">
                                    </div>
                                </div>
                            </form>
                        @else
                        <h3>Order Summary :</h3>
                        <ul class="list-unstyled">
                            <li>Cart Subtotal :<b id="total" class="pull-right text-right" data-total="{{$total}}">BDT {{$total}}/=</b></li>
                            <li>Shipping ( @if($shippingCharge) {{$shippingCharge->location_name}} @endif @if($shippingCharge->location_type == 1) Country @elseif($shippingCharge->location_type == 2) Division @elseif($shippingCharge->location_type == 3) District @elseif($shippingCharge->location_type == 4) upazila @elseif($shippingCharge->location_type == 5) Union @else Unknown @endif {{")"}} :<span class="pull-right text-right">@if($shippingCharge)BDT @if(session('cart')){{$shippingCharge->amount}}@else {{0}}@endif/= @endif</span></li>
                            <li style="background: rebeccapurple;margin-left: -20px;margin-right: -20px;padding: 5px 20px;font-size: 24px;font-weight: bolder;color: cornsilk;"><strong>Order Total :<b style="font-size: 24px;font-weight: bolder;color: cornsilk;" class="pull-right text-right" id="order-total" data-total="@if(session('cart')){{($total+$shippingCharge->amount)}} @else {{0}} @endif">BDT @if(session('cart')){{($total+$shippingCharge->amount)}} @else {{0}} @endif /=</b></strong></li>
                        </ul>
                        <label for="css">Cash on Delivery</label><br>
                            <a href="{{route('order.checkout')}}" class="btn btn--primary">Checkout</a>
                        @endif
                    @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@stop
