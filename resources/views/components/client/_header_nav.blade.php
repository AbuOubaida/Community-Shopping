<header id="navbar-spy" class="header header-3 header-transparent header-bordered header-fixed">
    <nav id="primary-menu" class="navbar navbar-fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse-2">
                <ul class="nav navbar-nav nav-pos-right navbar-left">
                    <li class="@if(\Request::url() === route("root")) {{'active'}} @endif" >
                        <a href="{{route("root")}}" class="menu-item">home</a>
                    </li>

                    <li class="@if(\Request::url() === route("contact")) {{'active'}} @endif">
                        <a href="{{route('contact')}}" class="menu-item">Contact Us</a>
                    </li>

                    <li class="@if(\Request::url() === route("about")) {{'active'}} @endif">
                        <a href="{{route("about")}}" class="menu-item">About</a>
                    </li>
                </ul>
            </div>

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-mobile" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo" href="{{route("root")}}">
{{--                    <h2 class="logo-text">Online Food</h2>--}}
                    <img class="logo-light " src="{{url("client-site/images/logo/cms.png")}}" width="25%"/>
                    <img class="logo-dark" src="{{url("client-site/images/logo/cms.png")}}" alt="granny Logo" width="30%" />
                </a>
            </div>
            <div class="module-container pull-right">

                <div class="module module-cart">
                    <div class="module-icon cart-icon @if(\Request::url() === route("view.cart")) {{'active-border-bottom'}}  @endif ">
                        <a href="{{route('view.cart')}}">
                            <i class="fa fa-shopping-cart @if(\Request::url() === route("view.cart")) {{'text-red'}}  @endif" ></i>
                            <label class="module-label" id="shopping-card">@if(session('cart')){{count(session('cart'))}}@else 0 @endif</label>
                        </a>
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse pull-right" id="navbar-collapse-1">
                <ul class="nav navbar-nav nav-pos-right navbar-left">
                    <li class="@if(\Request::url() === route("client.product.list")) {{'active'}}  @endif">
                        <a href="{{route('client.product.list')}}"  class="menu-item">Shop</a>
                    </li>
                @if($user = \Illuminate\Support\Facades\Auth::user())
                    <li class="@if(\Request::url() === route("login")) {{'active'}}  @endif">
                        <a class="menu-item" href="{{route('login')}}">My Account</a>
                    </li>
                @else
                    <li class="@if(\Request::url() === route("login")) {{'active'}}  @endif">
                        <a class="menu-item" href="{{route('login')}}">Login</a>
                    </li>

                    <li class="@if(\Request::url() === route("register")) {{'active'}}  @endif">
                        <a href="{{route('register')}}"  class="menu-item">Register</a>
                    </li>
                @endif
                </ul>
            </div>

            <div class="collapse navbar-collapse pull-right" id="navbar-collapse-mobile">
                <ul class="nav navbar-nav nav-pos-right navbar-left hidden-lg hidden-md">
{{--                    <li class="has-dropdown mega-dropdown @if(\Request::url() === route("root")) {{'active'}}">--}}
{{--                        <a href="{{route("root")}}" class="menu-item">home</a>--}}
{{--                    </li>--}}
                    <li class=" mega-dropdown @if(\Request::url() === route("root")) {{'active'}}  @endif">
                        <a href="{{route("root")}}" class="menu-item">home</a>
                    </li>

                    <li class="@if(\Request::url() === route("contact")) {{'active'}}  @endif">
                        <a href="{{route("contact")}}" class="menu-item">Contact Us</a>
                    </li>

                    <li class="@if(\Request::url() === route("about")) {{'active'}}  @endif">
                        <a href="{{route("about")}}" class="menu-item">About</a>
                    </li>



                    <li class="@if(\Request::url() === route("client.product.list")) {{'active'}}  @endif">
                        <a href="{{route('client.product.list')}}" class="menu-item">Shop</a>
                    </li>
                @if($user = \Illuminate\Support\Facades\Auth::user())
                        <li class="@if(\Request::url() === route("login")) {{'active'}} @endif">
                            <a class="menu-item" href="{{route('login')}}">My Account</a>
                        </li>
                @else
                    <li class="@if(\Request::url() === route("login")) {{'active'}} @endif">
                        <a class="menu-item" href="{{route('login')}}">Login</a>
                    </li>

                    <li class="@if(\Request::url() === route("register")) {{'active'}}  @endif">
                        <a href="{{route('register')}}"  class="menu-item">Register</a>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
