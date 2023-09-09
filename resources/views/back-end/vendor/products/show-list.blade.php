@extends('back-end.vendor.main')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{$headerData['title']}}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{$headerData['title']}}</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    {{$headerData['title']}}
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Is Offer?</th>
                                            <th>For Vendor</th>
                                            <th>Create by</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Is Offer?</th>
                                            <th>For Vendor</th>
                                            <th>Create by</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @if(count(@$products) > 0)
                                            @php
                                            $i = 1;
                                            @endphp
                                            @foreach($products as $p)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td class="text-capitalize"><img src="{{url('assets/back-end/vendor/product/').'/'.$p->p_image}}" alt="product Image" style="height: 50px; border-radius: 5px" class="tabel-image"> {{$p->p_name}}</td>
                                                    <td>{{$p->category_name}}</td>
                                                    <td>{{$p->p_price}}</td>
                                                    <td>@if($p->offer_status == "1") <b class="text-info">Available</b> @else <b class="text-warning">Unavailable</b> @endif</td>
                                                    <td>{{$p->vendor_name}}</td>
                                                    <td>{{$p->creater_name}}</td>
                                                    <td>@if($p->status == "0") <span class="label text-danger">Inactive</span> @else <span class="label text-success">Active</span> @endif</td>
                                                    <td>
                                                        <a href="{{route('vendor.view.product',['productID'=>$p->id])}}" class="text-primary"><i class="fas fa-eye"></i></a>
                                                        <a href="{{route('vendor.edit.product',['productID'=>$p->id])}}" class="text-success"> <i class="fas fa-edit"></i></a>
                                                        <form action="{{route('vendor.delete.product')}}" method="post" class="d-inline-block">
                                                            {!! method_field('delete') !!}
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="product_id" value="{{$p->id}}">
                                                            <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this Product?')" type="submit"><i class="fas fa-trash"></i></button>
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
