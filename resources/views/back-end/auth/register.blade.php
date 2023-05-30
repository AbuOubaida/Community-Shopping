@extends('client-site.main')
@section('content')
<x-client._page_header :pageInfo="$pageInfo" />{{--<header slider section>--}}
<section id="contact1" class="contact contact-1">
    <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                {{--                For Error message Showing--}}
                                @if ($errors->any())
                                    <div class="col-12">
                                        <div class="alert alert-danger alert-dismissible show z-index-1 w-auto error-alert" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            @foreach ($errors->all() as $error)
                                                <div>{{$error}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                {{--                For Insert message Showing--}}
                                @if (session('success'))
                                    <div class="col-12">
                                        <div class="alert alert-success alert-dismissible  show z-index-1  w-auto error-alert" role="alert">
                                            <div>{{session('success')}}</div>
                                            <button type="button" class="close float-right" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                {{--                For Insert message Showing--}}
                                @if (session('error'))
                                    <div class="col-12">
                                        <div class="alert alert-danger alert-dismissible  show z-index-1 w-auto error-alert" role="alert">
                                            <div>{{session('error')}}</div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="col-12">
                                        <div class="alert alert-warning alert-dismissible  show z-index-1 w-auto error-alert" role="alert">
                                            <div>{{session('warning')}}</div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body ">
                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="inputFirstName">First name<span class="text-danger">*</span></label>
                                                <input class="form-control" name="fname" id="inputFirstName" type="text" placeholder="Enter your first name" value="{{old('fname')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="inputLastName">Last name<span class="text-danger">*</span></label>
                                                <input class="form-control" name="lname" id="inputLastName" type="text" placeholder="Enter your last name" value="{{old('lname')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="inputEmail">Email address<span class="text-danger">*</span></label>
                                                <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" value="{{old('email')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="phone">Phone<span class="text-danger">*</span></label>
                                                <input class="form-control" name="phone" id="phone" type="number" placeholder="phone" value="{{old('phone')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                                                <input class="form-control" name="dob" id="dob" type="date" placeholder="Date of Birth" value="{{old('dob')}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="gender">Gender<span class="text-danger">*</span></label>
                                                <select class="form-control" name="gender" id="gender" required>
                                                    <option value="">-- select one --</option>
                                                    <option value="1" @if(old('gender') == 1) {{'selected'}} @endif>Male</option>
                                                    <option value="2" @if(old('gender') == 2) {{'selected'}}@endif>Female</option>
                                                    <option value="3" @if(old('gender') != 1 || old('gender') != 2) {{'selected'}}@endif>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <label for="religion">Religion</label>
                                                <select class="form-control" name="religion" id="religion">
                                                    <option value="">-- select one --</option>
                                                    <option value="African Traditional & Diasporic">African Traditional & Diasporic</option>
                                                    <option value="Agnostic">Agnostic</option>
                                                    <option value="Atheist">Atheist</option>
                                                    <option value="Baha'i">Baha'i</option>
                                                    <option value="Buddhism">Buddhism</option>
                                                    <option value="Cao Dai">Cao Dai</option>
                                                    <option value="Chinese traditional religion">Chinese traditional religion</option>
                                                    <option value="Christianity">Christianity</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Jainism">Jainism</option>
                                                    <option value="Juche">Juche</option>
                                                    <option value="Judaism">Judaism</option>
                                                    <option value="Neo-Paganism">Neo-Paganism</option>
                                                    <option value="Nonreligious">Nonreligious</option>
                                                    <option value="Rastafarianism">Rastafarianism</option>
                                                    <option value="Secular">Secular</option>
                                                    <option value="Shinto">Shinto</option>
                                                    <option value="Sikhism">Sikhism</option>
                                                    <option value="Spiritism">Spiritism</option>
                                                    <option value="Tenrikyo">Tenrikyo</option>
                                                    <option value="Unitarian-Universalism">Unitarian-Universalism</option>
                                                    <option value="Zoroastrianism">Zoroastrianism</option>
                                                    <option value="primal-indigenous">primal-indigenous</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
{{--                                        Country--}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="country">Country<span class="text-danger">*</span></label>
                                                <input class="form-control" list="countrylist" name="country" id="country" value="{{old('country')}}" onchange="return Obj.country(this,'divisionlist')" required>
                                                <datalist id="countrylist">
                                                    @foreach($countries as $c)
                                                        <option value="{{$c->nicename}}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
{{--                                        Devision--}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="division">Division<span class="text-danger">*</span></label>
                                                <input class="form-control" list="divisionlist" name="division" id="division" type="text" placeholder="division" value="{{old('division')}}" onchange="return Obj.division(this,'districtlist')" required/>
                                                <datalist id="divisionlist">
                                                    <option></option>
{{--                                                    @foreach($countries as $c)--}}
{{--                                                        <option value="{{$c->nicename}}"></option>--}}
{{--                                                    @endforeach--}}
                                                </datalist>
                                            </div>
                                        </div>
{{--                                        Districts--}}
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="district">District<span class="text-danger">*</span></label>
                                                <input class="form-control" list="districtlist" name="district" id="district" type="text" placeholder="district" value="{{old('district')}}" onchange="return Obj.district(this,'upazilalist')" required/>
                                                <datalist id="districtlist">
                                                    <option></option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="upazila">Upazila</label>
                                                <input class="form-control" list="upazilalist" name="upazila" id="upazila" type="text" placeholder="upazila" onchange="return Obj.upazilla(this,'ziplist','unionlist')" value="{{old('upazila')}}"/>
                                                <datalist id="upazilalist">
                                                    <option></option>
                                                </datalist>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="zip_code">Zip Code</label>
                                                <input class="form-control" list="ziplist" name="zip_code" id="zip_code" type="number" placeholder="zip code" value="{{old('zip_code')}}"/>
                                                <datalist id="ziplist">
                                                    <option></option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="union">Union</label>
                                                <input class="form-control" list="unionlist" name="union" id="union" type="text" placeholder="union" value="{{old('union')}}"/>
                                                <datalist id="unionlist">
                                                    <option></option>
                                                </datalist>

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="word_no">Word No.</label>
                                                <input class="form-control" list="wordlist" name="word_no" id="word_no" type="number" placeholder="word no" value="{{old('word_no')}}"/>
                                                <datalist id="wordlist">
                                                    <option></option>
                                                    @foreach($userWord as $word)
                                                        <option value="{{$word->word}}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="village">Village</label>
                                                <input class="form-control" list="villagelist" name="village" id="village" type="text" placeholder="village" value="{{old('village')}}"/>
                                                <datalist id="villagelist">
                                                    <option></option>
                                                    @foreach($userVill as $vill)
                                                        <option value="{{$vill->village}}"></option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="home">Home No.</label>
                                                <input class="form-control" name="home" id="home" type="text" placeholder="home" value="{{old('home')}}"/>

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="roles">User Roles<span class="text-danger">*</span></label>
                                                <select class="form-control" name="roles" id="roles" required>
                                                    <option> please select your role </option>
                                                @if(count($roles)>0)
                                                    @foreach($roles as $r)
                                                    <option value="{{$r->name}}" @if(old('roles') == $r->name) selected @endif>{{$r->display_name}}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="inputPassword">Password<span class="text-danger">*</span></label>
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" required/>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="inputPasswordConfirm">Confirm Password<span class="text-danger">*</span></label>
                                                <input class="form-control" id="inputPasswordConfirm" name="password_confirmation" type="password" placeholder="Confirm password" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <label for="profile">Profile Image</label>
                                                <input class="form-control" id="profile" onchange="Product.mustImage(this,'2048')" name="profile" type="file" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Create Account"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="{{route('login')}}">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
@stop
