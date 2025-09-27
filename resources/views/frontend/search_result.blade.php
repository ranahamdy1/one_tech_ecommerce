@extends('frontend.master')
@section('title','products')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/styles/shop_responsive.css')}}">

    <style>
        .proView {
            width: 20%;
            text-align: center;
        }

        .proView img{
            margin: auto;
            width: 100%;
        }

        .viewed_slider_container{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
@endsection

@section('content')


    <div class="home">
        <div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('/images/shop_background.jpg')}}"></div>
        <div class="home_overlay"></div>
        <div class="home_content d-flex flex-column align-items-center justify-content-center">
            <h2 class="home_title">Products</h2>
        </div>
    </div>

    <!-- Shop -->

    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <!-- Shop Sidebar -->
                    <div class="shop_sidebar">
                        <div class="sidebar_section">
                            <div class="sidebar_title">Categories</div>
                            <ul class="sidebar_categories">
                                @foreach($category as $val)
                                    <li><a href="{{route('productByCategory',['id'=>$val->id])}}">{{$val->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-lg-9">

                    <!-- Shop Content -->

                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count"><span>{{count($data)}}</span> products found</div>
                        </div>

                        <div class="product_grid">
                            <div class="product_grid_border"></div>

                            @foreach($data as $val)
                                <div class="product_item is_new">
                                    <div class="product_border"></div>
                                    <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{asset($val->image)}}" alt=""></div>
                                    <div class="product_content">
                                        <div class="product_price">${{$val->newPrice}}</div>
                                        <div class="product_name"><div><a href="{{route('productDetailsView',['id'=>$val->id])}}" tabindex="0">{{$val->name}}</a></div></div>
                                    </div>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                    <ul class="product_marks">
                                        <li class="product_mark product_discount">-25%</li>
                                        <li class="product_mark product_new">new</li>
                                    </ul>
                                </div>

                            @endforeach

                        </div>

                        <!-- Shop Page Navigation -->
                        {{$data->links()}}

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Recently Viewed -->

    @if(count($view) >0)
        <div class="viewed">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="viewed_title_container">
                            <h3 class="viewed_title">Recently Viewed</h3>
                            <div class="viewed_nav_container">
                                <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                                <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        </div>

                        <div class="viewed_slider_container">

                            <!-- Recently Viewed Slider -->

                            @foreach($view as $val)
                                <div class="proView">
                                    <div>
                                        <img src="{{asset($val->image)}}" alt="">
                                        <div class="viewed_content text-center">
                                            <div class="viewed_price">${{$val->newPrice}}<span>
                                                    @if($val->oldPrice != null)
                                                        ${{$val->oldPrice}}</span></div>
                                            @endif
                                            <div class="viewed_name"><a href="{{route('productDetailsView',['id'=>$val->id])}}">{{$val->name}}</a></div>
                                        </div>
                                        <ul class="item_marks">
                                            <li class="item_mark item_discount">-25%</li>
                                            <li class="item_mark item_new">new</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Newsletter -->

    <div class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                        <div class="newsletter_title_container">
                            <div class="newsletter_icon"><img src="images/send.png" alt=""></div>
                            <div class="newsletter_title">Sign up for Newsletter</div>
                            <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                        </div>
                        <div class="newsletter_content clearfix">
                            <form action="#" class="newsletter_form">
                                <input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                                <button class="newsletter_button">Subscribe</button>
                            </form>
                            <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

