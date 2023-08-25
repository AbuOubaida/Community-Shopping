<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
{{--        Start Dashboard--}}
                @if(Route::currentRouteName() == 'admin.dashboard')
                    <a class="nav-link text-active" href="{{route('admin.dashboard')}}">
                        <div class="sb-nav-link-icon text-active"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                @else
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                @endif
{{--        Dashboard End--}}
                <div class="sb-sidenav-menu-heading">Interface</div>
{{--        user section--}}
            @if(Route::currentRouteName() == 'admin.add.user' || Route::currentRouteName() == 'admin.list.user')
                <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#userLayouts" aria-expanded="false" aria-controls="userLayouts">
                    <div class="sb-nav-link-icon text-active"><i class="fa-solid fa-user"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse show" id="userLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @else
                <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#userLayouts" aria-expanded="false" aria-controls="userLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="userLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @endif
                    <nav class="sb-sidenav-menu-nested nav">
                    @if(Route::currentRouteName() == 'admin.add.user')
                        <a class="nav-link text-active" href="{{route('admin.add.user')}}">Add New</a>
                    @else
                        <a class="nav-link" href="{{route('admin.add.user')}}">Add New</a>
                    @endif
                    @if(Route::currentRouteName() == 'admin.list.user')
                        <a class="nav-link text-active" href="{{route('admin.list.user')}}">Show List</a>
                    @else
                        <a class="nav-link" href="{{route('admin.list.user')}}">Show List</a>
                    @endif
                    </nav>
                </div>
{{--        user section end--}}
            @if(Route::currentRouteName() == "admin.shop.order.list" || Route::currentRouteName() == "admin.shop.order.view" || Route::currentRouteName() == "admin.to.admin.order.list" || Route::currentRouteName() == "admin.to.admin.order.view" || Route::currentRouteName() == "community.to.admin.order.list" || Route::currentRouteName() == "community.to.admin.order.view" || Route::currentRouteName() == 'all.order.list' || Route::currentRouteName() == 'order.view')
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
{{----------------------All Order Start Here--}}
                    <nav class="sb-sidenav-menu-nested nav">
                    @if(Route::currentRouteName() == 'all.order.list' || Route::currentRouteName() == 'order.view')
                        <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#allOrder" aria-expanded="true" aria-controls="allOrder">
                            All Orders
                            <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="allOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @else
                        <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#allOrder" aria-expanded="false" aria-controls="allOrder">
                            All Orders
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="allOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @endif
                            <nav class="sb-sidenav-menu-nested nav">
                                {{--------------------------All order list Start--}}
                                @if(Route::currentRouteName() == 'all.order.list')
                                    <a class="nav-link text-active text-capitalize" href="{{route('all.order.list')}}" title="All Order List">All List</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('all.order.list')}}" title="All Order List">All List</a>
                                @endif
                                {{--                    All order list End--}}
                                {{--------------------------Order view Start--}}
                                @if(Route::currentRouteName() == "order.view")
                                    <a class="nav-link text-active text-capitalize" href="{{route('order.view',['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}" title="Order view">View Order</a>
                                @endif
                                {{--                        Order view End--}}
                            </nav>
                        </div>
                    </nav>
{{----------------------All Order End Here--}}
{{--###################################################################################################--}}
{{----------------------Admin Order Start Here--}}
                    <nav class="sb-sidenav-menu-nested nav">
                    @if(Route::currentRouteName() == "admin.to.admin.order.list" || Route::currentRouteName() == "admin.to.admin.order.view" )
                        <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#adminOrder" aria-expanded="true" aria-controls="adminOrder">
                            Admin Order
                            <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="adminOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @else
                        <a class="nav-link collapsed text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#adminOrder" aria-expanded="false" aria-controls="communityOrder">
                            Admin Order
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="adminOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @endif
                            <nav class="sb-sidenav-menu-nested nav">
                                {{--------------------------admin Order List Start--}}
                                @if(Route::currentRouteName() == "admin.to.admin.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('admin.to.admin.order.list')}}" title="Shop order list">All list</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('admin.to.admin.order.list')}}" title="Shop order list">All list</a>
                                @endif
                                {{--                    admin Order List End--}}
                                {{--------------------------Admin Order View Start--}}
                                @if(Route::currentRouteName() == "admin.to.admin.order.view")
                                    <a class="nav-link text-active text-capitalize" href="{{route('admin.to.admin.order.view',['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}" title="Shop order view">View Order</a>
                                @endif
{{--                        admin Order View End--}}
                            </nav>
                    </nav>
                    <nav class="sb-sidenav-menu-nested nav">
{{----------------------Shop Order Start Here--}}
                    @if(Route::currentRouteName() == "admin.shop.order.list" || Route::currentRouteName() == "admin.shop.order.view" )
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
{{--------------------------Shop Order List Start--}}
                            @if(Route::currentRouteName() == "admin.shop.order.list")
                                <a class="nav-link text-active text-capitalize" href="{{route('admin.shop.order.list')}}" title="Shop order list">All list</a>
                            @else
                                <a class="nav-link text-capitalize" href="{{route('admin.shop.order.list')}}" title="Shop order list">All list</a>
                            @endif
    {{--                    Shop Order List End--}}
    {{--------------------------Shop Order View Start--}}
                            @if(Route::currentRouteName() == "admin.shop.order.view")
                                <a class="nav-link text-active text-capitalize" href="{{route('admin.shop.order.view',['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}" title="Shop order view">View Order</a>
                            @endif
{{--                        Shop Order View End--}}
                            </nav>
                        </div>
                    </nav>

                    <nav class="sb-sidenav-menu-nested nav">
{{----------------------Community Order Start Here--}}
                    @if(Route::currentRouteName() == "community.to.admin.order.list" || Route::currentRouteName() == "community.to.admin.order.view")
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
                                {{--------------------------Community Order List Start--}}
                                @if(Route::currentRouteName() == "community.to.admin.order.list")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.to.admin.order.list')}}" title="Community order list">All list</a>
                                @else
                                    <a class="nav-link text-capitalize" href="{{route('community.to.admin.order.list')}}" title="Community order list">All list</a>
                                @endif
                                {{--                    Community Order List End--}}
                                {{--------------------------Community Order View Start--}}
                                @if(Route::currentRouteName() == "community.to.admin.order.view")
                                    <a class="nav-link text-active text-capitalize" href="{{route('community.to.admin.order.view',['orderID'=>\Illuminate\Support\Facades\Request::route('orderID')])}}" title="Community order view">View Order</a>
                                @endif
                                {{--                        Community Order View End--}}
                            </nav>
                        </div>
                    </nav>
                </div>
{{--                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">--}}
{{--                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>--}}
{{--                    Layouts--}}
{{--                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">--}}
{{--                    <nav class="sb-sidenav-menu-nested nav">--}}
{{--                        <a class="nav-link" href="layout-static.html">Static Navigation</a>--}}
{{--                        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">--}}
{{--                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>--}}
{{--                    Pages--}}
{{--                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">--}}
{{--                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">--}}
{{--                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">--}}
{{--                            Authentication--}}
{{--                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                        </a>--}}
{{--                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">--}}
{{--                            <nav class="sb-sidenav-menu-nested nav">--}}
{{--                                <a class="nav-link" href="login.html">Login</a>--}}
{{--                                <a class="nav-link" href="register.html">Register</a>--}}
{{--                                <a class="nav-link" href="password.html">Forgot Password</a>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
{{--                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">--}}
{{--                            Error--}}
{{--                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                        </a>--}}
{{--                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">--}}
{{--                            <nav class="sb-sidenav-menu-nested nav">--}}
{{--                                <a class="nav-link" href="401.html">401 Page</a>--}}
{{--                                <a class="nav-link" href="404.html">404 Page</a>--}}
{{--                                <a class="nav-link" href="500.html">500 Page</a>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--                <div class="sb-sidenav-menu-heading">Addons</div>--}}
{{--                <a class="nav-link" href="charts.html">--}}
{{--                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>--}}
{{--                    Charts--}}
{{--                </a>--}}
{{--                <a class="nav-link" href="tables.html">--}}
{{--                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>--}}
{{--                    Tables--}}
{{--                </a>--}}
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
