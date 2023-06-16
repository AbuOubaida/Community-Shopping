@extends('back-end.superadmin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">@isset($headerData){{ $headerData['title'] }} @endisset</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Create New Image</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form>
                                @csrf
                                <div class="row mb-3">
                                    {{--                                        Country--}}
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" id="locationType" onchange="Obj.LocationType(this,'locationlist')">
                                                <option value="0">--Select Option--</option>
                                                <option value="1">Country</option>
                                                <option value="2">Division</option>
                                                <option value="3">District</option>
                                                <option value="4">Upazila</option>
                                                <option value="5">Union</option>
                                            </select>
                                            <label for="country">Type of Location</label>
                                        </div>
                                    </div>
                                    {{--                                        Devision--}}
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="locationlist" id="location" type="text"/>
                                            <datalist id="locationlist">
                                                <option></option>
                                            </datalist>
{{--                                            <select class="form-control" id="location">--}}
{{--                                            </select>--}}
                                            <label for="location">Location Name</label>
                                        </div>
                                    </div>
                                    {{--                                        Districts--}}
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="amount" type="number" placeholder="Shipping Amount" value=""/>
                                            <label for="district">Shipping Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0 float-end">
                                    <input class="btn btn-primary" type="submit" id="shipping-submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        Slider Image show--}}
        <div class="container-fluid px-4">
            <h1 class="mt-4">Shipping charge location wise</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Shipping charge location wise</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Shipping charge location wise
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        @include('back-end.superadmin.protocol.shipping-charge._list')
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
