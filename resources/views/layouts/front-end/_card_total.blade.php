<div class="row order-summary">
    <div class="col-md-12">
        <h5>Order Summary :</h5>
        <ul class="list-unstyled" >
            <li>Cart Subtotal :<b id="total" class="pull-right text-right" data-total="{{$total}}">BDT {{$total}}/=</b></li>
            <li>Shipping ( @if($shippingCharge) {{$shippingCharge->location_name}} @endif @if($shippingCharge->location_type == 1) Country @elseif($shippingCharge->location_type == 2) Division @elseif($shippingCharge->location_type == 3) District @elseif($shippingCharge->location_type == 4) upazila @elseif($shippingCharge->location_type == 5) Union @else Unknown @endif
                {{")"}} :<b class="pull-right text-right">@if($shippingCharge)BDT {{$shippingCharge->amount}}/= @endif</b></li>
            <li style="background: rebeccapurple;margin-left: -20px;margin-right: -20px;padding: 5px 20px;font-size: 24px;font-weight: bolder;color: cornsilk;"><strong>Order Total :<b style="font-size: 24px;font-weight: bolder;color: cornsilk;" class="pull-right text-right" id="order-total" data-total="{{($total+$shippingCharge->amount)}}">BDT {{($total+$shippingCharge->amount)}}/=</b></strong></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4 style="margin: 0">Select Your Community :</h4>
        <p>Here the community will play a role, who will deliver the product to your address</p>
        <div class="row">
            @if(isset($comm) && count($comm))
                @foreach($comm as $c)
                    <div class="col-md-3">
                        <input type="radio" class="community" id="{{$c->community_name}}" name="community" value="{{$c->id}}" required>
                        <label class="community-class" for="{{$c->community_name}}" title="Online Payment">
                            <div class="community-body">
                                <div class="comm-header">
                                    <span>{{$c->community_name}}</span>
                                    <p class="text-white">
                                        <b>Type: </b>{{$c->community_type}}
                                    </p>
                                </div>
                                <p class="comm-address">
                                    <b>Address:</b> Vill: {{$c->village}}, Word: {{$c->word}}, Union: {{$c->union}}, Upa-Zilla: {{$c->upazila}}, District: {{$c->district}}
                                </p>
                            </div>
                        </label>
                    </div>
                @endforeach
            @else
                <div class="col-md-6">
                    <h6 class="text-red">Sorry! No community found on your location!</h6>
                </div>
            @endif
        </div>
    </div>
</div>
