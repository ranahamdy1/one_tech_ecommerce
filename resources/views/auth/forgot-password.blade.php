@extends('auth.master')
@section('title','forget password')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span></div>
            <div class="tx-center mg-b-60">Professional Admin Template Design</div>

            <div class="form-group">
                <input type="text" id="email" class="form-control" placeholder="Enter your email">
            </div><!-- form-group -->
            <!-- form-group -->
            <button type="submit" class="btn btn-info btn-block forgetPasswordBtn">OK</button>

        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection

@section('js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('.forgetPasswordBtn').on('one',function (e) {
                e.preventDefault();

                let email = $('#email').val();

                if (email === '' ) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your email',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $.ajax({
                        method: 'POST',
                        url: '/userForgetPassword',
                        data: {
                            email: email
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function ($response) {
                            if ($response.data === 0){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'wrong email',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }else {
                                Swal.fire({
                                    title: 'success!',
                                    text: 'reset password sent to email',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
