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
            @if("community.shop.request.list" == Route::currentRouteName() || Route::currentRouteName() == "community.shop.request.view"|| Route::currentRouteName() == "community.accepted.shop.order.list" || Route::currentRouteName() == "community.all.for.customer.acceptance" || Route::currentRouteName() == "community.complete.order.list" || "admin.to.community.request.list" == Route::currentRouteName() || "admin.to.community.request.view" == Route::currentRouteName() || "admin.to.community.accepted.list" == Route::currentRouteName() || "community.to.customer.request.list" == Route::currentRouteName())
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
{{----------------------Shop Order Start Here--}}
                        @if("community.shop.request.list" == Route::currentRouteName() || Route::currentRouteName() == "community.shop.request.view" || Route::currentRouteName() == "community.accepted.shop.order.list" || Route::currentRouteName() == "community.all.for.customer.acceptance" || Route::currentRouteName() == "community.complete.order.list" )
                            <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#shopOrder" aria-expanded="true" aria-controls="shopOrder">
                                Shop Order
                                <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse show" id="shopOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @else
                            <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#shopOrder" aria-expanded="false" aria-controls="shopOrder">
                                Shop Order
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="shopOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @endif
                                <nav class="sb-sidenav-menu-nested nav">
{{--------------------------Request from Shop Order List Start--}}
                                @if(Route::currentRouteName() == "community.shop.request.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.shop.request.list')}}" title="Request from shop order list">Request list</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.shop.request.list')}}" title="Request from shop order list">Request list</a>
                                @endif
{{--                        Request from Shop Order List End--}}
{{--------------------------Request accepted from Shop Order List Start--}}
                                @if(Route::currentRouteName() == "community.accepted.shop.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.accepted.shop.order.list')}}" title="Accepted Order List">Accepted List</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.accepted.shop.order.list')}}" title="Accepted Order List">Accepted List</a>
                                @endif
{{--                        Request accepted from Shop Order List End--}}
{{--------------------------Waiting for customer acceptance List Start--}}
                                @if(Route::currentRouteName() == "community.all.for.customer.acceptance")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.all.for.customer.acceptance')}}" title="Community waiting for customer acceptance">Waiting Acc. List</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.all.for.customer.acceptance')}}" title="Community waiting for customer acceptance">Waiting Acc. List</a>
                                @endif
{{--                        Waiting for customer acceptance List End--}}
{{--------------------------Community complete order list Start--}}
                                @if(Route::currentRouteName() == "community.complete.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.complete.order.list')}}" title="Community complete order list">Completed list</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.complete.order.list')}}" title="Community complete order list">Completed list</a>
                                @endif
{{--                        Community complete order list End--}}
                                @if(Route::currentRouteName() == "community.shop.request.view")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.shop.request.view',['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}" title="Request from Shop">Single Order</a>
                                @endif

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
{{--                    Shop Order End Here--}}
{{--################################################################################################--}}
{{----------------------Admin Order Start Here--}}
                        @if("admin.to.community.request.list" == Route::currentRouteName() || "admin.to.community.request.view" == Route::currentRouteName() || "admin.to.community.accepted.list" == Route::currentRouteName() || "community.to.customer.request.list" == Route::currentRouteName())
                            <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#adminOrder" aria-expanded="true" aria-controls="adminOrder">
                                Admin Order
                                <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse show" id="adminOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @else
                            <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#adminOrder" aria-expanded="false" aria-controls="adminOrder">
                                        Admin Order
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="adminOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        @endif
                                <nav class="sb-sidenav-menu-nested nav">
                                    {{--------------------------Request from admin Order List Start--}}
                                    @if(Route::currentRouteName() == "admin.to.community.request.list")
                                        <a class="nav-link text-active text-capitalize" href="{{route('admin.to.community.request.list')}}" title="Request List from admin">Request List</a>
                                    @else
                                        <a class="nav-link text-capitalize" href="{{route('admin.to.community.request.list')}}" title="Request List from admin">Request List</a>
                                    @endif
                                    {{--                        Request from admin Order List End--}}
                                    {{--------------------------Accepted from admin Order List Start--}}
                                    @if(Route::currentRouteName() == "admin.to.community.accepted.list")
                                        <a class="nav-link text-active text-capitalize" href="{{route('admin.to.community.accepted.list')}}" title="Accepted List from admin">Accepted List</a>
                                    @else
                                        <a class="nav-link text-capitalize" href="{{route('admin.to.community.accepted.list')}}" title="Accepted List from admin">Accepted List</a>
                                    @endif
                                    {{--                        Accepted from admin Order List End--}}
                                    {{------------------Waithing for customer receiving Order List Start--}}
                                    @if(Route::currentRouteName() == "community.to.customer.request.list")
                                        <a class="nav-link text-active text-capitalize" href="{{route('community.to.customer.request.list')}}" title="Wait for customer receiving order list">Wait Customer Receiving</a>
                                    @else
                                        <a class="nav-link text-capitalize" href="{{route('community.to.customer.request.list')}}" title="Wait for customer receiving order list">Wait Customer Receiving</a>
                                    @endif
                                    {{--      Waithing for customer receiving Order List End--}}

                                    {{--------------------------Order view Start--}}
                                    @if(Route::currentRouteName() == "admin.to.community.request.view")
                                        <a class="nav-link text-active text-capitalize" href="{{route("admin.to.community.request.view",['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}">View Order</a>
                                    @endif
                                    {{--                        Order view End --}}
                                    {{--------------------------Order view Start--}}
                                    @if(Route::currentRouteName() == "vendor.view.invoice")
                                        <a class="nav-link text-active text-capitalize" href="{{route("vendor.view.invoice",['invoiceID'=>\Illuminate\Support\Facades\Request::route('invoiceID')])}}">View Invoice</a>
                                    @endif
                                    {{--                        Order view End --}}
                                </nav>
                            </div>
{{--                    Admin Order End Here--}}
{{--------------------- My Order End Here--}}
{{--                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">--}}
{{--                                My Order--}}
{{--                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                            </a>--}}
{{--                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">--}}
{{--                                <nav class="sb-sidenav-menu-nested nav">--}}
{{--                                    @if("community.my.order" == Route::currentRouteName())--}}
{{--                                        <a class="nav-link text-active" href="{{route('community.my.order')}}">My order list</a>--}}
{{--                                    @else--}}
{{--                                        <a class="nav-link" href="{{route('community.my.order')}}">My order list</a>--}}
{{--                                    @endif--}}
{{--                                </nav>--}}
{{--                            </div>--}}
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
