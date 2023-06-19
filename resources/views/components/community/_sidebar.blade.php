<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{route('community.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
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
{{--Order start here--}}
        {{--Head Start--}}
            @if("community.my.order" == Route::currentRouteName())
                <a class="nav-link text-active" href="#" data-bs-toggle="collapse" data-bs-target="#orderLayouts" aria-expanded="true" aria-controls="orderLayouts">
                    <div class="sb-nav-link-icon text-active"><i class="fas fa-columns"></i></div>
                    Order
                    <div class="sb-sidenav-collapse-arrow text-active"><i class="fas fa-angle-down"></i></div>
                </a>
            @else
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#orderLayouts" aria-expanded="false" aria-controls="orderLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Order
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
            @endif

        {{--Head End--}}
            {{--Sub-Head Start--}}
            @if("community.my.order" == Route::currentRouteName())
                <div class="collapse show" id="orderLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @else
                <div class="collapse" id="orderLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            @endif
                    <nav class="sb-sidenav-menu-nested nav">
                    {{--Item Start--}}
                    @if("community.my.order" == Route::currentRouteName())
                        <a class="nav-link text-active" href="{{route('community.my.order')}}">My order list</a>
                    @else
                        <a class="nav-link" href="{{route('community.my.order')}}">My order list</a>
                    @endif


                    </nav>
                </div>
            {{--Sub-Head Start--}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: {!! \Illuminate\Support\Facades\Auth::user()->roles->first()->display_name !!}</div>
            {!! str_replace('_'," ",config("app.name")) !!}
        </div>
    </nav>
</div>
