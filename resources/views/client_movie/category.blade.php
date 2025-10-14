@extends('client_movie.layouts.default')
@section('title')
    Capy Phim | Danh mục phim - xem phim hay, miễn phí, phim gì cũng có.
@endsection

@section('description')
    Xem phim online chất lượng cao, cập nhật mỗi ngày, tốc độ nhanh. Kho phim mới nhất, đầy đủ thể loại: hành động, tình
    cảm, hoạt hình, kinh dị...!
@endsection
@section('keywords')
    xem phim online, phim mới, phim chiếu rạp
@endsection
@section('main')
    <!-- head -->
    <section class="section section--head">
        <div class="container">
            <div class="row">


                <div class="col-12 col-xl-6">
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb__item"><a href="catalog.html">Catalog</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Category</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end head -->

    <!-- catalog -->
    <div class="catalog catalog--page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="catalog__nav">




                        <div class="catalog__select-wrap">
                            <form id="filter-form" action="{{ route('category.filter') }}" method="get">
                                <select class="catalog__select" name="category">
                                    <option value="">All genres</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($category->id == request()->category) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <select class="catalog__select" name="year">
                                    <option value="">All the years</option>
                                    <option value="1">'50s</option>
                                    <option value="2">'60s</option>
                                    <option value="3">'70s</option>
                                    <option value="4">'80s</option>
                                    <option value="5">'90s</option>
                                    <option value="6">2000-10</option>
                                    <option value="7">2010-20</option>
                                    <option value="8">2021</option>
                                </select>
                                <select class="catalog__select" name="type_film">
                                    <option value="">All the type firm</option>
                                    <option value="TV Show">TV Show</option>
                                    <option value="Movie">Movie</option>

                                </select>
                                <input type="text"
                                    style="padding: 0 0 0 20px; background-color:    #131720; color:#fff; border: none; margin-right: 10px; height: 40px; border-radius: 16px;"
                                    name="search" value="{{ request()->search }}" placeholder="I'm looking for...">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                        viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#2f80ed"
                                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                                    </svg> </button>
                            </form>

                        </div>

                        <div class="slider-radio">
                            <input type="radio" name="grade" id="featured" checked="checked"><label
                                for="featured">Featured</label>
                            <input type="radio" name="grade" id="popular"><label for="popular">Popular</label>
                            <input type="radio" name="grade" id="newest"><label for="newest">Newest</label>
                        </div>

                    </div>

                    <div id="movie-list" class="row row--grid">
                        @foreach ($movies as $movie)
                            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                                <div class="card">
                                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}"
                                        class="card__cover">
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
                                        <button class="card__add" type="submit">

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
                                    <span class="card__rating"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                                        </svg> {{ $movie->rating }}</span>
                                    <h3 class="card__title"><a
                                            href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">{{ $movie->title }}</a>
                                    </h3>
                                    <ul class="card__list">
                                        {{-- <li>Free</li> --}}
                                        <li>{{ $movie->release_year }}</li>
                                        <li>{{ $movie->categories->first()->name ?? null }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button id="load-more" class="catalog__more" data-page="1" type="button">Load more</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end catalog -->


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loadMoreButton = document.getElementById('load-more');
            const movieList = document.getElementById('movie-list');

            function fetchMovies(page) {
                const form = document.getElementById('filter-form');
                const formData = new FormData(form);
                formData.append('page', page);

                const params = new URLSearchParams(formData).toString();

                fetch(`/fetch-movies?${params}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch movies');
                        return response.json();
                    })
                    .then(data => {
                        data.movies.forEach(movie => {
                            const movieCard = `
                    <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                        <div class="card">
                            <a href="/movie/show/${movie.slug}" class="card__cover">
                                <img src="${ '/storage/images/' + movie.poster_url}" alt="${movie.title}">
                            </a>
                            <span class="card__rating">${movie.rating}</span>
                            <h3 class="card__title">
                                <a href="/movie/show/${movie.slug}">${movie.title}</a>
                            </h3>
                        </div>
                    </div>
                `;
                            movieList.insertAdjacentHTML('beforeend', movieCard);
                        });

                        if (data.nextPage) {
                            loadMoreButton.setAttribute('data-page', data.nextPage);
                        } else {
                            loadMoreButton.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error fetching movies:', error));
            }

            // Bắt sự kiện nhấn nút "Load more"
            loadMoreButton.addEventListener('click', () => {
                const nextPage = loadMoreButton.getAttribute('data-page');
                fetchMovies(nextPage);
            });
        });
    </script>
    <script>
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            fetch(form.action + '?' + params, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMovieList = doc.querySelector('#movie-list');
                    movieList.innerHTML = newMovieList.innerHTML;

                    // Reset lại nút load more
                    loadMoreButton.setAttribute('data-page', 2); // Trang tiếp theo sau khi lọc
                    loadMoreButton.style.display = 'inline-block';
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filter-form');
            const movieList = document.getElementById('movie-list');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // chặn form submit mặc định

                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();

                fetch(form.action + '?' + params, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error("Network error");
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newMovieList = doc.querySelector('#movie-list');
                        movieList.innerHTML = newMovieList.innerHTML;
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                    });
            });
        });
    </script>
    <!-- end subscriptions -->
@endsection
