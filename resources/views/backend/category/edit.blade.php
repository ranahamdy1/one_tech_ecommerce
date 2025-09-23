@extends('backend.master')
@section('title','edit')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
            <a class="breadcrumb-item" href="index.html">Forms</a>
            <span class="breadcrumb-item active">Edit Categories</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <h6 class="card-body-title">Left Label Alignment</h6>
                        <p class="mg-b-20 mg-sm-b-30">A basic form where labels are aligned in left.</p>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">category name: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" id="name" class="form-control" value="{{$data->name}}" placeholder="Enter Category name">
                            </div>
                        </div><!-- row -->
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Category order: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" id="order" class="form-control" value="{{$data->order}}" placeholder="Enter Category order">
                            </div>
                        </div>

                        <input type="hidden" id="id" value="{{$data->id}}">
                        <div class="form-layout-footer mg-t-30">
                            <button class="btn btn-info mg-r-5" id="newCat">save</button>
                        </div><!-- form-layout-footer -->
                    </div><!-- card -->
                </div><!-- col-6 -->
            </div><!-- row -->


        </div><!-- sl-pagebody -->
        <footer class="sl-footer">
            <div class="footer-left">
                <div class="mg-b-2">Copyright &copy; 2017. Starlight. All Rights Reserved.</div>
                <div>Made by ThemePixels.</div>
            </div>
            <div class="footer-right d-flex align-items-center">
                <span class="tx-uppercase mg-r-10">Share:</span>
                <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/starlight"><i class="fa fa-facebook tx-20"></i></a>
                <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Starlight,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/starlight"><i class="fa fa-twitter tx-20"></i></a>
            </div>
        </footer>
    </div><!-- sl-mainpanel -->

@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#newCat').click(function (e) {
                e.preventDefault();
                let name = $('#name').val();
                let order = $('#order').val();
                let id = $('#id').val();
                if (name === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your name ',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }else {
                    $.ajax({
                        method: 'POST',
                        url: '/updateCategory',
                        data: {
                            name: name,
                            order: order,
                            id:id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response){
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'updated successful',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed){
                                        window.location.reload();
                                    }
                                });
                            }
                    });
                }
            });
        });
    </script>
@endsection

