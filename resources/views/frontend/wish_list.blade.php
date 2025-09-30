@extends('frontend.master')
@section('title','wishList')

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
                        <div class="cart_title">WishList</div>

                        @foreach($data as $val)
                        <div class="cart_items">
                            <ul class="cart_list">
                                <li class="cart_item clearfix">
                                    <div class="cart_item_image"><img src="{{asset($val->image)}}" alt=""></div>
                                    <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                        <div class="cart_item_name cart_info_col">
                                            <div class="cart_item_title">Name</div>
                                            <div class="cart_item_text">{{$val->name}}</div>
                                        </div>
                                        <div class="cart_item_price cart_info_col">
                                            <div class="cart_item_title">Price</div>
                                            <div class="cart_item_text">${{$val->newPrice}}</div>
                                        </div>
                                        <div class="cart_item_price cart_info_col">
                                            <div class="cart_item_title">Add to cart</div>
                                            <div class="cart_item_text">
                                            <button class="btn btn-dark">Add to cart</button>
                                            </div>
                                        </div>
                                        <div class="cart_item_total cart_info_col">
                                            <div class="cart_item_title">Delete</div>
                                            <div class="cart_item_text">
                                                <button class="btn btn-danger"> Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @endforeach
                        {{$data->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('/js/cart_custom.js')}}"></script>

@endsection
