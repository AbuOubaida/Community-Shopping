@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-capitalize">{{str_replace('.', ' ', \Route::currentRouteName())}}</h1>
            <ol class="breadcrumb mb-4 bg-none">
                <li class="breadcrumb-item">
                    <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="text-capitalize text-chl">Previous</a>
                </li>
                <li class="breadcrumb-item">
                    <a style="text-decoration: none;" href="#" class="text-capitalize text-active">{{str_replace('.', ' ', \Route::currentRouteName())}}</a>
                </li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <form action="{!! route('vendor.my.community') !!}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-control" name="community" id="community">
                                                <option value="">--Select Option--</option>
                                        @if(count($comm))
                                            @foreach($comm as $c)
                                                <option value="{!! $c->id !!}">Name: {!! $c->community_name  !!} || ( Type:{!! $c->community_type !!}) || (Address: #Home-{!! $c->home !!}, Village-{!! $c->village !!}, Word-{!! $c->word !!}, Union-{!! $c->union !!}, Upazila-{!! $c->upazilla !!}, District-{!! $c->district !!}, Division-{!! $c->division !!})</option>
                                            @endforeach
                                        @endif
                                            </select>
                                            <label for="community">Add community list for you <span class="text-danger">*</span></label>
                                        </div>
                                        <br>
                                        <div class="form-floating mb-3 mb-md-0">
                                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control"></textarea>
                                            <label for="remarks">Remarks</label>
                                        </div>
                                        <br>
                                        <input type="submit" value="Add to List" class="btn btn-outline-success float-right" name="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <h1 class="mt-4 text-capitalize">Community List For Me</h1>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Community list for me
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Community Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Community Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count($vendor_communities))
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($vendor_communities as $vc)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$vc->community}}</td>
                                                    <td>{{$vc->community_type}}</td>
                                                    <td>Address: #Home-{!! $vc->home !!}, Village-{!! $vc->village !!}, Word-{!! $vc->word !!}, Union-{!! $vc->union !!}, Upazila-{!! $vc->upazilla !!}, District-{!! $vc->district !!}, Division-{!! $vc->division !!}</td>
                                                    <td>{!! $vc->remarks !!}</td>
                                                    <td>
                                                        <form action="{!! route('vendor.delete.community') !!}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="id" value="{{\Illuminate\Support\Facades\Crypt::encryptString($vc->id)}}">
                                                            <button title="Delete" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this data? Because this data is permanently delete on database.')" type="submit"><i class="fas fa-trash"></i></button>
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
