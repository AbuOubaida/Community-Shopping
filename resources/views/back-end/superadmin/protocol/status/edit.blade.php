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
                                            <select class="form-control" id="locationType" onchange="Obj.LocationType(this,'location')">
                                                <option value="0">--Select Option--</option>
                                                <option value="1" @if(@$shipping->location_type == 1) selected @endif>Country</option>
                                                <option value="2" @if(@$shipping->location_type == 2) selected @endif>Division</option>
                                                <option value="3" @if(@$shipping->location_type == 3) selected @endif>District</option>
                                                <option value="4" @if(@$shipping->location_type == 4) selected @endif>Upazila</option>
                                                <option value="5" @if(@$shipping->location_type == 5) selected @endif>Union</option>
                                            </select>
                                            <label for="country">Type of Location</label>
                                        </div>
                                    </div>
                                    {{--                                        Devision--}}
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" id="location">
                                                <option value="{{@$shipping->location_name}}">{{@$shipping->location_name}}</option>
                                            </select>
                                            <label for="division">Location Name</label>
                                        </div>
                                    </div>
                                    {{--                                        Districts--}}
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="amount" type="number" placeholder="Shipping Amount" value="{{@$shipping->amount}}"/>
                                            <label for="district">Shipping Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0 float-end">
                                    <input class="btn btn-success" type="submit" id="shipping-update" value="Update" ref="{{\Illuminate\Support\Facades\Crypt::encryptString(@$shipping->id)}}">
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
