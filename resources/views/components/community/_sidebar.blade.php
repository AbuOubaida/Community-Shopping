<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
            @if("community.dashboard" == Route::currentRouteName() )
                <a class="nav-link text-active" href="{{route('community.dashboard')}}">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            @else
                <a class="nav-link" href="{{route('community.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            @endif
            @if("my.community" == Route::currentRouteName() )
                <a class="nav-link text-active" href="{{route('my.community')}}">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-people-group"></i></div>
                    Community Profile
                </a>
            @else
                <a class="nav-link" href="{{route('my.community')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-people-group"></i></div>
                    Community Profile
                </a>
            @endif
                <div class="sb-sidenav-menu-heading">Interface</div>
            @if("community.shop.order.list" == Route::currentRouteName())
                <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#orderLayouts" aria-expanded="true" aria-controls="orderLayouts">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-columns"></i></div>
                    Order
                    <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse show" id="orderLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @else
                <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#orderLayouts" aria-expanded="false" aria-controls="orderLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Order
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="orderLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @endif
                    <nav class="sb-sidenav-menu-nested nav">
{{----------------------Community Order Start Here--}}
                        @if("community.shop.order.list" == Route::currentRouteName())
                            <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#communityOrder" aria-expanded="true" aria-controls="communityOrder">
                                Community Order
                                <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse show" id="communityOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @else
                            <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#communityOrder" aria-expanded="false" aria-controls="communityOrder">
                                Community Order
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="communityOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @endif
                                <nav class="sb-sidenav-menu-nested nav">
{{--------------------------Request from Shop Order List Start--}}
                                @if(Route::currentRouteName() == "community.shop.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.shop.order.list')}}" title="Request from Shop">Shop Request.</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.shop.order.list')}}" title="Request from Shop">Shop Request</a>
                                @endif
{{--                        Request from Shop Order List End--}}
{{--------------------------Request from admin Order List Start--}}
                                @if(Route::currentRouteName() == "primary.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('primary.order.list')}}" title="Request from admin">Admin Request</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('primary.order.list')}}" title="Request from admin">Admin Request</a>
                                @endif
{{--                        Request from admin Order List End--}}

{{--------------------------Cancled Order List Start--}}
                                @if(Route::currentRouteName() == "cancel.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('cancel.order.list')}}">Canceled list</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('cancel.order.list')}}">Canceled list</a>
                                @endif
{{--                        Cancled Order List End --}}
{{--------------------------Order view Start--}}
                                @if(Route::currentRouteName() == "vendor.view.order")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.view.order",['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}">View Order</a>
                                @endif
{{--                        Order view End --}}
{{--------------------------Order view Start--}}
                                @if(Route::currentRouteName() == "vendor.view.invoice")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.view.invoice",['invoiceID'=>\Illuminate\Support\Facades\Request::route('invoiceID')])}}">View Invoice</a>
                                @endif
{{--                        Order view End --}}
                                </nav>
                            </div>
{{--                    Community Order End Here--}}
                                        {{--------------------- My Order End Here--}}
                                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                            My Order
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                @if("community.my.order" == Route::currentRouteName())
                                                    <a class="nav-link text-active" href="{{route('community.my.order')}}">My order list</a>
                                                @else
                                                    <a class="nav-link" href="{{route('community.my.order')}}">My order list</a>
                                                @endif
                                            </nav>
                                        </div>
                        </nav>
                    </div>
{{--            Order End here--}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">
                Welcome @if(\Illuminate\Support\Facades\Auth::user()->gender == 1) {{"Mr. "}} @elseif(\Illuminate\Support\Facades\Auth::user()->gender == 2) {{"Ms. "}}@else  @endif
                {!! \Illuminate\Support\Facades\Auth::user()->name !!}
            </div>
            <div class="small">Logged in as: {!! \Illuminate\Support\Facades\Auth::user()->roles->first()->display_name !!}</div>
        </div>
    </nav>
</div>
