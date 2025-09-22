@extends('auth.master')
@section('title','update_pass')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span></div>
            <div class="tx-center mg-b-60">Professional Admin Template Design</div>

            <div class="form-group">
                <input type="password" id="newPassword" class="form-control" placeholder="Enter new password">
            </div><!-- form-group -->
            <div class="form-group">
                <input type="password" id="confirmPassword" class="form-control" placeholder="Enter your password again">
            </div><!-- form-group -->

            <input type="hidden" id="userID" value="{{$user->id}}">
            <br><br>
            <!-- form-group -->
            <button type="submit" class="btn btn-info btn-block newPasswordBtn">update password</button>

        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection
@section('js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();

            $('.newPasswordBtn').click(function (e) {
                e.preventDefault();

                let newPassword = $('#newPassword').val();
                let confirmPassword = $('#confirmPassword').val();
                let userID = $('#userID').val();

                if (newPassword === '' || confirmPassword === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your new password',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (newPassword !== confirmPassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Passwords do not match',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $.ajax({
                        method: 'POST',
                        url: '/userUpdatedPassword',
                        data: {
                            password: newPassword,
                            password_confirmation: confirmPassword,
                            userID: userID
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message || 'Something went wrong',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Validation failed',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
