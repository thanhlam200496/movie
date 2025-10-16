@extends('client_movie.layouts.default')
@section('title')
Capy Phim | xem phim hay, miễn phí, phim gì cũng có.
@endsection
@section('description')
    Xem phim online chất lượng cao, cập nhật mỗi ngày, tốc độ nhanh. Kho phim mới nhất, đầy đủ thể loại: hành động, tình cảm, hoạt hình, kinh dị...!

@endsection
@section('keywords')
xem phim online, phim mới, phim chiếu rạp
@endsection
@section('main')
    <!-- home -->
    <div class="home home--title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="home__title"><b>Best Movies</b> of this season</h1>
                </div>
            </div>
        </div>

        <div class="home__carousel owl-carousel" id="flixtv-hero">
            @foreach ($moviesHotInYear as $movie)
                <div class="home__card">
                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}">
<img src="/timthumb.php?src={{  Storage::url('images/' . $movie->poster_url) }}&w=190&h=290"
                                            alt="">
                    </a>
                    <div>
                        <h2>{{ $movie->title }}</h2>
                        <ul>
                            <li>Free</li>
							<li>{{ $movie->release_year }}</li>
							<li>{{ $movie->categories->first()->name ?? null }}</li>
                        </ul>
                    </div>

                    <form action="{{ route('favorite.add') }}" method="post">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">
                        <button class="home__add" type="submit">
                            @if (auth()->check())
                                <?php $dem = 0; ?>
                                @foreach ($favorites as $item)
                                    @if ($item->user_id == auth()->user()->id && $item->movie_id == $movie->id)
                                        <?php $dem += 1; ?>
                                    @endif
                                @endforeach
                                @if ($dem == 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path
                                            d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" height="6.5" width="7.5"
                                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#FFD43B"
                                            d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                    </svg>
                                @endif
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                    <span class="home__rating"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                        </svg> {{ $movie->rating }}</span>
                </div>
            @endforeach



        </div>

        <button class="home__nav home__nav--prev" data-nav="#flixtv-hero" type="button"></button>
        <button class="home__nav home__nav--next" data-nav="#flixtv-hero" type="button"></button>
    </div>
    <!-- end home -->
    <!-- popular -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section__title"><a href="category.html">New release</a></h2>
                </div>

                <div class="col-12">
                    <div class="section__carousel-wrap">
                        <div class="section__carousel owl-carousel" id="newrelease">
                            @foreach ($moviesNew as $movie)
                                <div class="card">
                                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}" class="card__cover">
<img src="/timthumb.php?src={{  Storage::url('images/' . $movie->poster_url) }}&w=190&h=290"
                                            alt="">

                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('favorite.add') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">
                                        <button class="home__add card__add" type="submit">

											@if (auth()->check())
											<?php $dem = 0; ?>
											@foreach ($favorites as $item)
												@if ($item->user_id == auth()->user()->id && $item->movie_id == $movie->id)
													<?php $dem += 1; ?>
												@endif
											@endforeach
											@if ($dem == 0)
											<svg xmlns="http://www.w3.org/2000/svg"
											viewBox="0 0 24 24">
											<path
												d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
										</svg>
											@else
												<svg xmlns="http://www.w3.org/2000/svg" height="6.5" width="7.5"
													viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
													<path fill="#FFD43B"
														d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
												</svg>
											@endif
										@else
										<svg xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 24 24">
										<path
											d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
									</svg>
										@endif
										</button>
                                    </form>
                                    <span class="card__rating"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                                        </svg> {{ $movie->rating }}</span>
                                    <h3 class="card__title"><a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}">{{ $movie->title }}</a></h3>
                                    <ul class="card__list">
                                        <li>Free</li>
										<li>{{ $movie->release_year }}</li>
										<li>{{ $movie->categories->first()->name ?? null }}</li>
                                    </ul>
                                </div>
                            @endforeach



                        </div>

                        <button class="section__nav section__nav--cards section__nav--prev" data-nav="#newrelease"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                        <button class="section__nav section__nav--cards section__nav--next" data-nav="#newrelease"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end popular -->
    <!-- popular -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section__title"><a href="category.html">Popular</a></h2>
                </div>
                <div class="col-12">
                    <div class="section__carousel-wrap">
                        <div class="section__carousel owl-carousel" id="popular">
                            @foreach ($moviesPopular as $movie)
                                <div class="card">
                                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}" class="card__cover">
<img src="/timthumb.php?src={{  Storage::url('images/' . $movie->poster_url) }}&w=190&h=290"
                                            alt="">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('favorite.add') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">
                                        <button class="home__add card__add" type="submit">

											@if (auth()->check())
											<?php $dem = 0; ?>
											@foreach ($favorites as $item)
												@if ($item->user_id == auth()->user()->id && $item->movie_id == $movie->id)
													<?php $dem += 1; ?>
												@endif
											@endforeach
											@if ($dem == 0)
											<svg xmlns="http://www.w3.org/2000/svg"
											viewBox="0 0 24 24">
											<path
												d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
										</svg>
											@else
												<svg xmlns="http://www.w3.org/2000/svg" height="6.5" width="7.5"
													viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
													<path fill="#FFD43B"
														d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
												</svg>
											@endif
										@else
										<svg xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 24 24">
										<path
											d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
									</svg>
										@endif
										</button>
                                    </form>

                                    <span class="card__rating"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                                        </svg> {{ $movie->rating }}</span>
                                    <h3 class="card__title"><a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}">{{ $movie->title }}</a></h3>
                                    <ul class="card__list">
                                        <li>Free</li>
										<li>{{ $movie->release_year }}</li>
										<li>{{ $movie->categories->first()->name ?? null }}</li>
                                    </ul>
                                </div>
                            @endforeach



                        </div>

                        <button class="section__nav section__nav--cards section__nav--prev" data-nav="#popular"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                        <button class="section__nav section__nav--cards section__nav--next" data-nav="#popular"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('.home__add').on('click', function(e) {
                                e.preventDefault(); // Ngăn submit form mặc định

                                var form = $(this).closest('form');
                                var button = $(this);

                                $.ajax({
                                    url: form.attr('action'),
                                    method: 'POST',
                                    data: form.serialize(),
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // Cập nhật giao diện dựa trên action
                                            if (response.action === 'added') {
                                                button.html(`
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="6.5" width="7.5" viewBox="0 0 384 512">
                                                        <path fill="#FFD43B" d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                                    </svg>
                                                `);
                                            } else {
                                                button.html(`
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
                                                    </svg>
                                                `);
                                            }
                                        }
                                    },
                                    error: function(xhr) {
                                        console.log('Error:', xhr);
                                    }
                                });
                            });
                        });
                        </script>
                </div>
            </div>
        </div>
    </section>
	@if (Auth::check())
		<section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section__title"><a href="category.html">Your Favorite</a></h2>
                </div>
                <div class="col-12">
                    <div class="section__carousel-wrap">
                        <div class="section__carousel owl-carousel" id="yourfavorite">
                            @foreach ($favoriteMovies as $movie)
                                <div class="card">
                                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}" class="card__cover">
                                        <img src="/timthumb.php?src={{ $movie->poster_url != null ? Storage::url('public/images/' . $movie->poster_url) : $movie->link_poster_internet }}&w=190&h=290"
                                            alt="">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11 1C16.5228 1 21 5.47716 21 11C21 16.5228 16.5228 21 11 21C5.47716 21 1 16.5228 1 11C1 5.47716 5.47716 1 11 1Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M14.0501 11.4669C13.3211 12.2529 11.3371 13.5829 10.3221 14.0099C10.1601 14.0779 9.74711 14.2219 9.65811 14.2239C9.46911 14.2299 9.28711 14.1239 9.19911 13.9539C9.16511 13.8879 9.06511 13.4569 9.03311 13.2649C8.93811 12.6809 8.88911 11.7739 8.89011 10.8619C8.88911 9.90489 8.94211 8.95489 9.04811 8.37689C9.07611 8.22089 9.15811 7.86189 9.18211 7.80389C9.22711 7.69589 9.30911 7.61089 9.40811 7.55789C9.48411 7.51689 9.57111 7.49489 9.65811 7.49789C9.74711 7.49989 10.1091 7.62689 10.2331 7.67589C11.2111 8.05589 13.2801 9.43389 14.0401 10.2439C14.1081 10.3169 14.2951 10.5129 14.3261 10.5529C14.3971 10.6429 14.4321 10.7519 14.4321 10.8619C14.4321 10.9639 14.4011 11.0679 14.3371 11.1549C14.3041 11.1999 14.1131 11.3999 14.0501 11.4669Z"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('favorite.add') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">
                                        <button class="home__add card__add" type="submit">

											@if (auth()->check())
											<?php $dem = 0; ?>
											@foreach ($favorites as $item)
												@if ($item->user_id == auth()->user()->id && $item->movie_id == $movie->id)
													<?php $dem += 1; ?>
												@endif
											@endforeach
											@if ($dem == 0)
											<svg xmlns="http://www.w3.org/2000/svg"
											viewBox="0 0 24 24">
											<path
												d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
										</svg>
											@else
												<svg xmlns="http://www.w3.org/2000/svg" height="6.5" width="7.5"
													viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
													<path fill="#FFD43B"
														d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
												</svg>
											@endif
										@else
										<svg xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 24 24">
										<path
											d="M16,2H8A3,3,0,0,0,5,5V21a1,1,0,0,0,.5.87,1,1,0,0,0,1,0L12,18.69l5.5,3.18A1,1,0,0,0,18,22a1,1,0,0,0,.5-.13A1,1,0,0,0,19,21V5A3,3,0,0,0,16,2Zm1,17.27-4.5-2.6a1,1,0,0,0-1,0L7,19.27V5A1,1,0,0,1,8,4h8a1,1,0,0,1,1,1Z" />
									</svg>
										@endif
										</button>
                                    </form>

                                    <span class="card__rating"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                                        </svg> {{ $movie->rating }}</span>
                                    <h3 class="card__title"><a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[count($movie->episodes) - 1]->id]) }}">{{ $movie->title }}</a></h3>
                                    <ul class="card__list">
                                        <li>Free</li>
                                        <li>{{ $movie->release_year }}</li>
                                        <li>{{ $movie->categories->first()->name ?? null }}</li>
                                    </ul>
                                </div>
                            @endforeach



                        </div>

                        <button class="section__nav section__nav--cards section__nav--prev" data-nav="#yourfavorite"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.25 7.72559L16.25 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7.2998 1.70124L1.2498 7.72524L7.2998 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                        <button class="section__nav section__nav--cards section__nav--next" data-nav="#yourfavorite"
                            type="button"><svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 7.72559L0.75 7.72559" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9.7002 1.70124L15.7502 7.72524L9.7002 13.7502" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
	@endif

    <!-- end popular -->


@endsection
