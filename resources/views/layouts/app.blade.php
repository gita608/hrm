<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	@include('partials.head')
</head>

<body>

	<div id="global-loader">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		@include('partials.header')
		<!-- /Header -->

		<!-- Sidebar -->
		@include('partials.sidebar')
		<!-- /Sidebar -->


		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				@yield('content')
			</div>

			<!-- Footer -->
			@include('partials.footer')
			<!-- /Footer -->
		</div>
		<!-- /Page Wrapper -->

		<!-- Modals -->
		@include('partials.modals')
		<!-- /Modals -->

	</div>
	<!-- /Main Wrapper -->

	@include('partials.scripts')

</body>

</html>
