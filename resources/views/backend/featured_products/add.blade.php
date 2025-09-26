@extends('backend.master')
@section('title','add featured product')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
            <a class="breadcrumb-item" href="">FeaturedProduct</a>
            <span class="breadcrumb-item active">Add Featured Product</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">

                        <div class="row">
                            <label class="col-sm-4 form-control-label">Product Category: <span class="tx-danger">*</span>
                            </label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <select class="form-control" id="category">
                                    <option value="">Select Category</option>
                                    @foreach($category as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- row -->

                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Product Name: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id = "productName" placeholder="Enter Product Name">
                            </div>
                        </div><!-- row -->

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">OldPrice: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id = "oldPrice" placeholder="Enter old price">
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">NewPrice: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id = "newPrice" placeholder="Enter new price">
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Upload Image: <span class="tx-danger">*</span>
                            </label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="file" class="form-control" id = "image" accept="image/*">
                            </div>
                        </div><!-- row -->
                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Product description: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id = "des" placeholder="Enter Product description">
                            </div>
                        </div><!-- row -->

                        <div class="form-layout-footer mg-t-30">
                            <button class="btn btn-info mg-r-5 addPro">Add Product</button>
                        </div><!-- form-layout-footer -->
                    </div><!-- card -->
                </div><!-- col-6 -->
            </div><!-- row -->

        </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.addPro').click(function (e) {
                e.preventDefault();
                let category = $('#category').val();
                let productName = $('#productName').val();
                let oldPrice = $('#oldPrice').val();
                let newPrice = $('#newPrice').val();
                let image = $('#image').prop('files')[0];
                let des = $('#des').val();
                let formData = new FormData();
                formData.append('category', category);
                formData.append('productName', productName);
                formData.append('oldPrice', oldPrice);
                formData.append('newPrice', newPrice);
                formData.append('image', image);
                formData.append('des', des);
                if (category === '' || productName === '' || oldPrice === '' || newPrice === '' || !image ||des ==='') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your ... again ',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }else {
                    $.ajax({
                        method: 'POST',
                        url: '/addFeaturedProductStore',
                        contentType: false,
                        processData:false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response.data === false){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'try again',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }else {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'store successful',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed){
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
