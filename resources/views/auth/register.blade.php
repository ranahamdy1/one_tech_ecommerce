@extends('auth.master')
@section('title','register')

@section('content')

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span></div>
            <div class="tx-center mg-b-60">Professional Admin Template Design</div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter your username" id="name">
            </div><!-- form-group -->

            <div class="form-group">
                <input type="email" class="form-control" placeholder="Enter your email" id="email">
            </div><!-- form-group -->

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter your password" id="password">
            </div><!-- form-group -->

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm your password" id="confirmPassword">
            </div><!-- form-group -->

            <div class="form-group">
                <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Birthday</label>
                <div class="row row-xs">
                    <div class="col-sm-4">
                        <select class="form-control select2" data-placeholder="Month">
                            <option label="Month"></option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                        </select>
                    </div>
                    <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <select class="form-control select2" data-placeholder="Day">
                            <option label="Day"></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <select class="form-control select2" data-placeholder="Year">
                            <option label="Year"></option>
                            <option value="2010">2010</option>
                            <option value="2011">2011</option>
                            <option value="2012">2012</option>
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                        </select>
                    </div>
                </div>
            </div><!-- form-group -->

            <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
            <button type="submit" class="btn btn-info newAccount">Sign Up</button>

            <div class="mg-t-40 tx-center">Already have an account? <a href="{{route('login')}}" class="tx-info">Sign In</a></div>
        </div>
    </div>

@endsection

@section('js')
    <!-- ✅ Select2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // ✅ فعل Select2
            $('.select2').select2();

            $('.newAccount').click(function (e) {
                e.preventDefault();

                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let confirmPassword = $('#confirmPassword').val();

                if (name === '' || email === '' || password === '' || confirmPassword === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'All fields are required',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (password !== confirmPassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Passwords do not match',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $.ajax({
                        method: 'POST',
                        url: '/newAccount',
                        data: {
                            name: name,
                            email: email,
                            password: password,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response.data === 0){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Email already exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }else if(response.data === 1){
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Account created successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/';
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
