@extends('layout.layout')

@section('content')
<!--faq area start-->
<div class="faq_content_area">
    <div class="container">   
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="faq_content_wrapper">
                    <h3>Frequently Asked Questions</h3>
                    <p>We’ve compiled a list of frequently asked questions to help you get the information you need quickly. If you can't find what you're looking for, feel free to contact our support team for further assistance.</p>
                </div>
            </div>
        </div> 
    </div>    
</div>
<!--Accordion area-->
<div class="accordion_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-12"> 
                <div id="accordion" class="card__accordion">
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingOne">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is the warranty on your products?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>

                            </button>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>All of our products come with a 1-year warranty, covering defects in material or workmanship. If your product is faulty, we will repair or replace it at no cost within the warranty period. Please refer to our warranty policy for more details.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingTwo">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How do I return an item?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>

                            </button>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <p>To return an item, please visit our returns page and complete the return form. You’ll need to provide proof of purchase and the reason for the return. Once your return is processed, we’ll send you the return instructions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingThree">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Do you ship internationally?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <p>Yes, we ship to most countries worldwide. Shipping fees and delivery times vary depending on your location. You can find more information on our shipping policy page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingfour">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                How do I track my order?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div id="collapseeight" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                            <div class="card-body">
                                <p>Once your order has shipped, you will receive an email with tracking information. You can also log into your account to view the status of your order and track its progress.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingfive">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                Can I cancel my order?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div id="collapseseven" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                            <div class="card-body">
                                <p>You can cancel your order within 24 hours of placing it. After that period, orders are processed and shipped, and cancellations are no longer possible. Please refer to our order cancellation policy for more information.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card card_dipult">
                        <div class="card-header card_accor" id="headingsix">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                Do you offer gift cards?

                                <i class="fa fa-plus"></i>
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div id="collapsefour" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
                            <div class="card-body">
                                <p>Yes, we offer digital gift cards in various denominations. You can purchase them directly from our website, and they can be used for any of our products.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!--Accordion area end-->
<!--faq area end-->

@endsection