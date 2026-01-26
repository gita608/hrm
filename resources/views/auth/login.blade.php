<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ \App\Helpers\SettingsHelper::appName() }} - HRM System">
	<meta name="keywords" content="HRM, HR Management, Employee Management">
	<meta name="author" content="{{ \App\Helpers\SettingsHelper::appName() }}">
	<title>Login | {{ \App\Helpers\SettingsHelper::appName() }}</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	
	<!-- Login Page Responsive Styles -->
	<style>
		/* Login Page Responsive Styles */
		@media (max-width: 991.98px) {
			.login-form-content {
				padding: 1rem 0;
			}
		}

		@media (max-width: 575.98px) {
			.login-form-content {
				padding: 0.5rem 0;
			}
			
			.login-form-content h2 {
				font-size: 1.5rem !important;
			}
			
			.login-form-content .form-label {
				font-size: 0.9rem;
			}
			
			.login-form-content .btn {
				font-size: 0.95rem;
				padding: 0.75rem;
			}
		}

		/* Fix for mobile viewport height issues */
		@supports (-webkit-touch-callout: none) {
			.min-vh-100 {
				min-height: -webkit-fill-available;
			}
		}

		/* Ensure form inputs are touch-friendly on mobile */
		@media (max-width: 575.98px) {
			.form-control,
			.btn {
				min-height: 44px;
				font-size: 16px; /* Prevents zoom on iOS */
			}
		}

		/* Logo responsive adjustments */
		@media (max-width: 575.98px) {
			.login-form-content img {
				max-height: 140px !important;
			}
		}

		@media (min-width: 576px) and (max-width: 767.98px) {
			.login-form-content img {
				max-height: 180px !important;
			}
		}
		
		@media (min-width: 768px) {
			.login-form-content img {
				max-height: 200px !important;
			}
		}
	</style>
</head>

<body class="bg-white">

	<div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<div class="container-fluid">
			<div class="w-100 overflow-hidden position-relative flex-wrap d-block min-vh-100">
				<div class="row g-0">
					<div class="col-lg-5">
						<div class="login-background position-relative d-lg-flex align-items-center justify-content-center d-none flex-wrap min-vh-100">
							<div class="bg-overlay-img">
								<img src="{{ asset('assets/img/bg/bg-blue-01.svg') }}" class="bg-1" alt="Img">
								<img src="{{ asset('assets/img/bg/bg-green-01.svg') }}" class="bg-2" alt="Img">
							</div>
							<div class="authentication-card w-100">
								<div class="authen-overlay-item border w-100">
									<h1 class="text-white display-1">Empowering people <br> through seamless HR <br> management.</h1>
									<div class="my-4 mx-auto authen-overlay-img">
										<img src="{{ asset('assets/img/bg/modern-bg.png') }}" alt="Img">
									</div>
									<div>
										<p class="text-white fs-20 fw-semibold text-center">Efficiently manage your workforce, streamline <br> operations effortlessly.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-12">
						<div class="row justify-content-center align-items-center min-vh-100 py-4 py-lg-0">
							<div class="col-12 col-sm-10 col-md-8 col-lg-10 col-xl-8 mx-auto px-3 px-md-4">
								<form action="{{ route('login') }}" method="POST" class="d-flex flex-column min-vh-100 justify-content-center">
									@csrf
									@if($errors->any())
										<div class="alert alert-danger mb-3">
											<ul class="mb-0">
												@foreach($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									@endif

									<div class="login-form-content">
										<div class="text-center mb-4 mb-md-5">
											@if(\App\Helpers\SettingsHelper::appLogo())
												<div class="mb-4 d-flex flex-column align-items-center justify-content-center mx-auto" 
													 style="max-width: 100%; width: 100%; max-width: 400px; padding: 15px;">
													<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}"
														alt="{{ \App\Helpers\SettingsHelper::appName() }}" 
														class="img-fluid"
														style="max-width: 100%; max-height: 200px; width: auto; height: auto; object-fit: contain; display: block;">
												</div>
											@endif
											<h2 class="mb-2 fs-2 fw-bold">Sign In</h2>
											<p class="mb-0 text-muted">Please enter your details to sign in</p>
										</div>
											<div class="mb-3">
												<label class="form-label">Email Address</label>
												<div class="input-group">
													<input type="email" name="email" value="{{ old("email") }}" class="form-control border-end-0 @error("email") is-invalid @enderror" required autofocus>
													<span class="input-group-text border-start-0">
														<i class="ti ti-mail"></i>
													</span>
												</div>
											</div>
											<div class="mb-3">
												<label class="form-label">Password</label>
												<div class="pass-group">
													<input type="password" name="password" class="pass-input form-control @error("password") is-invalid @enderror" required>
													<span class="ti toggle-password ti-eye-off"></span>
												</div>
											</div>
											<div class="d-flex align-items-center justify-content-between mb-3">
												<div class="d-flex align-items-center">
													<div class="form-check form-check-md mb-0">
														<input class="form-check-input" id="remember_me" name="remember" type="checkbox" {{ old("remember") ? "checked" : "" }}>
														<label for="remember_me" class="form-check-label mt-0">Remember Me</label>
													</div>
												</div>
												<div class="text-end">
													<a href="#" class="link-danger">Forgot Password?</a>
												</div>
											</div>
											<div class="mb-3">
												<button type="submit" class="btn btn-primary w-100">Sign In</button>
											</div>
											<div class="text-center">
												<h6 class="fw-normal text-dark mb-0">Don’t have an account? 
													<a href="#" class="hover-a"> Create Account</a>
												</h6>
											</div>
										</div>
                                        <div class="mt-5 pb-4 text-center">
											<p class="mb-0 text-gray-9">Copyright &copy; {{ date('Y') }} - {{ \App\Helpers\SettingsHelper::appName() }}</p>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

	<!-- Feather Icon JS -->
	<script src="{{ asset('assets/js/feather.min.js') }}"></script>

	<!-- Custom JS -->
	<script src="{{ asset('assets/js/script.js') }}"></script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"d05194593ce14c8fa5c20a9737ff5d07","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>