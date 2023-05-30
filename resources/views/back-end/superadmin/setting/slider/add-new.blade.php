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
                            <form method="POST" action="{{route('setting.slider.create')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="title" id="title" type="text" placeholder="Enter Slider Title"  value="{{old('title')}}"/>
                                                <label for="title">Slider Title</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" name="title_show" value="1" id="" checked>
                                                    Show on slider
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="quotation" id="quotation" type="text" placeholder="Enter Slider Quotation"  value="{{old('quotation')}}"/>
                                                <label for="quotation">Slider Quotation</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" value="1" name="quotation_show" id="" checked>
                                                    Show on slider
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="heading1" id="heading1" type="text" placeholder="Enter Slider Heading 1"  value="{{old('heading1')}}"/>
                                                <label for="heading1">Slider Heading 1</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" value="1" name="heading1_show" id="" checked>
                                                    Show on Heading 1
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="heading2" id="heading2" type="text" placeholder="Enter Slider Heading 2"  value="{{old('heading2')}}"/>
                                                <label for="heading2">Slider Heading 2</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" value="1" name="heading2_show" id="">
                                                    Show on Heading 2
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="paragraph" id="paragraph" type="text" placeholder="Enter Slider Paragraph"  value="{{old('paragraph')}}"/>
                                                <label for="paragraph">Slider Paragraph</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" value="1" name="paragraph_show" id="">
                                                    Show on Paragraph
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="button_title" id="button_title" type="text" placeholder="Enter Slider Button Title"  value="{{old('button_title')}}"/>
                                                <label for="button_title">Slider Button Title</label>
                                            <div class="row">
                                                <label for="">
                                                    <input type="checkbox" value="1" name="button_show" id="">
                                                    Show on Button
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="button_link" id="button_link" type="text" placeholder="Enter Slider Button Link"  value="{{old('button_link')}}"/>
                                                <label for="button_link">Slider Button Link</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" onchange="return Obj.priview(this,'preview')" name="image_name" id="image_name" type="file" placeholder="Enter Slider image "  value="{{old('image_name')}}"/>
                                                <label for="image_name">Slider Image </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Add Slider Image"></div>
                                </div>
                            </form>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <img src="" id="preview" class="img-rounded" width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--        Slider Image show--}}
        <div class="container-fluid px-4">
            <h1 class="mt-4">Slider image List</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Slider image List</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Slider image List
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$sliders) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($sliders as $slider)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$slider->title}}</td>
                                                    <td><img src="{{url($slider->source_url.$slider->image_name)}}" alt="{{$slider->title}}" width="50%" class="tabel-image"></td>
                                                    <td>@if($slider->status == 0) <span class="label text-danger">Inactive</span> @else <span class="label text-success">Active</span> @endif</td>
                                                    <td>
                                                        <a href="" class="text-primary">View</a>
                                                        <a href="" class="text-success">Edit</a>
                                                        <form action="{{route('admin.delete.user')}}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="user_id" value="{{$slider->id}}">
                                                            <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this User?')" type="submit">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif


                                        </tbody>
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
