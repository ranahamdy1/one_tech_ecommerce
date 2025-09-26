@extends('backend.master')
@section('title','show category')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">DashBoard</a>
            <a class="breadcrumb-item" href="index.html">Tables</a>
            <span class="breadcrumb-item active">Category</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Categories</h5>
            </div><!-- sl-page-title -->


            <div class="card pd-20 pd-sm-40 mg-t-50">

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-primary mg-b-0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $val)
                            <tr>
                                <td>{{$val->id}}</td>
                                <td>{{$val->name}}</td>
                                <td>
                                    <img src="{{$val->image}}" alt="" style="width: 50px">
                                </td>
                                <td>{{$val->order}}</td>
                                <td>
                                    <a href="{{route('editCategory',['id'=>$val->id])}}" class="btn btn-primary btn-block mg-b-10">Edit</a>
                                    <a href="" class="btn btn-danger btn-block mg-b-10 delCat" catID = {{$val->id}}>Delete</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div><!-- table-responsive -->
                {{$data->links()}}
            </div><!-- card -->


@endsection


            @section('js')
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function () {
                        $('.delCat').click(function (e) {
                            e.preventDefault();
                            let id = $(this).attr('catID');
                            console.log(id);

                            Swal.fire({
                                title: 'warning!',
                                text: 'Do you want to delete this caregory?',
                                icon: 'warning',
                                confirmButtonText: 'yes'
                            }).then((result) => {
                                if (result.isConfirmed){
                                    $.ajax({
                                        method: 'POST',
                                        url: '/deleteCategory',
                                        data: {
                                            id:id
                                        },
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function (response){
                                            if(response.data === 1){
                                                window.location.reload();
                                            }
                                        }
                                    });
                                }
                            });
                        });
                    });
                </script>
@endsection

