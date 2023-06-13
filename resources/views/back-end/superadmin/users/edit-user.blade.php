@extends('back-end.superadmin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit User Account</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Edit User Account</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form action="{{route('super.admin.user.status.update')}}" method="post">
                                                {!! method_field('put') !!}
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <div class="input-group align-middle">
                                                    <select name="status" id="" class="form-control">
                                                        <option value="1" @if($user->status == 1) selected @endif>Active</option>
                                                        <option value="0" @if($user->status == 0) selected @endif>Inactive</option>
                                                    </select>
                                                    <button class="btn btn-primary" id="" type="submit" onclick="return confirm('Are you sure to change account status of this User?')">Change Status</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-5">
                                            <form action="{{route('super.admin.user.password.update')}}" method="post">
                                                {!! method_field('put') !!}
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <div class="input-group align-middle">
                                                    <input type="password" name="password" class="form-control">
                                                    <button class="btn btn-info" id="" type="submit" onclick="return confirm('Are you sure to change account password ?')">Change Password</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="float-start">
                                                <a href="{{route('super.single.view.user',['UserID'=>\Illuminate\Support\Facades\Crypt::encryptString($user->id)])}}" class="btn btn-outline-primary"><i class="fas fa-eye"></i> View</a>
                                            </div>
                                            <div class="float-end">
                                                @if($user->delete_status )
                                                    <form action="{{route('super.admin.rollback.user')}}" method="post" class="d-inline-block">
                                                        {!! method_field('put') !!}
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        <button title="Rollback" class="btn btn-outline-success d-inline-block" onclick="return confirm('Are you sure rollback this User?')" type="submit"><i class="fas fa-undo"></i> Rollback</button>
                                                    </form>
                                                @else
                                                    <form action="{{route('super.admin.delete.user')}}" method="post" class="d-inline-block">
                                                        {!! method_field('delete') !!}
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        <button title="Delete" class="btn btn-outline-danger d-inline-block" onclick="return confirm('Are you sure delete this User?')" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('super.edit.single.user',["UserID"=>\Illuminate\Support\Facades\Crypt::encryptString($user->id)]) }}" enctype="multipart/form-data">
                                        @csrf
                                        {!! method_field('put') !!}
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="fname" id="inputFirstName" type="text" placeholder="Enter your first name" value="{{$user->fname}}"/>
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="{{\Illuminate\Support\Facades\Crypt::encryptString($user->id)}}">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="lname" id="inputLastName" type="text" placeholder="Enter your last name" value="{{$user->lname}}"/>
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" value="{{$user->email}}"/>
                                                    <label for="inputEmail">Email address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="phone" id="phone" type="number" placeholder="phone" value="{{$user->phone}}"/>
                                                    <label for="phone">Phone</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="dob" id="dob" type="text" placeholder="Date of Birth" value="{{ $user->dob }}" required/>
                                                    <label for="dob">Date of Birth<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <select class="form-control" name="gender" id="gender" required>
                                                        <option value="">-- select one --</option>
                                                        <option value="1" @if($user->gender == 1) {{'selected'}} @endif>Male</option>
                                                        <option value="2" @if($user->gender == 2) {{'selected'}}@endif>Female</option>
                                                        <option value="3" @if(!($user->gender == 1 || old('gender') != 2)) {{'selected'}}@endif>Other</option>
                                                    </select>
                                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="religion" id="religion" value="{{$user->religion}}">
                                                    <label for="religion">Religion</label>
                                                </div>
                                            </div>
                                            {{--                                        Country--}}
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="countrylist" name="country" id="country" value="{{$user->country}}" onchange="return Obj.country(this,'divisionlist')">
                                                    <datalist id="countrylist">
                                                        @foreach($countries as $c)
                                                            <option value="{{$c->nicename}}"></option>
                                                        @endforeach
                                                    </datalist>
                                                    <label for="country">Country</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {{--                                        Devision--}}
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="divisionlist" name="division" id="division" type="text" placeholder="division" value="{{$user->division}}" onchange="return Obj.division(this,'districtlist')"/>
                                                    <datalist id="divisionlist">
                                                        <option></option>
                                                        @if(count($divisions))
                                                            @foreach($divisions as $d)
                                                                <option value="{{$d->name}}"></option>
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                                    <label for="division">Division</label>
                                                </div>
                                            </div>
                                            {{--                                        Districts--}}
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="districtlist" name="district" id="district" type="text" placeholder="district" value="{{$user->district}}" onchange="return Obj.district(this,'upazilalist')"/>
                                                    <datalist id="districtlist">
                                                        <option></option>
                                                        @if(count($districts))
                                                            @foreach($districts as $dt)
                                                                <option value="{{$dt->name}}"></option>
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                                    <label for="district">District</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="upazilalist" name="upazila" id="upazila" type="text" placeholder="upazila" onchange="return Obj.upazilla(this,'ziplist','unionlist')" value="{{$user->upazila}}"/>
                                                    <datalist id="upazilalist">
                                                        <option></option>
                                                        @if(count($upazilas))
                                                            @foreach($upazilas as $u)
                                                                <option value="{{$u->name}}"></option>
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                                    <label for="upazila">Upazila</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="ziplist" name="zip_code" id="zip_code" type="number" placeholder="zip code" value="{{$user->zip_code}}"/>
                                                    <datalist id="ziplist">
                                                        <option></option>
                                                        @if(count($zip_codes))
                                                            @foreach($zip_codes as $z)
                                                                <option value="{{$z->PostCode}}">{{$z->SubOffice}}</option>
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                                    <label for="zip_code">Zip Code</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row md-3">
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" list="unionlist" name="union" id="union" type="text" placeholder="union" value="{{$user->union}}"/>
                                                    <datalist id="unionlist">
                                                        <option></option>
                                                        @if(count($unions))
                                                            @foreach($unions as $u)
                                                                <option value="{{$u->name}}"></option>
                                                            @endforeach
                                                        @endif
                                                    </datalist>
                                                    <label for="union">Union</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="word_no" id="word_no" type="number" placeholder="word no" value="{{$user->word_no}}"/>
                                                    <label for="word_no">Word No.</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="village" id="village" type="text" placeholder="village" value="{{$user->village}}"/>
                                                    <label for="village">Village</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="home" id="home" type="text" placeholder="home" value="{{$user->home}}"/>
                                                    <label for="home">Home No.</label>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row md-3">
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" name="roles" id="roles">
                                                        <option> please select your role </option>
                                                        @if(count($roles)>0)
                                                            @foreach($roles as $r)
                                                                <option value="{{$r->id}}" @if($user->rid == $r->id) selected @endif>{{$r->display_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="roles">User Roles</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="profile" onchange="Obj.priview(this,'preview')" name="profile" type="file" />
                                                    <label for="profile">Profile Image</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <img id="preview" width="40%" src="{{url($user->img_path.$user->img_name)}}" alt="">
                                            </div>
                                            <div class="col-md-3">
                                                <input class="btn btn-success float-end" type="submit" value="Update">
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
