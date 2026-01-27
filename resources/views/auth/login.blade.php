<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ \App\Helpers\SettingsHelper::appName() }} - HRM System">
	<title>Login | {{ \App\Helpers\SettingsHelper::appName() }}</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

	<style>
		:root {
			--primary: #F26522;
			--primary-hover: #e0551a;
			--bg-gradient: linear-gradient(135deg, #fef2f2 0%, #fff7ed 100%);
			--card-bg: rgba(255, 255, 255, 0.95);
			--text-main: #1f2937;
			--text-muted: #6b7280;
		}

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f8fafc;
			background-image: 
				radial-gradient(at 0% 0%, rgba(242, 101, 34, 0.05) 0px, transparent 50%),
				radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
				radial-gradient(at 100% 100%, rgba(242, 101, 34, 0.05) 0px, transparent 50%),
				radial-gradient(at 0% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0;
            overflow-x: hidden;
		}

		.login-wrapper {
			width: 100%;
			max-width: 1100px;
			padding: 20px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-container {
			background: var(--card-bg);
			border-radius: 24px;
			box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
			overflow: hidden;
			display: flex;
			width: 100%;
			border: 1px solid rgba(255, 255, 255, 0.8);
			backdrop-filter: blur(10px);
		}

		.login-info {
			flex: 1;
			background: linear-gradient(135deg, #f26522 0%, #ff8c52 100%);
			padding: 60px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			color: white;
            position: relative;
            overflow: hidden;
		}

        .login-info::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .login-info::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

		.login-info h1 {
			font-weight: 800;
			font-size: 2.5rem;
			margin-bottom: 20px;
			line-height: 1.2;
            z-index: 1;
		}

		.login-info p {
			font-size: 1.1rem;
			opacity: 0.9;
			line-height: 1.6;
            z-index: 1;
		}

		.login-form-area {
			flex: 1;
			padding: 60px;
			background: white;
		}

		@media (max-width: 991px) {
			.login-info {
				display: none;
			}
			.login-wrapper {
				max-width: 500px;
			}
		}

		.logo-wrapper {
			margin-bottom: 50px;
			display: flex;
			justify-content: center;
		}

		.logo-wrapper img {
			max-height: 80px;
			width: auto;
			object-fit: contain;
			transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		}

		.logo-wrapper img:hover {
			transform: scale(1.08);
		}

		.form-title {
			font-weight: 700;
			font-size: 1.8rem;
			color: var(--text-main);
			margin-bottom: 8px;
		}

		.form-subtitle {
			color: var(--text-muted);
			margin-bottom: 32px;
		}

		.form-label {
			font-weight: 600;
			font-size: 0.875rem;
			color: var(--text-main);
			margin-bottom: 8px;
		}

		.input-group-custom {
			position: relative;
			margin-bottom: 24px;
		}

		.input-group-custom i {
			position: absolute;
			left: 16px;
			top: 50%;
			transform: translateY(-50%);
			color: var(--text-muted);
			font-size: 1.2rem;
			transition: all 0.2s;
            z-index: 10;
		}

		.form-control {
			height: 52px;
			padding: 12px 16px 12px 48px;
			background: #f9fafb;
			border: 1px solid #e5e7eb;
			border-radius: 12px;
			font-size: 0.95rem;
			transition: all 0.2s;
            color: var(--text-main);
		}

		.form-control:focus {
			background: #fff;
			border-color: var(--primary);
			box-shadow: 0 0 0 4px rgba(242, 101, 34, 0.1);
			outline: none;
		}

		.form-control:focus + i {
			color: var(--primary);
		}

		.pass-group {
			position: relative;
		}

		.toggle-password {
			position: absolute;
			right: 16px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: var(--text-muted);
			font-size: 1.1rem;
            z-index: 10;
		}

		.btn-primary {
			background: var(--primary);
			border: none;
			height: 52px;
			border-radius: 12px;
			font-weight: 700;
			font-size: 1rem;
			letter-spacing: 0.5px;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			box-shadow: 0 4px 15px rgba(242, 101, 34, 0.2);
		}

		.btn-primary:hover {
			background: var(--primary-hover);
			transform: translateY(-2px);
			box-shadow: 0 8px 25px rgba(242, 101, 34, 0.3);
		}

		.btn-primary:active {
			transform: translateY(0);
		}

		.form-check-input:checked {
			background-color: var(--primary);
			border-color: var(--primary);
		}

		.forgot-link {
			color: var(--primary);
			text-decoration: none;
			font-weight: 600;
			font-size: 0.875rem;
		}

		.forgot-link:hover {
			text-decoration: underline;
		}

		.create-account {
			margin-top: 32px;
			text-align: center;
			color: var(--text-muted);
			font-size: 0.95rem;
		}

		.create-account a {
			color: var(--primary);
			font-weight: 700;
			text-decoration: none;
		}

		.alert {
			border-radius: 12px;
			padding: 16px;
			border: none;
			margin-bottom: 24px;
		}

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container {
            animation: fadeIn 0.8s ease-out forwards;
        }
	</style>
</head>

<body>
	<div class="login-wrapper">
		<div class="login-container">
			<!-- Left Side Info -->
			<div class="login-info">
				<h1>Empowering your <br>workforce efficiently.</h1>
				<p>Manage your people, payroll, and operations from one intuitive dashboard. Experience the next generation of HR management.</p>
                <div class="mt-auto">
                    <p class="small opacity-75">© {{ date('Y') }} {{ \App\Helpers\SettingsHelper::appName() }}. All rights reserved.</p>
                </div>
			</div>

			<!-- Right Side Form -->
			<div class="login-form-area">
				<div class="logo-wrapper">
					@if(\App\Helpers\SettingsHelper::appLogo())
						<img src="{{ \App\Helpers\SettingsHelper::appLogo() }}" alt="{{ \App\Helpers\SettingsHelper::appName() }}">
					@else
                        <h3 class="fw-bold text-primary">{{ \App\Helpers\SettingsHelper::appName() }}</h3>
                    @endif
				</div>

				<h2 class="form-title">Welcome back</h2>
				<p class="form-subtitle">Please enter your details to sign in.</p>

				@if($errors->any())
					<div class="alert alert-danger">
						<ul class="mb-0 small">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="{{ route('login') }}" method="POST">
					@csrf
					<div class="mb-3">
						<label class="form-label">Email Address</label>
						<div class="input-group-custom">
							<input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@company.com" required autofocus>
							<i class="ti ti-mail"></i>
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label">Password</label>
						<div class="input-group-custom pass-group">
							<input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
							<i class="ti ti-lock"></i>
							<span class="ti ti-eye-off toggle-password" id="toggle-pass"></span>
						</div>
					</div>

					<div class="mb-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
							<label class="form-check-label small fw-medium" for="remember">
								Remember Me
							</label>
						</div>
					</div>

					<button type="submit" class="btn btn-primary w-100">Sign In</button>
				</form>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#toggle-pass').on('click', function() {
				const passInput = $('#password');
				const type = passInput.attr('type') === 'password' ? 'text' : 'password';
				passInput.attr('type', type);
				$(this).toggleClass('ti-eye-off ti-eye');
			});
		});
	</script>
</body>

</html>