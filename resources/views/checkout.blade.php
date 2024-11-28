@extends('layout.layout')

@section('content')
<!--Checkout page section-->
    <div class="Checkout_section mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="user-actions">
                       
                 
                    <div class="user-actions">
                        <h3> 
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            Get any promo code?
                            <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_coupon" aria-expanded="true" aria-controls="checkout_coupon">Click here to enter your code</a>     

                        </h3>
                        <div id="checkout_coupon" class="collapse" data-parent="#accordionExample">
                            <div class="checkout_info">
                                <form action="#">
                                    <input placeholder="Coupon code" type="text">
                                    <button type="submit">Apply coupon</button>
                                </form>
                            </div>
                        </div>    
                    </div>    
                </div>
            </div>
            <div class="checkout_form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <h3>Billing Details</h3>
                            <div class="row">

                                <div class="col-lg-6 mb-20">
                                    <label>First Name <span>*</span></label>
                                    <input type="text" name="billing_first_name" required>    
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <label>Last Name  <span>*</span></label>
                                    <input type="text" name="billing_last_name" required> 
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Company Name</label>
                                    <input type="text" name="billing_company">     
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="country">Country <span>*</span></label>
                                    <select class="niceselect_option" name="billing_country" id="country"> 
                                        <option value="afghanistan">Afghanistan</option>
                                        <option value="albania">Albania</option>
                                        <option value="algeria">Algeria</option>
                                        <option value="bahrain">Bahrain</option>
                                        <option value="bangladesh">Bangladesh</option>
                                        <option value="china">China</option>
                                        <option value="colombia">Colombia</option>
                                        <option value="germany">Germany</option>
                                        <option value="ghana">Ghana</option>
                                        <option value="india">India</option>
                                        <option value="japan">Japan</option>
                                        <option value="philippines">Philippines</option>
                                        <option value="united_kingdom">United Kingdom</option>
                                        <option value="united_states">United States</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-20">
                                    <label>Street address  <span>*</span></label>
                                    <input placeholder="House number and street name" type="text" name="billing_address" required>     
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Town / City <span>*</span></label>
                                    <input  type="text" name="billing_city" required>    
                                </div> 
                                <div class="col-12 mb-20">
                                    <label>State / County <span>*</span></label>
                                    <input type="text" name="billing_state">    
                                </div> 
                                <div class="col-12 mb-20">
                                    <label>Zip / Postal Code<span>*</span></label>
                                    <input type="text" name="billing_zip">    
                                </div> 
                                <div class="col-lg-6 mb-20">
                                    <label>Phone<span>*</span></label>
                                    <input type="text" name="billing_phone" required> 

                                </div> 
                                <div class="col-lg-6 mb-20">
                                    <label> Email Address   <span>*</span></label>
                                    <input type="email" name="billing_email" required> 

                                </div> 

                                <div class="col-12 mb-20 accordion" id="accordionExample">
                                    <input id="address" type="checkbox" data-target="createp_account" name="ship_to_different_address"/>
                                    <label class="righ_0" for="address"  data-toggle="collapse" data-target="#collapseTwo" aria-controls="collapseTwo">Ship to a different address?</label>

                                    <div id="collapseTwo" class="collapse" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-lg-6 mb-20">
                                                <label>First Name <span>*</span></label>
                                                <input type="text" name="shipping_first_name">    
                                            </div>
                                            <div class="col-lg-6 mb-20">
                                                <label>Last Name  <span>*</span></label>
                                                <input type="text" name="shipping_last_name"> 
                                            </div>
                                            <div class="col-12 mb-20">
                                                <label>Company Name</label>
                                                <input type="text" name="shipping_company">     
                                            </div>
                                            <div class="col-12 mb-20">
                                                <div class="select_form_select">
                                                    <label for="countru_name">country <span>*</span></label>
                                                    <select class="niceselect_option" name="shipping_country" id="countru_name"> 
                                                        <option value="afghanistan">Afghanistan</option>
                                                        <option value="albania">Albania</option>
                                                        <option value="algeria">Algeria</option>
                                                        <option value="bahrain">Bahrain</option>
                                                        <option value="bangladesh">Bangladesh</option>
                                                        <option value="china">China</option>
                                                        <option value="colombia">Colombia</option>
                                                        <option value="germany">Germany</option>
                                                        <option value="ghana">Ghana</option>
                                                        <option value="india">India</option>
                                                        <option value="japan">Japan</option>
                                                        <option value="philippines">Philippines</option>
                                                        <option value="united_kingdom">United Kingdom</option>
                                                        <option value="united_states">United States</option> 
                                                    </select>
                                                </div> 
                                            </div>

                                            <div class="col-12 mb-20">
                                                <label>Street address  <span>*</span></label>
                                                <input placeholder="House number and street name" type="text" name="shipping_address">     
                                            </div>
                                            <div class="col-12 mb-20">
                                                <label>Town / City <span>*</span></label>
                                                <input  type="text" name="shipping_city">    
                                            </div> 
                                            <div class="col-12 mb-20">
                                                <label>State / County <span>*</span></label>
                                                <input type="text" name="shipping_state">    
                                            </div> 
                                            <div class="col-12 mb-20">
                                                <label>Zip / Postal Code<span>*</span></label>
                                                <input type="text" name="shipping_zip">    
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-notes">
                                        <label for="order_note">Order Notes</label>
                                        <textarea id="order_note" rows="2" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                    </div>    
                                </div>     	    	    	    	    	    	    
                            </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                            <h3>Your order</h3> 
                            <div class="order_table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name }} <strong>× {{ $item->quantity }}</strong></td>
                                                <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cart Subtotal</th>
                                            <td>₱{{ number_format($cart->items->sum(fn($item) => $item->price * $item->quantity), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td><strong>₱{{ number_format(50, 2) }}</strong></td>
                                        </tr>
                                        <tr class="order_total">
                                            <th>Order Total</th>
                                            <td><strong>₱{{ number_format($cart->items->sum(fn($item) => $item->price * $item->quantity) + 50, 2) }}</strong></td>
                                            <input name="total_price" type="hidden" value="{{ number_format($cart->items->sum(fn($item) => $item->price * $item->quantity) + 50, 2) }}"/>
                                        </tr>
                                    </tfoot>
                                </table>     
                            </div>
                            <div class="payment_method">
                                <div class="panel-default">
                                    <input id="payment_direct" name="payment_method" value="direct_bank" type="radio" data-target="createp_account" required/>
                                    <label for="payment_direct" data-toggle="collapse" data-target="#collapseThree" aria-controls="collapseThree">Direct bank transfer</label>

                                    <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body1">
                                            <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                        </div>
                                    </div>
                                </div> 
                                <div class="panel-default">
                                    <input id="payment_paypal" name="payment_method" value="paypal" type="radio" data-target="createp_account" required/>
                                    <label for="payment_paypal" data-toggle="collapse" data-target="#collapsePaypal" aria-controls="collapsePaypal">PayPal <img src="assets/img/icon/papyel.png" alt=""></label>

                                    <div id="collapsePaypal" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body1">
                                            <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal. <a href="#">What is Paypal?</a></p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-default">
                                    <input id="payment_gcash" name="payment_method" value="gcash" type="radio" data-target="createp_account" required/>
                                    <label for="payment_gcash" data-toggle="collapse" data-target="#collapseGcash" aria-controls="collapseGcash">Gcash <img src="assets/img/icon/papyel.png" alt=""></label>

                                    <div id="collapseGcash" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body1">
                                            <p>Pay via Gcash online. <a href="#">What is Gcash?</a></p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="order_button">
                                    <button type="submit">Proceed to buy</button> 
                                </div>    
                            </div>
                        </form>         
                    </div>
                </div> 
            </div> 
        </div>       
    </div>
    <!--Checkout page section end-->

<script>
    document.getElementById('ship_to_different_address').addEventListener('change', function() {
        const shippingDetails = document.getElementById('shipping_details');
        shippingDetails.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection