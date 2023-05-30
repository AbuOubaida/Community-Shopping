@extends('back-end.admin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Create User New Account</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Create User New Account</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.add.user') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="fname" id="inputFirstName" type="text" placeholder="Enter your first name" value="{{old('fname')}}"/>
                                            <label for="inputFirstName">First name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input class="form-control" name="lname" id="inputLastName" type="text" placeholder="Enter your last name" value="{{old('lname')}}"/>
                                            <label for="inputLastName">Last name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" value="{{old('email')}}"/>
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input class="form-control" name="phone" id="phone" type="number" placeholder="phone" value="{{old('phone')}}"/>
                                            <label for="phone">Phone</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    {{--                                        Country--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="countrylist" name="country" id="country" value="{{old('country')}}" onchange="return Obj.country(this,'divisionlist')">
                                            <datalist id="countrylist">
                                                @foreach($countries as $c)
                                                    <option value="{{$c->nicename}}"></option>
                                                @endforeach
                                            </datalist>
                                            <label for="country">Country</label>
                                        </div>
                                    </div>
                                    {{--                                        Devision--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="divisionlist" name="division" id="division" type="text" placeholder="division" value="{{old('division')}}" onchange="return Obj.division(this,'districtlist')"/>
                                            <datalist id="divisionlist">
                                                <option></option>
                                                {{--                                                    @foreach($countries as $c)--}}
                                                {{--                                                        <option value="{{$c->nicename}}"></option>--}}
                                                {{--                                                    @endforeach--}}
                                            </datalist>
                                            <label for="division">Division</label>
                                        </div>
                                    </div>
                                    {{--                                        Districts--}}
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="districtlist" name="district" id="district" type="text" placeholder="district" value="{{old('district')}}" onchange="return Obj.district(this,'upazilalist')"/>
                                            <datalist id="districtlist">
                                                <option></option>
                                            </datalist>
                                            <label for="district">District</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="upazilalist" name="upazila" id="upazila" type="text" placeholder="upazila" onchange="return Obj.upazilla(this,'ziplist','unionlist')" value="{{old('upazila')}}"/>
                                            <datalist id="upazilalist">
                                                <option></option>
                                            </datalist>
                                            <label for="upazila">Upazila</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row md-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="ziplist" name="zip_code" id="zip_code" type="number" placeholder="zip code" value="{{old('zip_code')}}"/>
                                            <datalist id="ziplist">
                                                <option></option>
                                            </datalist>
                                            <label for="zip_code">Zip Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="unionlist" name="union" id="union" type="text" placeholder="union" value="{{old('union')}}"/>
                                            <datalist id="unionlist">
                                                <option></option>
                                            </datalist>
                                            <label for="union">Union</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="word_no" id="word_no" type="number" placeholder="word no" value="{{old('word_no')}}"/>
                                            <label for="word_no">Word No.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="village" id="village" type="text" placeholder="village" value="{{old('village')}}"/>
                                            <label for="village">Village</label>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row md-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="home" id="home" type="number" placeholder="home" value="{{old('home')}}"/>
                                            <label for="home">Home No.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="roles" id="roles">
                                                <option> please select your role </option>
                                                @if(count($roles)>0)
                                                    @foreach($roles as $r)
                                                        <option value="{{$r->name}}" @if(old('roles') == $r->name) selected @endif>{{$r->display_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="roles">User Roles</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPasswordConfirm" name="password_confirmation" type="password" placeholder="Confirm password" />
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Create Account"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
