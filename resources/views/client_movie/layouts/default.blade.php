<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from flixtv.volkovdesign.com/main/index3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 08:09:32 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="{{asset('clients/css/bootstrap-reboot.min.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/bootstrap-grid.min.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/slider-radio.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/plyr.css')}}">
	<link rel="stylesheet" href="{{asset('clients/css/main.css')}}">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="{{asset('clients/icon/favicon-32x32.png')}}" sizes="32x32">
	<link rel="apple-touch-icon" href="{{asset('clients/icon/favicon-32x32.png')}}">
{{-- <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" /> --}}
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>FlixTV – Movies & TV Shows, Online cinema HTML Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Tùy chỉnh giao diện nút tua và lùi */
        .plyr__control--seek {
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 8px;
          font-size: 14px;
          line-height: 1;
        }
        .plyr__control--seek svg {
          width: 16px;
          height: 16px;
          fill: currentColor;
        }
      </style>
</head>

<body>
	<!-- header (hidden style) -->
	@include('client_movie.layouts.header')
	<!-- end header -->

	@yield('main')

	<!-- footer -->
	@include('client_movie.layouts.footer')
	<!-- end footer -->

	<!-- JS -->
	<script src="{{asset('clients/js/scripts.js')}}"></script>
	<script src="{{asset('clients/js/jquery-3.5.1.min.js')}}"></script>
	<script src="{{asset('clients/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('clients/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('clients/js/slider-radio.js')}}"></script>
	<script src="{{asset('clients/js/select2.min.js')}}"></script>
	<script src="{{asset('clients/js/smooth-scrollbar.js')}}"></script>
	<script src="{{asset('clients/js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{asset('clients/js/plyr.min.js')}}"></script>
	<script src="{{asset('clients/js/main.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

</body>

<!-- Mirrored from flixtv.volkovdesign.com/main/index3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Nov 2024 08:09:33 GMT -->
</html>
