@extends('layout.layout')
@section('plugins')
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
						<div id="aside" class="col-md-3">
							<div class="aside">
								<h3 class="aside-title">Categories</h3>
								<form id="category-filter" method="GET" action="{{ route('product_list') }}">
									<div class="checkbox-filter">
										@foreach($allCategories as $category)
											<div class="input-checkbox">
												<input 
													type="checkbox" 
													name="categories[]" 
													id="category-{{ $loop->index }}" 
													value="{{ $category }}" 
													{{ in_array($category, $selectedCategories ?? []) ? 'checked' : '' }}
												>
												<label for="category-{{ $loop->index }}">
													<span></span>
													{{ $category }}
													<small>({{ \App\Models\Product::where('category', $category)->count() }})</small>
												</label>
											</div>
										@endforeach
									</div>
								</form>
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
										<img src="{{ $product->image_path }}" alt="{{ $product->name }}">
										
									</div>
									<div class="product-body">
										<p class="product-category">Category</p>
										<h3 class="product-name"><a href=" {{route('product.info', $product->id)}} ">{{ $product->name }}</a></h3>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('#category-filter input[type="checkbox"]');
        const form = document.getElementById('category-filter');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>

@endsection
@endsection

