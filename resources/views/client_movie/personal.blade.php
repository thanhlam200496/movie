@extends('client_movie.layouts.default')
@push('style')
    <style>
        .site-header {
            margin-bottom: 70px;
            position:unset;
        }
    </style>
@endpush
@section('content')
    <div id="content" class="site-content">

        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div class="profile-header site-header">
                    <div class="row row-eq-height header-top">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img alt=''
                                    src='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg'
                                    srcset='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 226w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 452w'
                                    class='avatar avatar-96 photo avatar-default img-thumbnail avatar' height='96'
                                    width='96' decoding='async' />
                            </div>
                            <div class="user-info">
                                <h5>{{ Auth::user()->name }}</h5>
                                <p class="address"></p>

                            </div>
                        </div>
                        {{-- <div class="update-nember">
                            <a href="https://streamvid.jwsuperthemes.com/pricing/" class="btn-main button-default">
                                Upgrade Premium <img
                                    src="https://streamvid.jwsuperthemes.com/wp-content/plugins/jws-streamvid/public/assets/images/icon_premium.svg" />
                            </a>
                        </div> --}}
                    </div>
                    <div class="row header-bottom">
                        <div class="col-xl-8 col-lg-8 col-12 h-left">

                            <ul class="nav">


                                <li class="nav-item nav-favorites"><a class="item-favorites active"
                                        href="https://streamvid.jwsuperthemes.com/author/emily/favorites"> <span
                                            class="menu-text">Yêu thích</span></a></li>
                                <li class="nav-item nav-history"><a class="item-history" id="item-history"
                                        href="#"> <span
                                            class="menu-text">Đã xem</span></a></li>
                                <li class="nav-item nav-playlist"><a class="item-playlist"
                                        href="https://streamvid.jwsuperthemes.com/author/emily/playlist"> <span
                                            class="menu-text">Xem sau</span></a></li>

                            </ul>


                        </div>
                        <div class="col-xl-4 col-lg-4 col-12 h-right">
                        </div>
                    </div>

                </div>

                <article id="post-56" class="post-56 page type-page status-publish hentry pmpro-has-access">

                    <div class="entry-content">
                        <div data-elementor-type="wp-page" data-elementor-id="56" class="elementor elementor-56">

                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-bad085a elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="bad085a" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-cd598f7"
                                        data-id="cd598f7" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-9a50e82 elementor-widget elementor-widget-heading"
                                                data-id="9a50e82" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">
                                                        Movie yêu thích</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-51ea9ee"
                                        data-id="51ea9ee" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-4b8eaf6 elementor-align-right elementor-widget elementor-widget-button"
                                                data-id="4b8eaf6" data-element_type="widget"
                                                data-widget_type="button.default">
                                                <div class="elementor-widget-container">
                                                    <div class="elementor-button-wrapper">
                                                        <a class="elementor-button elementor-button-link elementor-size-sm"
                                                            href="#">
                                                            <span class="elementor-button-content-wrapper">
                                                                <span class="elementor-button-icon">
                                                                    <i aria-hidden="true"
                                                                        class="  jws-icon-caret-right"></i> </span>
                                                                <span class="elementor-button-text">View all</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-f2d7d0f elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="f2d7d0f" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7e55fc3"
                                        data-id="7e55fc3" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-bfa9843 elementor-widget elementor-widget-jws_movies_advanced"
                                                data-id="bfa9843" data-element_type="widget"
                                                data-widget_type="jws_movies_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-movies_advanced-element">


                                                        <div class="row movies_advanced_content layout6 movies_advanced_ajax_bfa9843 jws_has_pagination owl-carousel jws_movies_advanced_slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "center":false,                "loop":false,                "autoWidth":true,                "smartSpeed": 750,                "responsive":{        "1500":{"items": 1,"slideBy": 1},        "1024":{"items": 1,"slideBy": 1},        "768":{"items": 1,"slideBy": 1},        "0":{"items": 1,"slideBy": 1}    }}'>
                                                            @foreach ($favoriteMovies as $movie)
                                                                <div class="jws-post-item slider-item">
                                                                    <div class="post-inner hover-video">

                                                                        <div class="post-media"
                                                                            data-trailer="{{ $movie->trailer_url }}">
                                                                            <a
                                                                                href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                <img class='attachment-630x400 size-630x400'
                                                                                    alt=''
                                                                                    src="/timthumb.php?src={{ $movie->poster_url != null ? Storage::url('public/images/' . $movie->poster_url) : $movie->link_poster_internet }}&w=288&h=183">
                                                                            </a>

                                                                        </div>
                                                                        <div class="videos-content">
                                                                            <h6 class="video_title">
                                                                                <a
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                    {{ $movie->title }}
                                                                            </h6>

                                                                            <div class="video-meta">
                                                                                <div class="video-years">
                                                                                    {{ $movie->release_year }}</div>
                                                                                <div class="video-time">
                                                                                    {{ $movie->duration }}</div>
                                                                                <div class="video-badge">
                                                                                    {{ $movie->type_film }}</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="popup-detail">
                                                                            <h6 class="video_title">
                                                                                <a
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                    {{ $movie->title }} </a>
                                                                            </h6>

                                                                            <div class="video-meta">
                                                                                <div class="video-years">
                                                                                    {{ $movie->title }}</div>
                                                                                <div class="video-time">
                                                                                    {{ $movie->duration }}</div>
                                                                                <div class="video-badge">
                                                                                    {{ $movie->type_film }}</div>
                                                                            </div>
                                                                            <div class="video-cat">
                                                                                @foreach ($movie->categories->unique('id') as $category)
                                                                                    <a href="../movies_cat/action/index.html"
                                                                                        rel="tag">{{ $category->name }}</a>
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="video-play">
                                                                                <a class="btn-main jws-popup-detail"
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}"
                                                                                    data-post-id="9053">
                                                                                    <span>View Detail</span>
                                                                                    <i class="jws-icon-info-light"></i>
                                                                                </a>
                                                                                <a class="btn-main button-custom watchlist-add"
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}"
                                                                                    data-post-id="9053">
                                                                                    <span class="added">Watchlisted</span>
                                                                                    <span>Watch Later</span>
                                                                                    <i
                                                                                        class="jws-icon-bookmark-simple"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-8f0c8a2 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="8f0c8a2" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-f3853b2"
                                        data-id="f3853b2" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-73c2041 elementor-widget elementor-widget-heading"
                                                data-id="73c2041" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">
                                                        TV Series yêu thích
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-47833d8"
                                        data-id="47833d8" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-c44865e elementor-align-right elementor-widget elementor-widget-button"
                                                data-id="c44865e" data-element_type="widget"
                                                data-widget_type="button.default">
                                                <div class="elementor-widget-container">
                                                    <div class="elementor-button-wrapper">
                                                        <a class="elementor-button elementor-button-link elementor-size-sm"
                                                            href="#">
                                                            <span class="elementor-button-content-wrapper">
                                                                <span class="elementor-button-icon">
                                                                    <i aria-hidden="true"
                                                                        class="  jws-icon-caret-right"></i> </span>
                                                                <span class="elementor-button-text">View all</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-c2e5ec0 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="c2e5ec0" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a2cd7cc"
                                        data-id="a2cd7cc" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-cc7e695 elementor-widget elementor-widget-jws_movies_advanced"
                                                data-id="cc7e695" data-element_type="widget"
                                                data-widget_type="jws_movies_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-movies_advanced-element">


                                                        <div class="row movies_advanced_content layout1 movies_advanced_ajax_cc7e695 jws_has_pagination owl-carousel jws_movies_advanced_slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "center":false,                "loop":false,                "autoWidth":true,                "smartSpeed": 750,                "responsive":{        "1500":{"items": 1,"slideBy": 1},        "1024":{"items": 1,"slideBy": 1},        "768":{"items": 1,"slideBy": 1},        "0":{"items": 1,"slideBy": 1}    }}'>
                                                            @foreach ($favoriteFilms as $movie)
                                                                <div class="jws-post-item slider-item">
                                                                    <div class="post-inner">

                                                                        <div class="post-media"
                                                                            data-trailer="{{ $movie->trailer_url }}">
                                                                            <a
                                                                                href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                <img class='attachment-488x680 size-488x680'
                                                                                    alt=''
                                                                                    src="{{ $movie->poster_url != null ? Storage::url('public/images/' . $movie->poster_url) : $movie->link_poster_internet }}">
                                                                            </a>
                                                                            <div class="media-play">
                                                                                <a
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                </a>
                                                                            </div>
                                                                            <a class="btn-right watchlist-add"
                                                                                href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}"
                                                                                data-post-id="8586">
                                                                                <span class="added">Added to My
                                                                                    List</span>
                                                                                <span>Add to My List</span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="movies-content">
                                                                            <h6 class="video_title">
                                                                                <a
                                                                                    href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                    {{ $movie->title }} </a>
                                                                            </h6>
                                                                            <div class="video-meta">
                                                                                <div class="video-years">
                                                                                    {{ $movie->title }}</div>
                                                                                <div class="video-time">
                                                                                    {{ $movie->duration }}
                                                                                </div>
                                                                                <div class="video-badge">
                                                                                    {{ $movie->type_film }}</div>
                                                                            </div>
                                                                            <div class="video-cat">
                                                                                @foreach ($movie->categories->unique('id') as $category)
                                                                                    <a href="../movies_cat/action/index.html"
                                                                                        rel="tag">{{ $category->name }}</a>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>

                        </div>
                    </div><!-- .entry-content -->
                </article><!-- #post-56 -->

            </main>
        </div>

    </div><!-- #content -->
                               <script>

document.addEventListener('DOMContentLoaded', function () {
    const historyBtn = document.getElementById('item-history');

    if (historyBtn) {
        historyBtn.addEventListener('click', function (e) {
            e.preventDefault();
            $.get('')

        });
    } else {
        console.log('Không tìm thấy .item-history');
    }
});

    </script>

@endsection
