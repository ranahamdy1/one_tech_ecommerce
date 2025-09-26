@extends('frontend.master')
@section('title',$data->name)

@section('content')
    <div class="single_product">
        <div class="container">
            <div class="row">

                <!-- Selected Image -->
                <div class="col-lg-5 order-lg-2 order-1">
                    <div class="image_selected"><img src="{{asset($data->image)}}" alt=""></div>
                </div>

                <!-- Description -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div class="product_category">{{$category->name}}</div>
                        <div class="product_name">{{$data->name}}</div>
                        <div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
                        <div class="product_text"><p>{{$data->des}}</p></div>
                        <div class="order_info d-flex flex-row">
                            <form action="#">
                                <div class="clearfix" style="z-index: 1000;">

                                    <!-- Product Quantity -->
                                    <div class="product_quantity clearfix">
                                        <span>Quantity: </span>
                                        <input id="quantity_input" type="text" pattern="[0-9]*" value="1">
                                        <div class="quantity_buttons">
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="product_price">${{$data->newPrice}}
                                @if($data->oldPrice != null)
                                        <span style="color: red; text-decoration: line-through">{{$data->oldPrice}}</span>
                                    @endif
                                </div>
                                <div class="button_container">
                                    <button type="button" class="button cart_button">Add to Cart</button>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
