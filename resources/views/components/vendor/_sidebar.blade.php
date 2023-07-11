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
            @if(Route::currentRouteName() == "primary.order.list" || Route::currentRouteName() == "accepted.order.list" || Route::currentRouteName() == "cancel.order.list" || Route::currentRouteName() == "vendor.view.order" || Route::currentRouteName() == "vendor.view.invoice" || Route::currentRouteName() == "vendor.complete.order.list")
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
                    @if(Route::currentRouteName() == "primary.order.list" || Route::currentRouteName() == "accepted.order.list"||Route::currentRouteName() == "cancel.order.list" || Route::currentRouteName() == "vendor.view.order" || Route::currentRouteName() == "vendor.view.invoice" || Route::currentRouteName() == "vendor.complete.order.list")
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
{{--------------------------Compplete Order List Start--}}
                            @if(Route::currentRouteName() == "vendor.complete.order.list")
                                <a class="nav-link text-active text-capitalize" href="{!! route('vendor.complete.order.list') !!}">Completed list</a>
                            @else
                                <a class="nav-link text-capitalize" href="{!! route('vendor.complete.order.list') !!}">Completed list</a>
                            @endif
{{--                        Compplete Order List End --}}
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
{{--------------Product section start--}}
            @if(Route::currentRouteName() == "vendor.add.product" || Route::currentRouteName() == "vendor.list.product" || Route::currentRouteName() == "vendor.add.category" || Route::currentRouteName() == "vendor.list.category" || Route::currentRouteName() == "vendor.view.category" || Route::currentRouteName() == "vendor.edit.category" || Route::currentRouteName() == "vendor.view.product" || Route::currentRouteName() == "vendor.edit.product")
                <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#productPagesLayout" aria-expanded="true" aria-controls="productPagesLayout">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-book-open"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse show" id="productPagesLayout" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            @else
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            @endif
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    @if(Route::currentRouteName() == "vendor.add.product" || Route::currentRouteName() == "vendor.list.product" || Route::currentRouteName() == "vendor.view.product" || Route::currentRouteName() == "vendor.edit.product")
                        <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#productPages" aria-expanded="true" aria-controls="productPages">
                            Product
                            <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="productPages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @else
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#productPages" aria-expanded="false" aria-controls="productPages">
                            Product
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="productPages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @endif
                            <nav class="sb-sidenav-menu-nested nav">
                                @if(Route::currentRouteName() == "vendor.add.product")
                                <a class="nav-link text-active" href="{{route('vendor.add.product')}}">Add New</a>
                                @else
                                <a class="nav-link" href="{{route('vendor.add.product')}}">Add New</a>
                                @endif

                                @if(Route::currentRouteName() == "vendor.list.product")
                                <a class="nav-link text-active" href="{{route('vendor.list.product')}}">Show List</a>
                                @else
                                <a class="nav-link" href="{{route('vendor.list.product')}}">Show List</a>
                                @endif

                                @if(Route::currentRouteName() == "vendor.view.product")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.view.product",['productID'=>\Illuminate\Support\Facades\Request::route('productID')])}}">View Product</a>
                                @endif
                                @if(Route::currentRouteName() == "vendor.edit.product")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.edit.product",['productID'=>\Illuminate\Support\Facades\Request::route('productID')])}}">Edit Product</a>
                                @endif
                            </nav>
                        </div>
                    @if(Route::currentRouteName() == "vendor.add.category" || Route::currentRouteName() == "vendor.list.category" || Route::currentRouteName() == "vendor.view.category" || Route::currentRouteName() == "vendor.edit.category")
                        <a class="nav-link text-active text-capitalize" href="#" data-bs-toggle="collapse" data-bs-target="#categoryPages" aria-expanded="true" aria-controls="categoryPages">
                            Category
                            <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="categoryPages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @else
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#categoryPages" aria-expanded="false" aria-controls="categoryPages">
                            Category
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="categoryPages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    @endif
                            <nav class="sb-sidenav-menu-nested nav">
                                @if(Route::currentRouteName() == "vendor.add.category")
                                    <a class="nav-link text-active" href="{{route('vendor.add.category')}}">Add New</a>
                                @else
                                    <a class="nav-link" href="{{route('vendor.add.category')}}">Add New</a>
                                @endif

                                @if(Route::currentRouteName() == "vendor.list.category")
                                    <a class="nav-link text-active" href="{{route('vendor.list.category')}}">Show List</a>
                                @else
                                    <a class="nav-link" href="{{route('vendor.list.category')}}">Show List</a>
                                @endif

                                @if(Route::currentRouteName() == "vendor.view.category")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.view.category",['categoryID'=>\Illuminate\Support\Facades\Request::route('categoryID')])}}">View Category</a>
                                @endif
                                @if(Route::currentRouteName() == "vendor.edit.category")
                                    <a class="nav-link text-active text-capitalize" href="{{route("vendor.edit.category",['categoryID'=>\Illuminate\Support\Facades\Request::route('categoryID')])}}">View Category</a>
                                @endif
                            </nav>
                        </div>
                    </nav>
                </div>

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
