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
                            <form method="POST" action="{{ route('vendor.edit.category',['categoryID'=>$category->id]) }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" name="cname" id="cname" type="text" placeholder="Enter your category name" value="{{$category->category_name}}"/>
                                            <label for="inputFirstName">Category name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="status" id="status">
                                                <option> --Select option-- </option>
                                                <option value="0" @if($category->status == 0) selected @endif>Inactive</option>
                                                <option value="1" @if($category->status == 1) selected @endif>Active</option>
                                            </select>
                                            <label for="status">Category Status</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea rows="20" class="form-control" name="cdescription" id="cdescription" placeholder="Enter your category description" >{{$category->category_description}}</textarea>
                                            <label for="inputFirstName">Category description</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-success btn-block" type="submit" value="Update"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
