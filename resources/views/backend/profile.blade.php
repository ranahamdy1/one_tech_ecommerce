@extends('backend.master')
@section('title','Edit profile')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{route('dashboard')}}">Dashboard</a>
            <span class="breadcrumb-item active">Profile</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Form Layouts</h5>
                <p>Forms are used to collect user information with different element types of input, select, checkboxes, radios and more.</p>
            </div><!-- sl-page-title -->

            <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Top Label Layout</h6>
                <p class="mg-b-20 mg-sm-b-30">A form with a label on top of each form control.</p>

                <div class="form-layout">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="name" value="{{Auth::user()->name}}" placeholder="Enter name">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="email" id="email" value="{{Auth::user()->email}}" placeholder="Enter email">
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="password" id="password" >
                            </div>
                        </div><!-- col-4 -->

                </div><!-- form-layout -->
            </div><!-- card -->

                <div class="form-layout-footer">
                    <button class="btn btn-info mg-r-5 updateProfile">Save</button>
                </div><!-- form-layout-footer -->
        </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->

@endsection


        @section('js')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function () {
                    $('.updateProfile').click(function (e) {
                        e.preventDefault();
                        let name = $('#name').val();
                        let email = $('#email').val();
                        let password = $('#password').val();


                        if (name === '' || email === '') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Please enter your name and email',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            $.ajax({
                                method: 'POST',
                                url: '/adminUpdateProfile',
                                data: {
                                    name: name,
                                    email: email,
                                    password: password,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    if (response.data === 1) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Profile updated successfully',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
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

