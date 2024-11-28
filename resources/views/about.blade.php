@extends('layout.layout')

@section('content')

<!--about section area -->
<section class="about_section mt-60">
    <div class="container">   
        <div class="row align-items-center">
            <div class="col-12">
                <figure>
                    <div class="about_thumb">
                        <img src="assets/img/about/about1.jpg" alt="About Rakk">
                    </div>
                    <figcaption class="about_content">
                        <h1>About Rakk E-commerce</h1>
                        <p>Welcome to Rakk E-commerce, your premier destination for top-quality gaming and PC peripherals. We specialize in providing a curated selection of headsets, mice, keyboards, and PC cases designed to elevate your gaming experience and enhance your workstation. Our mission is to bring you reliable, cutting-edge products that combine performance with style, ensuring your setup is as functional as it is impressive.</p>
                    </figcaption>
                </figure>
            </div>    
        </div>
    </div>    
</section>
<!--about section end-->
       
<!--services img area-->
<div class="about_gallery_section">
    <div class="container">  
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <article class="single_gallery_section">
                    <figure>
                        <div class="gallery_thumb">
                            <img src="assets/img/about/about2.jpg" alt="Our Mission">
                        </div>
                        <figcaption class="about_gallery_content">
                            <h3>What We Do</h3>
                            <p>At Rakk E-commerce, we focus on delivering exceptional gaming gear and PC components that meet the needs of enthusiasts, professionals, and casual users alike. From ergonomic designs to advanced features, each product in our catalog is carefully selected to ensure it meets the highest standards of quality and performance.</p>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-6 col-md-6">
                <article class="single_gallery_section">
                    <figure>
                        <div class="gallery_thumb">
                            <img src="assets/img/about/about3.jpg" alt="Our History">
                        </div>
                        <figcaption class="about_gallery_content">
                            <h3>Our Journey</h3>
                            <p>Rakk E-commerce was founded with a passion for technology and gaming. Over the years, we've grown into a trusted platform for gamers and tech enthusiasts, offering products that blend innovation with reliability. Our commitment to excellence and customer satisfaction drives everything we do.</p>
                        </figcaption>
                    </figure>
                </article>
            </div>
        </div>
    </div>     
</div>
<!--services img end-->       
      
<!--chose us area start-->
<div class="choseus_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="single_chose">
                    <div class="chose_icone">
                        <img src="assets/img/about/About_icon1.png" alt="Money Back Guarantee">
                    </div>
                    <div class="chose_content">
                        <h3>Money-Back Guarantee</h3>
                        <p>Shop with confidence. We provide a hassle-free return policy to ensure your satisfaction with every purchase.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single_chose">
                    <div class="chose_icone">
                        <img src="assets/img/about/About_icon2.png" alt="Modern Design">
                    </div>
                    <div class="chose_content">
                        <h3>Modern Design</h3>
                        <p>Our products feature sleek, contemporary designs that fit seamlessly into any setup, whether for gaming or productivity.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single_chose">
                    <div class="chose_icone">
                        <img src="assets/img/about/About_icon3.png" alt="High Quality">
                    </div>
                    <div class="chose_content">
                        <h3>Uncompromised Quality</h3>
                        <p>We prioritize quality above all, ensuring every item we offer is durable, reliable, and performance-driven.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--chose us area end-->

@endsection
