<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{route('super.admin.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
{{--                user section--}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('super.admin.add.user')}}">Add New</a>
                        <a class="nav-link" href="{{route('super.admin.list.user')}}">Show List</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#site-setting" aria-expanded="false" aria-controls="site-setting">
                    <div class="sb-nav-link-icon"><i class="fa fa-shield"></i></div>
                    Protocol
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="site-setting" aria-labelledby="headingTwo" data-bs-parent="#site">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sitePages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#shipping-charge" aria-expanded="false" aria-controls="shipping-charge">
                            Shipping Charge
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="shipping-charge" aria-labelledby="headingOne" data-bs-parent="#shipping-chargePages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{route('set.shipping.charge')}}">Set Shipping</a>
                            </nav>
                        </div>

                    </nav>
                </div>
                <div class="collapse" id="site-setting" aria-labelledby="headingTwo" data-bs-parent="#site">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sitePages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#status" aria-expanded="false" aria-controls="status">
                            Status
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="status" aria-labelledby="headingOne" data-bs-parent="#statusPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{!! route('set.order.status') !!}">Order Status</a>
                            </nav>
                        </div>

                    </nav>
                </div>
{{--                Settings section--}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#all-setting" aria-expanded="false" aria-controls="all-setting">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                    Setting
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="all-setting" aria-labelledby="headingTwo" data-bs-parent="#home">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="homePages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#slider" aria-expanded="false" aria-controls="slider">
                            Landing Page
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="slider" aria-labelledby="headingOne" data-bs-parent="#sliderPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{route('setting.slider.create')}}">Slider</a>
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
