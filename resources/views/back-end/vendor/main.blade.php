<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{str_replace('_',' ',config('app.name'))}} || {{\Illuminate\Support\Facades\Auth::user()->roles()->first()->display_name}} || {{str_replace('.', ' ', \Route::currentRouteName())}}</title>
    <x-vendor._header_link/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="sb-nav-fixed">
<x-vendor._header/>
<div id="layoutSidenav">
    <x-vendor._sidebar/>
    <div id="layoutSidenav_content">
        {{--                For Error message Showing--}}
        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show z-index-1 w-auto error-alert right-0" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        {{--                For Insert message Showing--}}
        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show z-index-1 right-0 w-auto error-alert" role="alert">
                    <div>{{session('success')}}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        {{--                For Insert message Showing--}}
        @if (session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show z-index-1 right-0 w-auto error-alert" role="alert">
                    <div>{{session('error')}}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session('warning'))
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show z-index-1 right-0 w-auto error-alert" role="alert">
                    <div>{{session('warning')}}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @yield('content')
        <x-vendor._footer/>
    </div>
</div>
<x-vendor._footer_link/>
</body>
</html>
