<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Login/SignUp</title>
</head>
<body>
    <h2>Sign in/up Form</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="{{ route('register') }}" class="sign-up-form" method="POST" id="sign-up-form" onsubmit="checkErrors()">
        @csrf
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" name="name" placeholder="Username" required />
            <x-input-error :messages="$errors->get('name')" class="error-login" />

			<input type="email"  name="email" placeholder="Email" required/>
            <x-input-error :messages="$errors->get('email')" class="error-login" />

			<input type="password" name="password" placeholder="Password" required />
            <x-input-error :messages="$errors->get('password')" class="error-register" />

            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
            <x-input-error :messages="$errors->get('password_confirmation')"   class="error-register" />

			<input type="submit" id="sign-up-btn" value="{{ __('Register') }}"/>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form method="POST" action="{{ route('login') }}" class="sign-in-form"  onsubmit="checkErrors()">
            @csrf
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your account</span>

			<input type="email" name="email" placeholder="Email" required/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

			<input type="password" name="password" placeholder="Password" required/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

			<a href="#">Forgot your password?</a>

			<input type="submit" value="{{ __('Log in') }}" class="btn solid" onclick=""/>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<footer>
	<p>
		Created with <i class="fa fa-heart"></i> by
		<a target="_blank" href="https://florin-pop.com">Florin Pop</a>
		- Read how I created this and how you can join the challenge
		<a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
	</p>
</footer>
<script src=""></script>
@if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($errors->all() as $error)
                    showToast("{{ $error }}", 'error');
                @endforeach
            });

            function showToast(message, type) {
                const toaster = document.getElementById('toaster');

                const toast = document.createElement('div');
                toast.className = 'toast ' + (type === 'error' ? 'toast-error' : 'toast-success');

                const description = document.createElement('div');
                description.className = 'description';
                description.textContent = message;

                const cancelButton = document.createElement('button');
                cancelButton.className = 'cancel-button';
                cancelButton.textContent = 'Dismiss';
                cancelButton.addEventListener('click', () => hideToast(toast));

                toast.appendChild(description);
                toast.appendChild(cancelButton);

                toaster.appendChild(toast);

                setTimeout(() => hideToast(toast), 3000); // Hide toast after 3 seconds
            }

            function hideToast(toast) {
                toast.classList.add('hide');
                toast.addEventListener('transitionend', () => toast.remove());
            }
        </script>
</body>
</html>