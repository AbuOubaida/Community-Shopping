@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 rounded-lg mt-5">
                        <div class="card-body">
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="vname" type="text" placeholder="Enter your category name" value="{{$category->vendor_name}}" readonly/>
                                            <label for="vname">For vendor name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="creater_name" type="text" value="{{$category->creater_name}}" readonly/>
                                            <label for="creater_name">Create at<b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="cname" type="text" value="{{$category->category_name}}" readonly/>
                                            <label for="cname">Category name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea rows="20" class="form-control" id="cdescription" readonly>{{$category->category_description}}</textarea>
                                            <label for="cdescription">Category description</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
