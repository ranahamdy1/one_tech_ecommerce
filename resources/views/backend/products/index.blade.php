@extends('backend.master')
@section('title','add product')

@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
            <span class="breadcrumb-item active">Products</span>
        </nav>

        <div class="sl-pagebody">

            <div class="card pd-20 pd-sm-40">

                <div class="table-responsive">
                    <table class="table mg-b-0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>category</th>
                            <th>Name</th>
                            <th>OldPrice</th>
                            <th>NewPrice</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product as $val)
                            @php($category =DB::table('categories')->where('id','=',$val->category)->first())

                            <tr>
                                <td>{{$val->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$val->name}}</td>
                                <td>{{$val->oldPrice}}</td>
                                <td>{{$val->newPrice}}</td>
                                <td>
                                    <img src="{{$val->image}}" alt="" style="width: 50px">
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-block mg-b-10">Edit</a>
                                    <a href="" class="btn btn-danger btn-block mg-b-10 delCat" prodID = {{$val->id}}>Delete</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- card -->

        </div><!-- sl-pagebody -->

    </div><!-- sl-mainpanel -->
@endsection
