<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rakk Gears</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('csrf')
    <!-- Favicon -->
    <link href="{{asset('img/rakk_icon.png') }}" rel="icon">

    
    <!-- CSS 
    ========================= -->
   

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('plugins')
</head>

<body>

    <!--header area start-->
    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay">
            
    </div>
    <div class="Offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="canvas_open">
                        <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                    </div>
                    <div class="Offcanvas_menu_wrapper">
                        <div class="canvas_close">
                              <a href="javascript:void(0)"><i class="ion-android-close"></i></a>  
                        </div>
                        <div class="top_right text-right">
                            <ul>
                               <li><a href="{{route('profile.edit')}}"> My Account </a></li> 
                               <li><a href="{{route('cart')}}"> Checkout </a></li> 
                            </ul>
                        </div> 
                        <div class="search_container">
                           <form action="{{ route('product_list') }}">
                                <div class="search_box">
                                    <input placeholder="Search product..." type="text" value="{{ request()->query('search') }}">
                                    <button type="submit">Search</button> 
                                </div>
                            </form>
                        </div> 
                        
                        <div class="middel_right_info">
                            <div class="header_wishlist">
                                <a href="{{route('profile.edit')}}"><img src="{{ asset('img/user.png') }}" alt=""></a>
                            </div>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)"><img src="{{ asset('img/shopping-bag.png') }}" alt=""></a>
                                <!--mini cart-->
                                 <div class="mini_cart">
                                   
                                   
                                  
                                    <div class="mini_cart_footer">
                                       <div class="cart_button">
                                            <a href="{{route('cart')}}">View cart</a>
                                        </div>
                                        <div class="cart_button">
                                            <a href="{{route('my.orders')}}">View Orders</a>
                                        </div>

                                    </div>

                                </div>
                                <!--mini cart end-->
                            </div>
                        </div>
                        <!--mobile view nav-->
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">
                                <li class="menu-item-has-children active">
                                    <a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="{{route('product_list')}}">product</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">pages </a>
                                    <ul class="sub-menu">
                                        @cannot('user')
                                            <li><a href="{{route('admin')}}">Admin</a></li>
                                        @endcannot
										<li><a href="{{route('about')}}">About Us</a></li>
										<li><a href="{{route('warranty')}}">Warranty policy</a></li>
										<li><a href="{{route('faq')}}">Frequently Questions</a></li>
										<li><a href="{{route('cart')}}">cart</a></li>
										<li><a href="{{route('tracking')}}">tracking</a></li>
                                        <li><a href="{{route('forgotPass')}}">Forget Password</a></li>
										<li>
                                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                                <button type="submit" class="btn btn-link p-0" style="text-decoration: none; color: red;">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="menu-item-has-children">
                                    <a href="login.html">my account</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="contact.html"> Contact Us</a> 
                                </li>
                            </ul>
                        </div>

                        <div class="Offcanvas_footer">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Offcanvas menu area end-->
    
    <header>
        <div class="main_header">
            <!--header top start-->
            
            <!--header top start-->
            <!--header middel start-->
            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="logo">
                                <a href="{{route('home')}}"><img src=" {{asset('img/logo/rakk_logo.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6">
                            <div class="middel_right">
                                <div class="search_container">
                                   <form action="{{ route('product_list') }}">
                                        <div class="search_box">
                                            <input placeholder="Search product..." type="text" style="width: 60%; border-bottom: 2px solid #242424;" value="{{ request()->query('search') }}">
                                            <button type="submit">Search</button> 
                                        </div>
                                    </form>
                                </div>
                                <div class="middel_right_info">
                                    <div class="header_wishlist">
                                        <a href="{{route('profile.edit') }}"><img src="{{asset('img/user.png') }}" alt=""></a>
                                    </div>
                                    <div class="mini_cart_wrapper">
                                        <a href="javascript:void(0)"><img src="{{asset('img/shopping-bag.png') }}" alt=""></a>
                                        <!--mini cart-->
                                         <div class="mini_cart">

                                            <div class="mini_cart_footer">
                                               <div class="cart_button">
                                                    <a href="{{route('cart')}}">View cart</a>
                                                </div>
                                                <div class="cart_button">
                                                    <a href="{{route('my.orders')}}">View Orders</a>
                                                </div>

                                            </div>

                                        </div>
                                        <!--mini cart end-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header middel end-->
            <!--header bottom satrt-->
            <div class="main_menu_area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="main_menu menu_position"> 
                                <nav>  
                                    <ul>
                                        <li><a href="{{route('home')}}">home</a></li>
                                        <li><a href="{{route('product_list')}}">Product</a></li>
                                        <!--header pages-->
                                        <li><a class="active" href="#">pages <i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu pages">
                                                @cannot('user')
                                                    <li><a href="{{route('admin')}}">Admin Panel</a></li>
                                                @endcannot
                                                <li><a href="{{route('about')}}">About Us</a></li>
                                                <li><a href="{{route('warranty')}}">warranty policy</a></li>
                                                <li><a href="{{route('faq')}}">Frequently Questions</a></li>
                                                <li><a href="{{route('cart')}}">cart</a></li>
                                                <li><a href="{{route('tracking')}}">tracking</a></li>
                                                <li><a href="{{route('forgotPass')}}">Forget Password</a></li>
                                                <li>
                                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link p-0" style="text-decoration: none; color: red;">Logout</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li><a href="contact.html"> Contact Us</a></li>
                                    </ul>  
                                </nav> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div> 
    </header>
    <!--header area end-->

    <!-------------------------------------------------------------------CONTENT-------------------------------------------------------------------->
    @yield('content')
	<!-------------------------------------------------------------------END CONTENT-------------------------------------------------------------------->
    <!--footer area start-->
    <footer class="footer_widgets">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container contact_us">
                        <div class="footer_logo">
                            <a href="#"><img src="{{asset('img/logo/rakk_logo.png') }}" alt=""></a>
                        </div>
                        <div class="footer_contact">
                            <p>John draw real poor on call my from. May she mrs furnished discourse extremely. Ask doubt noisy shade guest Lose away off why half led have near bed. At engage simple father of period others except</p>
                            <p>Ask doubt noisy shade guest Lose away off why half led have near bed. At engage simple father of period others except</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>Information</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{route('about')}}">About Us</a></li>
                                <li><a href="blog.html">Delivery Information</a></li>
                                <li><a href="contact.html">Warranty Policy</a></li>
                                <li><a href="services.html">Terms & Conditions</a></li>
                                <li><a href="#">Returns</a></li>
                                <li><a href="#">Gift Certificates</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widgets_container widget_menu">
                        <h3>My Account</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order History</a></li>
                                <li><a href="{{route('profile.edit')}}">Wish List</a></li>
                                <li><a href="#">Newsletter</a></li>
                                <li><a href="#">Affiliate</a></li>
                                <li><a href="{{route('warranty')}}">International Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="widgets_container newsletter">
                        <h3>Follow Us</h3>
                        <div class="footer_social_link">
                            <ul>
                                <li><a class="facebook" href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="instagram" href="#" title="instagram"><i class="fa fa-instagram"></i></a></li>
                                <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="rss" href="#" title="rss"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>
                        <div class="subscribe_form">
                            <h3>Join Our Newsletter Now</h3>
                            <form id="mc-form" class="mc-form footer-newsletter" >
                                <input id="mc-email" type="email" autocomplete="off" placeholder="Your email address..." />
                                <button id="mc-submit">Subscribe!</button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts text-centre">
                                <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                            </div><!-- mailchimp-alerts end -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->
<!-- JS
============================================ -->



<!-- Plugins JS -->
<script src="{{ asset('js/plugins.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>

@yield('scripts')

</body>

<!--   03:22:07 GMT -->
</html>