<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
{{--        Start Dashboard--}}
            @if(Route::currentRouteName() == 'vendor.dashboard')
                <a class="nav-link text-active" href="{{route('vendor.dashboard')}}">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            @else
                <a class="nav-link" href="{{route('vendor.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            @endif
{{--        Dashboard End--}}
{{--        My Shop Start--}}
            @if(Route::currentRouteName() == 'my.shop')
                <a class="nav-link text-active" href="{{route('my.shop')}}">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-user-circle"></i></div>
                    My Shop
                </a>
            @else
                <a class="nav-link" href="{{route('my.shop')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    My Shop
                </a>
            @endif
{{--        My Shop Start--}}
                <div class="sb-sidenav-menu-heading">Interface</div>
{{----------Order Start here--}}
            @if(Route::currentRouteName() == "primary.order.list" || Route::currentRouteName() == "del.order.list" || Route::currentRouteName() == "accepted.order.list")
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
                        @if(Route::currentRouteName() == "primary.order.list" || Route::currentRouteName() == "accepted.order.list")
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
{{--------------------------Primary Order List Start--}}
                            @if(Route::currentRouteName() == "primary.order.list")
                                <a class="nav-link text-active text-capitalize" href="{{route('primary.order.list')}}">Primary list</a>
                            @else
                                <a class="nav-link text-capitalize" href="{{route('primary.order.list')}}">Primary list</a>
                            @endif
{{--                        Primary Order List End--}}
{{--------------------------Accepted Order List Start--}}
                            @if(Route::currentRouteName() == "accepted.order.list")
                                <a class="nav-link text-active text-capitalize" href="{{route('accepted.order.list')}}">Accepted list</a>
                            @else
                                <a class="nav-link text-capitalize" href="{{route('accepted.order.list')}}">Accepted list</a>
                            @endif
{{--                        Accepted Order List End --}}

                                <a class="nav-link" href="{{route('del.order.list')}}">Complete list</a>
                            </nav>
                        </div>
{{--                    Shop Order End Here--}}
{{--------------------- My Order End Here--}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            My Order
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="">New order list</a>
                                <a class="nav-link" href="">Complete order list</a>
                            </nav>
                        </div>
                    </nav>
                </div>
{{--            Order End here--}}
{{--------------user section--}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Product
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{route('vendor.add.product')}}">Add New</a>
                                <a class="nav-link" href="{{route('vendor.list.product')}}">Show List</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Category
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{route('vendor.add.category')}}">Add New</a>
                                <a class="nav-link" href="{{route('vendor.list.category')}}">Show List</a>
                            </nav>
                        </div>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: {!! \Illuminate\Support\Facades\Auth::user()->roles->first()->display_name !!}</div>
            {!! str_replace('_'," ",config("app.name")) !!}
        </div>
    </nav>
</div>
