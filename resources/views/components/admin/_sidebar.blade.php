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
