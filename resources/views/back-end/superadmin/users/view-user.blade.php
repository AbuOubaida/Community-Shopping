@extends('back-end.superadmin.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User Account View</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{!! route('super.admin.list.user') !!}">User Account List</a></li>
                <li class="breadcrumb-item active">User Account View</li>
            </ol>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                        @if($user)
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
                                                <a href="{{route('super.edit.single.user',['UserID'=>\Illuminate\Support\Facades\Crypt::encryptString($user->id)])}}" class="btn btn-outline-success"><i class="fas fa-edit"></i> Edit</a>
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
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <a href="{{url($user->img_path.$user->img_name)}}" target="_blank"><img class="img-thumbnail rounded float-start" src="{{url($user->img_path.$user->img_name)}}" alt=""></a>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-control" readonly="readonly" id="roles">
                                                            <option selected> {!!  $user->name !!} </option>
                                                        </select>
                                                        <label for="roles">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" readonly="readonly" value="{!! $user->fname !!}"/>
                                                        <label for="inputFirstName">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" value="{!!  $user->lname  !!}" readonly="readonly"/>
                                                        <label for="inputLastName">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br> <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" readonly="readonly" id="inputEmail"  value="{!!  $user->email  !!}"/>
                                                        <label for="inputEmail">Email address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="phone" readonly="readonly" value="{!! $user->phone !!}"/>
                                                        <label for="phone">Phone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-control" readonly="readonly" id="roles">
                                                            <option selected> {!!  $user->role !!} </option>
                                                        </select>
                                                        <label for="roles">User Roles</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input class="form-control" readonly="readonly" id="dob" value="{!! date('d-M-Y',strtotime($user->dob)) !!}"/>
                                                <label for="dob">Date of Birth</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select class="form-control" name="gender" id="gender" readonly>
                                                    <option selected>@if($user->gender == 1) Male @elseif($user->gender == 2) Female @else Other @endif</option>
                                                </select>
                                                <label for="gender">Gender</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <select readonly class="form-control" name="religion" id="religion">
                                                    <option >{!! $user->religion !!}</option>

                                                </select>
                                                <label for="religion">Religion</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="country" value="{!! $user->country !!}" >
                                                <label for="country">Country</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="division" value="{!! $user->division !!}"/>

                                                <label for="division">Division</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="district" value="{!! $user->district !!}"/>
                                                <label for="district">District</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="upazila" value="{!! $user->upazila !!}"/>
                                                <label for="upazila">Upazila</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="zip_code"value="{!! $user->zip_code !!}"/>
                                                <label for="zip_code">Zip Code</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row md-3">
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input readonly class="form-control" id="union" value="{!! $user->union !!}"/>
                                                <label for="union">Union</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" readonly id="word_no" value="{!! $user->word_no !!}"/>
                                                <label for="word_no">Word No.</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="village" readonly value="{!! $user->village !!}"/>
                                                <label for="village">Village</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" readonly id="home" value="{!! $user->home !!}"/>
                                                <label for="home">Home No.</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @else
                            <h3 class="text-danger text-center">User Not Found!</h3>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
