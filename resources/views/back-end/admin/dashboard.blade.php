@extends('back-end.admin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{\Illuminate\Support\Facades\Auth::user()->roles->first()->display_name}} Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{\Illuminate\Support\Facades\Auth::user()->roles->first()->display_name}} Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <h1>Welcome to {{\Illuminate\Support\Facades\Auth::user()->roles->first()->display_name}} Dashboard</h1>
                </div>
            </div>
        </div>
    </main>
@stop
