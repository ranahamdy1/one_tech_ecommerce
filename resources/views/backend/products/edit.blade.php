@extends('backend.master')
@section('title','product')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
            <a class="breadcrumb-item" href="{{route('product')}}">products</a>
            <span class="breadcrumb-item active">Edit products</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label">category name: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" id="name" class="form-control" value="{{$data->name}}" placeholder="Enter Category name">
                            </div>
                        </div><!-- row -->
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Product Category: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <select id="category" class="form-control">
                                    <option value="">plz select product category</option>
                                    @foreach($category as $item)
                                        <option value="{{$item->id}}" {{ $item->id == $data->category ? 'selected' : '' }}>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">old price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" id="oldPrice" class="form-control" value="{{$data->oldPrice}}" placeholder="Enter old price">
                            </div>
                        </div><!-- row -->
                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">new price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" id="newPrice" class="form-control" value="{{$data->newPrice}}" placeholder="Enter new price">
                            </div>
                        </div><!-- row -->
                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">image: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="file" id="image" class="form-control">
                            </div>
                        </div><!-- row -->

                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Product description: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id = "des" placeholder="Enter Product description" value="{{$data->des}}">
                            </div>
                        </div><!-- row -->

                        <input type="hidden" id="id" value="{{$data->id}}">
                        <div class="form-layout-footer mg-t-30">
                            <button class="btn btn-info mg-r-5 editBtn">save</button>
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
            $('.editBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val();
                let category = $('#category').val();
                let oldPrice = $('#oldPrice').val();
                let newPrice = $('#newPrice').val();
                let id = $('#id').val();
                let image = $('#image').prop('files')[0];
                let des = $('#des').val();

                let formData = new FormData();
                formData.append('name', name);
                formData.append('category', category);
                formData.append('oldPrice', oldPrice);
                formData.append('newPrice', newPrice);
                formData.append('id', id);
                formData.append('des', des);

                if (image) {
                    formData.append('image', image);
                }

                if (name === '' || category === '' || oldPrice === '' || newPrice === '' || des ==='') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please fill all required fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: '/updateProduct',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response){
                        console.log(response);
                        if (response.data ===1){
                            Swal.fire({
                                title: 'Success!',
                                text: 'Updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed){
                                    window.location.reload();
                                }
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
