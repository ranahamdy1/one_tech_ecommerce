@extends('frontend.master')
@section('title','view Cart')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/styles/cart_responsive.css')}}">
@endsection

@section('content')

    <!-- Cart -->

    <div class="cart_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_container">
                        <div class="cart_title">Shopping Cart</div>

                        @foreach($data as $val)
                            <div class="cart_items">
                            <ul class="cart_list">
                                <li class="cart_item clearfix">
                                    <div class="cart_item_image"><img src="{{asset('/images/shopping_cart.jpg')}}" alt=""></div>
                                    <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                        <div class="cart_item_name cart_info_col">
                                            <div class="cart_item_title">Name</div>
                                            <div class="cart_item_text">{{$val->name}}</div>
                                        </div>
                                        <div class="cart_item_quantity cart_info_col">
                                            <div class="cart_item_title">Quantity</div>
                                            <div class="cart_item_text">{{$val->quantity}}</div>
                                        </div>
                                        <div class="cart_item_price cart_info_col">
                                            <div class="cart_item_title">Price</div>
                                            <div class="cart_item_text">${{$val->newPrice}}</div>
                                        </div>
                                        <div class="cart_item_total cart_info_col">
                                            <div class="cart_item_title">Total</div>
                                            <div class="cart_item_text">${{$val->newPrice * $val->quantity}}</div>
                                        </div>
                                        <div class="cart_item_total cart_info_col">
                                            <div class="cart_item_title">Delete</div>
                                            <div class="cart_item_text"><button class="btn btn-danger delCartProduct" productId = '{{$val->id}}' >Delete</button></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @endforeach

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Order Total:</div>
                                <div class="order_total_amount">$2000</div>
                            </div>
                        </div>

                        <div class="cart_buttons">
                            <button type="button" class="button cart_button_clear">Empty Cart</button>
                            <button type="button" class="button cart_button_checkout">Checkout Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('.delCartProduct').click(function (e) {
                e.preventDefault();
                let productId = $(this).attr('productId');
                Swal.fire({
                    title: 'Warning!',
                    text: 'Do you want to delete this product from cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed){
                        $.ajax({
                            method: 'POST',
                            url: '/deleteProductFromCart/' + productId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response){
                                console.log(response);
                                if(response.data === 1){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.cart_button_clear').click(function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Warning!',
                    text: 'Do you want to empty cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed){
                        $.ajax({
                            method: 'POST',
                            url: '/emptyCart',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response){
                                console.log(response);
                                if(response.data >0 ){
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

