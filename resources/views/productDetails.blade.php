@extends('layout.layout')


@section('content')
<!-- product details start -->
<div class="product_details mt-60 mb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product-details-tab">
                    <div id="img-1" class="">
                        <a href="#">
                            <!-- Use the product image from the database -->
                            <img id="zoom1" src="{{ $product->image_path }}" data-zoom-image="{{ $product->image_path }}" alt="big-1">
                        </a>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product_d_right">
                        <h1>{{ $product->name }}</h1>
                        <div class="product_ratting">
                            <ul>
                                @for ($i = 1; $i <= 5; $i++)
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star{{ $i <= round($product->reviews_avg_rating) ? '' : '-o' }}"></i>
                                        </a>
                                    </li>
                                @endfor
                                <li class="review">
                                    <a href="#"> ({{ $product->reviews_count }} reviews) </a>
                                </li>
                            </ul>

                        </div>
                        <div class="price_box">
                            <span class="current_price">${{ number_format($product->price, 2) }}</span>
                            @if ($product->discount_price)
                                <span class="old_price">${{ number_format($product->discount_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="product_desc">
                            <ul>
                                <li>In Stock</li>
                                <li>Free Delivery Code : 'FREEYOUNGTHUG'</li>
                                <li>Sale 30% Off Use Code : 'SPANKMEDADDY'</li>
                            </ul>
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="product_variant quantity">
                            <label>Quantity</label>
                            
                            <form action="{{ route('cart.add') }}" method="POST" >
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input min="1" max="100" value="1" name="quantity" type="number">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                        <div class="product_meta">
                            <span>Category: <a href="#">{{ $product->category }}</a></span>
                        </div>
                    <div class="priduct_social">
                        <ul>
                            <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>
                            <li><a class="twitter" href="#" title="twitter"><i class="fa fa-twitter"></i> Tweet</a></li>
                            <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i> Save</a></li>
                            <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i> Share</a></li>
                            <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i> Linked</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product details end -->

<!-- product info start -->
<div class="product_d_info mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                            </li>
                            <li>
                               <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{ $product->reviews_count }})</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="product_info_content">
                                <p>{{ $product->description }}</p>
                            </div>    
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews_wrapper">  
                                <h2>{{ $product->reviews_count }} reviews for {{ $product->name }}</h2>  
                                @foreach($product->reviews as $review)  
                                    <div class="reviews_comment_box">  
                                        <div class="comment_thmb">  
                                            <!-- Display the profile picture of the user who made the review -->
                                            @if ($review->user && $review->user->profile_pic)
                                                <img src="{{ $review->user->profile_pic }}" alt="{{ $review->user->name }}'s avatar" class="avatar-icon">
                                            @else
                                                <img src="{{ asset('img/blog/comment2.jpg') }}" alt="Default User Avatar">
                                            @endif
                                        </div>  
                                        <div class="comment_text">  
                                            <div class="reviews_meta">  
                                                <div class="star_rating">  
                                                    <ul>  
                                                        @for ($i = 1; $i <= 5; $i++)  
                                                            <li>  
                                                                <i class="ion-ios-star{{ $i <= $review->rating ? '' : '-outline' }}"></i>  
                                                            </li>  
                                                        @endfor  
                                                    </ul>  
                                                </div>  
                                                <p><strong>{{ $review->user->name ?? 'Anonymous' }}</strong> - {{ $review->created_at->format('F d, Y') }}</p>  
                                                <span>{{ $review->review }}</span>  
                                            </div>  
                                        </div>  
                                    </div>  
                                @endforeach  
                            </div>
                            <div class="comment_title">  
                                <h2>Add a review </h2>  
                                <p>Your email address will not be published. Required fields are marked </p>  
                            </div>  

                            <div class="product_ratting mb-10">
                                <h3>Your rating</h3>
                                <ul>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="rating-star" data-value="{{ $i }}">  
                                            <a><i class="fa fa-star-o"></i></a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>

                            <div class="product_review_form">
                                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rating" id="rating" value="5">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="review_comment">Your review </label>
                                            <textarea name="review" id="review_comment" required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TOAST -->
<div class="toast-container position-fixed bottom-0 right-0 p-3" style="z-index: 1050;">
    <div id="toastMessage" class="toast custom-toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
        <div class="toast-body">
            <!-- Success message dynamically injected here -->
            <strong>Success:</strong> Product added to cart!
            <button type="button" class="close ml-3" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>

<!-- END TOAST -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                ratingInput.value = rating;

                // Reset all stars
                stars.forEach(s => {
                    s.querySelector('i').classList.remove('fa-star');
                    s.querySelector('i').classList.add('fa-star-o');
                });

                // Highlight the selected rating
                for (let i = 0; i < rating; i++) {
                    stars[i].querySelector('i').classList.add('fa-star');
                    stars[i].querySelector('i').classList.remove('fa-star-o');
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            // Show the toast
            const toastElement = document.getElementById('toastMessage');
            const toast = new bootstrap.Toast(toastElement);
            toastElement.querySelector('.toast-body').textContent = "{{ session('success') }}";
            toast.show();
        @endif
    });
</script>

<style>
.avatar-icon {
    width: 50px; /* Adjust size as needed */
    height: 50px; /* Maintain aspect ratio */
    border-radius: 50%; /* Makes it circular */
    object-fit: cover; /* Ensures the image fits the circle */
    border: 2px solid #ddd; /* Optional: Adds a border for aesthetics */
}
</style>
@endsection