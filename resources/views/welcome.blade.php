@extends('layout.layout')
@section('plugins')
<link rel="stylesheet" href="{{ asset('css/V2/slick.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/font-awesome.min.css') }}">
<link type="text/css" rel="stylesheet" href="css/V2/style.css"/>
@endsection
@section('content')
<!--slider area start-->
<section class="slider_section d-flex align-items-center" data-bgimg="{{asset('img/header_img.png') }}">
        <div class="slider_area owl-carousel">
            <div class="single_slider d-flex align-items-center">
                <div class="container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                    <div class="col-xl-6 col-md-6">
                        <div class="slider_content" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
                            <h1>Pinoy Choice</h1>
                            <h2>Insane Quality for use</h2>
                            <a class="button" href="{{route('product_list')}}">Buy now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--slider area end-->

    <!--Tranding product-->
    <section class="pt-60 pb-30 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section-title">
                        <h2>Recommended</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding">
                        <a href="{{route('product_list')}}">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/pc_case.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>RAKK NAYA Matx Gaming Case Black</h3>
                                <h4>PC Case</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">₱700.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding">
                        <a href="{{route('product_list')}}">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/mouse.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>RAKK KAPTAN Trimode PAW3395 Lightweight 53g Gaming Mouse Black</h3>
                                <h4>Mouse</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">₱700.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding">
                        <a href="{{route('product_list')}}">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/keyboard.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>RAKK PIRAH PLUS 66 Keys Universal HotSwap</h3>
                                <h4>Mechanical Keyboard</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">₱2530.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--Tranding product-->

    
    <!--Features area-->
    <section class="gray-bg pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-lg-1 order-md-1 order-sm-1">
                    <div class="pro-details-feature">
                        <img src="{{asset('img/product/rakk_illis.png') }}" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-lg-2 order-md-2 order-sm-2">
                    <div class="pro-details-feature">
                        <h3>RAKK ILIS Type-C 96 Keys Mechanical Gaming Keyboard RGB Huano Red PBT Keycaps</h3>
                        <p>Dominate your gaming realm with the RAKK KAPTAN Trimode PAW3395 in White. Weighing just 53g, this lightweight gaming mouse combines speed and precision for an unparalleled gaming experience. Elevate your gameplay in style with the RAKK KAPTAN Trimode.</p>
                        <ul>
                            <li>Model RAKK KAPTAN Wireless</li>
                            <li>Sensor Pixart PAW3395</li>
                            <li>MCU Telink 8273</li>
                            <li>Connectivity 2.4G, BT 5.1 and Wired</li>
                            <li>Battery 300mA Lithium Battery</li>
                            <li>Configurable Buttons 5</li>
                        </ul>
                        <a href="#">₱1200 Buy now</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-lg-3 order-md-4 order-sm-4 order-4">
                    <div class="pro-details-feature">
                        <h3>RAKK Lam-Ang Pro Barebone Wireless RGB Mechanical Gaming Keyboard PBT White Keycaps</h3>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        <ul>
                            <li>It is a long established fact that</li>
                            <li>Many desktop publishing</li>
                            <li>Various versions have evolved over the years, sometimes by accident</li>
                            <li>There are many variations of passages</li>
                            <li>If you are going to use a</li>
                            <li>Alteration in some form, by injected</li>
                        </ul>
                        <a href="#">₱1300 Buy now</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-lg-4 order-md-3 order-sm-3 order-3">
                    <div class="pro-details-feature">
                        <img src="{{asset('img/product/RAKK_Lam-Ang.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section><!--Features area-->

    
    <!-- HOT DEAL SECTION -->
        <div id="hot-deal" class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row align-items-center">
                    <!-- Left Image Holder -->
                    <div class="col-md-3 d-flex justify-content-start">
                        <div class="image-holder">
                            <img src="{{ asset('img/product/rakk_daguob2.png') }}" alt="Left Image" class="img-fluid">
                        </div>
                    </div>

                    <!-- Hot Deal Content -->
                    <div class="col-md-6">
                        <div class="hot-deal text-center">
                            <ul class="hot-deal-countdown">
                                <li>
                                    <div>
                                        <h3>02</h3>
                                        <span>Days</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>10</h3>
                                        <span>Hours</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>34</h3>
                                        <span>Mins</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>60</h3>
                                        <span>Secs</span>
                                    </div>
                                </li>
                            </ul>
                            <h2 class="text-uppercase">hot deal this week</h2>
                            <p>New Collection Up to 50% OFF</p>
                            <a class="primary-btn cta-btn" href="#">Shop now</a>
                        </div>
                    </div>

                    <!-- Right Image Holder -->
                    <div class="col-md-3 d-flex justify-content-end">
                        <div class="image-holder">
                            <img src="{{ asset('img/product/rakk_kusog.png') }}" alt="Right Image" class="img-fluid">
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /HOT DEAL SECTION -->


    
 

    
    <!--Other product-->
    <section class="pt-60 pb-30">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section-title">
                        <h2>Other collections</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding mb-30">
                        <a href="product-details.html">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/rakk_naya_case.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>Rakk Naya</h3>
                                <h4>PC Case</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">$70.00</span>
                                    <span class="old_price">$80.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding mb-30">
                        <a href="product-details.html">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/rakk_pirah.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>RAKK Pirah</h3>
                                <h4>Mouse</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">$70.00</span>
                                    <span class="old_price">$80.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="single-tranding mb-30">
                        <a href="product-details.html">
                            <div class="tranding-pro-img">
                                <img src="{{asset('img/product/rakk_klare.png') }}" alt="">
                            </div>
                            <div class="tranding-pro-title">
                                <h3>RAKK Klare</h3>
                                <h4>Headset</h4>
                            </div>
                            <div class="tranding-pro-price">
                                <div class="price_box">
                                    <span class="current_price">$70.00</span>
                                    <span class="old_price">$80.00</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--Other product-->

    <!--Testimonials-->
    <section class="pb-60 pt-60 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="testimonial_are">
                        <div class="testimonial_active owl-carousel">       
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="{{asset('img/about/team-3.jpg') }}" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45</p>
                                        <h3><a href="#">Kathy Young</a><span> - CEO of SunPark</span></h3>
                                    </figcaption>
                                    
                                </figure>
                            </article> 
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="{{asset('img/about/team-1.jpg') }}" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even</p>
                                        <h3><a href="#">John Sullivan</a><span> - Customer</span></h3>
                                    </figcaption>
                                    
                                </figure>
                            </article> 
                            <article class="single_testimonial">
                                <figure>
                                    <div class="testimonial_thumb">
                                        <a href="#"><img src="{{asset('img/about/team-2.jpg') }}" alt=""></a>
                                    </div>
                                    <figcaption class="testimonial_content">
                                        <p>College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites</p>
                                        <h3><a href="#">Jenifer Brown</a><span> - Manager of AZ</span></h3>
                                    </figcaption>
                                    
                                </figure>
                            </article>      
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </section><!--/Testimonials-->

   
    <!--shipping area start-->
    <section class="shipping_area">
        <div class="container">
            <div class=" row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="{{asset('img/about/shipping1.png') }}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Free Shipping</h2>
                            <p>Free shipping on all US order</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="{{asset('img/about/shipping2.png') }}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Support 24/7</h2>
                            <p>Contact us 24 hours a day</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="{{asset('img/about/shipping3.png') }}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>100% Money Back</h2>
                            <p>You have 30 days to Return</p>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="single_shipping">
                        <div class="shipping_icone">
                            <img src="{{asset('img/about/shipping4.png') }}" alt="">
                        </div>
                        <div class="shipping_content">
                            <h2>Payment Secure</h2>
                            <p>We ensure secure payment</p>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
    </section>
    <!--shipping area end-->
    @section('scripts')

<script src="{{ asset('js/V2/jquery.min.js') }}"></script>
<script src="{{ asset('js/V2/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/V2/slick.min.js') }}"></script>
<script src="{{ asset('js/V2/nouislider.min.js') }}"></script>

<script src="{{ asset('js/V2/jquery.zoom.min.js') }}"></script>

<script src="{{ asset('js/V2/main.js') }}"></script>
<script src="{{ asset('js/chat-widget.js') }}"></script>

@endsection
@endsection