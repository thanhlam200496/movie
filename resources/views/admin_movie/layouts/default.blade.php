<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from flixtv.volkovdesign.com/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 08:12:32 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="{{asset('admins/css/bootstrap-reboot.min.css')}}">
	<link rel="stylesheet" href="{{asset('admins/css/bootstrap-grid.min.css')}}">
	<link rel="stylesheet" href="{{asset('admins/css/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{asset('admins/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('admins/css/admin.css')}}">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="{{asset('admins/icon/favicon-32x32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('admins/icon/favicon-32x32.png')}}">

	{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
	@stack('styles')

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>
		@yield('titlte'){{-- FlixTV – Movies & TV Shows, Online cinema HTML Template --}}
	</title>

</head>
<body>
	<!-- header -->
	<header class="header">
		<div class="header__content">
			<!-- header logo -->
			<a href="index.html" class="header__logo">
				<img src="{{asset('admins/img/logo.svg')}}" alt="">
			</a>
			<!-- end header logo -->

			<!-- header menu btn -->
			<button class="header__btn" type="button">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<!-- end header menu btn -->
		</div>
	</header>
	<!-- end header -->

	<!-- sidebar -->
	@include('admin_movie.layouts.sidebar')
	<!-- end sidebar -->

	<!-- main content -->
	<main class="main">
		<div class="container-fluid">
			@yield('main')
		</div>
	</main>
	<!-- end main content -->

	<!-- JS -->
	<script src="{{asset('admins/js/jquery-3.5.1.min.js')}}"></script>
	<script src="{{asset('admins/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('admins/js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{asset('admins/js/smooth-scrollbar.js')}}"></script>
	<script src="{{asset('admins/js/select2.min.js')}}"></script>
	<script src="{{asset('admins/js/admin.js')}}"></script>
	@stack('script')
	
</body>

<!-- Mirrored from flixtv.volkovdesign.com/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 08:12:39 GMT -->
</html>