<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Login/SignUp</title>
</head>
<body style="background-image: url('{{ asset('img/background-img.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin: 0; display: flex; justify-content: center; align-items: center; font-family: 'Montserrat', sans-serif;">
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

			<input type="email"  name="email" placeholder="Email" required/>
            
			<input type="password" name="password" placeholder="Password" required />

            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

			<button type="submit" id="sign-up-btn" value="{{ __('Register') }}" >Register</button>
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
        
			<input type="password" name="password" placeholder="Password" required/>

			<a href="#">Forgot your password?</a>

			<button type="submit" value="{{ __('Log in') }}" class="btn solid" onclick="">Log In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>Already a member? Log in to access your account.</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Join Rakk and start looking to our high quality products.</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<div id="toaster" class="toaster-container"></div>


<script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('signUp');
    const loginBtn = document.getElementById('signIn');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });


    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
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

                setTimeout(() => hideToast(toast), 60000); // Hide toast after 3 seconds
            }

            function hideToast(toast) {
                toast.classList.add('hide');
                toast.addEventListener('transitionend', () => toast.remove());
            }
        </script>
    @endif
</body>
</html>