@extends('layout.layout')
@section('plugins')
<link rel="stylesheet" href="{{ asset('css/V2/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/slick.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/V2/font-awesome.min.css') }}">
<link type="text/css" rel="stylesheet" href="css/V2/style.css"/>
@endsection
@section('content')
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Categories</h3>
							<div class="checkbox-filter">

								<div class="input-checkbox">
									<input type="checkbox" id="category-1">
									<label for="category-1">
										<span></span>
										Mouse
										<small>(120)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-2">
									<label for="category-2">
										<span></span>
										Keyboard
										<small>(740)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-3">
									<label for="category-3">
										<span></span>
										Headset
										<small>(1450)</small>
									</label>
								</div>

								<div class="input-checkbox">
									<input type="checkbox" id="category-4">
									<label for="category-4">
										<span></span>
										PC Case
										<small>(578)</small>
									</label>
								</div>

							

							
							</div>
						</div>
						<!-- /aside Widget -->

						

						
					</div>
					<!-- /ASIDE -->
<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							
					
						</div>
						<!-- /store top filter -->

						<!-- store products -->
						<div class="row">
							<!-- product -->
                            @foreach($products as $product)
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="{{ Storage::url($product->image_path) }}" alt="">
										
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href="#">{{ $product->name }}</a></h3>
										<h4 class="product-price">₱{{ $product->price }}</h4>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
										
									</div>
									<div class="add-to-cart">
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1" min="1" >
                                            <button type="submit" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                                        </form>
									</div>
								</div>
							</div>
							<!-- /product -->
                            @endforeach
						

							
						</div>
						<!-- /store products -->

					
					</div>
					<!-- /STORE -->
        </div>
    </div>
</div>
@section('scripts')

<script src="{{ asset('js/V2/jquery.min.js') }}"></script>
<script src="{{ asset('js/V2/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/V2/slick.min.js') }}"></script>
<script src="{{ asset('js/V2/nouislider.min.js') }}"></script>

<script src="{{ asset('js/V2/jquery.zoom.min.js') }}"></script>

<script src="{{ asset('js/V2/main.js') }}"></script>

@endsection
@endsection

