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
                            <form method="POST" action="{{ route('vendor.add.category') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" list="category-list" name="cname" id="cname" type="text" placeholder="Enter your category name" value="{{old('cname')}}"/>
                                            <datalist id="category-list">
                                                @foreach($categories as $c)
                                                    <option value="{{$c->c_name}}"></option>
                                                @endforeach
                                            </datalist>
                                            <label for="inputFirstName">Category name <b class="text-danger">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea rows="20" class="form-control" name="cdescription" id="cdescription" placeholder="Enter your category description" >{{old('cdescription')}}</textarea>
                                            <label for="inputFirstName">Category description</label>
                                        </div>
                                        <p class="text-info"><strong>Note: </strong> If category already exist in database, No need to add same new</p>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Create"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
