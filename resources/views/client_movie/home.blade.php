@extends('client_movie.layouts.default')
@section('title')
    Capy Phim | xem phim hay, miễn phí, phim gì cũng có.
@endsection
@section('description')
    Xem phim online chất lượng cao, cập nhật mỗi ngày, tốc độ nhanh. Kho phim mới nhất, đầy đủ thể loại: hành động, tình
    cảm, hoạt hình, kinh dị...!
@endsection
@section('keywords')
    xem phim online, phim mới, phim chiếu rạp
@endsection
@section('content')
    <!-- home -->
    
    <div id="content" class="site-content">

        <div id="primary" class="content-area">
            <main id="main" class="site-main">


                <article id="post-56" class="post-56 page type-page status-publish hentry pmpro-has-access">

                    <div class="entry-content">
                        <div data-elementor-type="wp-page" data-elementor-id="56" class="elementor elementor-56">
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-bb88c93 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="bb88c93" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-no jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-430f709"
                                        data-id="430f709" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-8f9010a jws-content-horizontal-left jws-content-vertical-at-center elementor-widget elementor-widget-jws_slider_video"
                                                data-id="8f9010a" data-element_type="widget"
                                                data-widget_type="jws_slider_video.default">
                                                <div class="elementor-widget-container">
                                                    <div class="jws-slider_video-element">

                                                        <div class="row slider_video_content layout1 jws_has_pagination has_minification owl-carousel jws_slider_video_slider slider_size_21x9"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "center":false,                "loop":false,                "autoWidth":false,                "smartSpeed": 500,                "responsive":{                    "1024":{"items": 1,"slideBy": 1},                    "768":{"items": 1,"slideBy": 1},                    "0":{"items": 1,"slideBy": 1}            }}'>
                                                            @foreach ($moviesPopular as $movie)
                                                                <div class="jws_slider_video_item slider-item"
                                                                    data-index="1">
                                                                    <div class="video-background-holder">
                                                                        <div style="background-image: url('{{ $movie->poster_url != null ? Storage::url('public/images/' . $movie->poster_url) : $movie->link_poster_internet }}');"
                                                                            class="video-images">

                                                                        </div>
                                                                        <div class="video-player"
                                                                            data-trailer="{{ $movie->trailer_url }}">

                                                                        </div>
                                                                        <div class="video-overlay"></div>
                                                                    </div>

                                                                    <div class="video-content-holder">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="video-inner">
                                                                                    <div class="video-cat">
                                                                                        @foreach ($movie->categories->unique('id') as $category)
                                                                                            <a href="../movies_cat/action/index.html"
                                                                                                rel="tag">{{ $category->name }}</a>
                                                                                            @if ($loop->last != true)
                                                                                                ,
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                    <h3 class="video_title h1">
                                                                                        <a
                                                                                            href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">
                                                                                            {{ $movie->title }} </a>
                                                                                    </h3>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-imdb"><i
                                                                                                class="fas fa-star"></i>{{ $movie->rating }}
                                                                                        </div>
                                                                                        <div class="video-years">
                                                                                            {{ $movie->release_year }}
                                                                                        </div>
                                                                                        <div class="video-time">
                                                                                            {{ $movie->duration }}
                                                                                        </div>
                                                                                        <div class="video-badge">
                                                                                            {{ $movie->type_film }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="video-description">
                                                                                        @if (strlen($movie->description) > 350)
                                                                                            {!! substr($movie->description, 0, 350) !!}...
                                                                                        @else
                                                                                            {!! $movie->description !!}
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="video-play">
                                                                                        <a class="btn-main button-default btn-left"
                                                                                            href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}">Play
                                                                                            Now <i
                                                                                                class="jws-icon-play-circle"></i>
                                                                                        </a>
                                                                                        <a class="btn-right watchlist-add layout1"
                                                                                            href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id]) }}"
                                                                                            data-post-id="9053">
                                                                                            <span>Watch
                                                                                                Later</span><span
                                                                                                class="added">Added
                                                                                                watchlist</span><i
                                                                                                class="jws-icon-bookmark-simple"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>

                                                        <div class="video-action">
                                                            <div class="jws-nav-carousel">
                                                                <div class="jws-button-prev"></div><span
                                                                    class="jws-nav-pre"><span></span></span>
                                                                <div class="jws-button-next"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
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
                                                        Trending Movies</h5>
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
                                                            @foreach ($moviesHotInYear as $movie)
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
                                                    <h5 class="elementor-heading-title elementor-size-default">New
                                                        Release</h5>
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
                                                            @foreach ($moviesNew as $movie)
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
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-cec7b30 elementor-section-full_width elementor-section-content-middle elementor-section-height-default elementor-section-height-default"
                                data-id="cec7b30" data-element_type="section"
                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-1e5f945"
                                        data-id="1e5f945" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-bd43d33 elementor-widget elementor-widget-heading"
                                                data-id="bd43d33" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h2 class="elementor-heading-title elementor-size-default">
                                                        Almost Adults</h2>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-eaa8dd7 elementor-widget__width-initial elementor-widget elementor-widget-text-editor"
                                                data-id="eaa8dd7" data-element_type="widget"
                                                data-widget_type="text-editor.default">
                                                <div class="elementor-widget-container">
                                                    <p>This comedy feature follows two best friends in their final
                                                        year of college while they transition into adulthood. One
                                                        embraces her sexuality and&#8230;.</p>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-1b7bca4 elementor-widget elementor-widget-spacer"
                                                data-id="1b7bca4" data-element_type="widget"
                                                data-widget_type="spacer.default">
                                                <div class="elementor-widget-container">
                                                    <div class="elementor-spacer">
                                                        <div class="elementor-spacer-inner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-824c4af elementor-widget__width-auto elementor-widget elementor-widget-jws-gradient-button"
                                                data-id="824c4af" data-element_type="widget"
                                                data-widget_type="jws-gradient-button.default">
                                                <div class="elementor-widget-container">
                                                    <div class="elementor-button-wrapper">
                                                        <a href="#"
                                                            class="elementor-button-link elementor-button btn-main button-default elementor-size-md"
                                                            role="button">
                                                            <span class="elementor-button-content-wrapper">
                                                                <span
                                                                    class="elementor-button-icon elementor-align-icon-right">
                                                                    <i aria-hidden="true"
                                                                        class="  jws-icon-play-circle"></i>
                                                                </span>
                                                                <span class="elementor-button-text">Play Now</span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-c6d5580 elementor-widget__width-auto elementor-widget elementor-widget-jws_watchlist_button"
                                                data-id="c6d5580" data-element_type="widget"
                                                data-widget_type="jws_watchlist_button.default">
                                                <div class="elementor-widget-container">

                                                    <div class="jws-watchlist-button">
                                                        <div class="jws-watchlist">
                                                            <a class="watchlist-add"
                                                                href="../movie/the-sleeping-angel/index.html"
                                                                data-post-id="244">
                                                                <i class="jws-icon-plus"></i>
                                                                <span>Watchlist</span>
                                                                <span class="added">Watchlisted</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-df4afa5"
                                        data-id="df4afa5" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-a6c4822 elementor-invisible elementor-widget elementor-widget-jws_playlist_trailer"
                                                data-id="a6c4822" data-element_type="widget"
                                                data-settings="{&quot;_animation&quot;:&quot;fadeInRight&quot;}"
                                                data-widget_type="jws_playlist_trailer.default">
                                                <div class="elementor-widget-container">
                                                    <div class="jws_playlist_trailer_element jws-carousel">

                                                        <div class="jws_playlist_trailer"
                                                            data-slick='{        "slidesToShow":1 ,        "slidesToScroll": 1,        "autoplay": false,        "arrows": false,        "dots":false,        "autoplaySpeed": 5000,        "variableWidth":false,        "pauseOnHover":false,        "centerMode":false,        "infinite":true,        "fade":false,        "vertical":false,        "speed": 500,        "responsive":[            {"breakpoint": 1024,"settings":{"slidesToShow": 1,"slidesToScroll": 1}},            {"breakpoint": 768,"settings":{"slidesToShow": 1,"slidesToScroll": 1}}        ]}'>

                                                            <div class=" playlist_trailer-item slick-slide">


                                                                <div class="video-background">
                                                                    <img class='attachment-865x460 size-865x460'
                                                                        alt=''
                                                                        src={{ asset('clients/wp-content/uploads/2023/02/video_trailer-865x460.jpg') }}>
                                                                    <a class="view-video video-trailer"
                                                                        href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <i class="jws-icon-film"></i>
                                                                        <span>Watch Trailer!</span>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                            <div class=" playlist_trailer-item slick-slide">


                                                                <div class="video-background">
                                                                    <img class='attachment-865x460 size-865x460'
                                                                        alt=''
                                                                        src={{ asset('clients/wp-content/uploads/2023/02/joe-neric-Zsqbptb_j-Y-unsplash-865x460.jpg') }}>
                                                                    <a class="view-video video-trailer"
                                                                        href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <i class="jws-icon-film"></i>
                                                                        <span>Watch Trailer!</span>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                            <div class=" playlist_trailer-item slick-slide">


                                                                <div class="video-background">
                                                                    <img class='attachment-865x460 size-865x460'
                                                                        alt=''
                                                                        src={{ asset('clients/wp-content/uploads/2023/02/shane-rounce-DYpiND4Ic0k-unsplash-865x460.jpg') }}>
                                                                    <a class="view-video video-trailer"
                                                                        href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <i class="jws-icon-film"></i>
                                                                        <span>Watch Trailer!</span>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                            <div class=" playlist_trailer-item slick-slide">


                                                                <div class="video-background">
                                                                    <img class='attachment-865x460 size-865x460'
                                                                        alt=''
                                                                        src={{ asset('clients/wp-content/uploads/2023/02/brett-jordan-i_2lTksTm_w-unsplash-865x460.jpg') }}>
                                                                    <a class="view-video video-trailer"
                                                                        href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <i class="jws-icon-film"></i>
                                                                        <span>Watch Trailer!</span>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                            <div class=" playlist_trailer-item slick-slide">


                                                                <div class="video-background">
                                                                    <img class='attachment-865x460 size-865x460'
                                                                        alt=''
                                                                        src={{ asset('clients/wp-content/uploads/2023/06/spider_ex2-865x460.jpg') }}>
                                                                    <a class="view-video video-trailer"
                                                                        href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <i class="jws-icon-film"></i>
                                                                        <span>Watch Trailer!</span>
                                                                    </a>
                                                                </div>

                                                            </div>



                                                        </div>
                                                        <div class="playlist-nav"
                                                            data-slick='{        "slidesToShow":4 ,        "slidesToScroll": 1,        "autoplay": false,        "arrows": true,        "dots":false,        "infinite":true,        "vertical":true,        "verticalSwiping":true,        "speed": 500,        "responsive":[            {"breakpoint": 1024,"settings":{"slidesToShow": 4,"slidesToScroll": 1}},            {"breakpoint": 768,"settings":{"slidesToShow":4,"slidesToScroll":1,"vertical":false}}        ]}'>

                                                            <div class="nav-item">
                                                                <img class='attachment-147x94 size-147x94' alt=''
                                                                    src={{ asset('clients/wp-content/uploads/2023/02/video_trailer-147x94.jpg') }}>
                                                            </div>


                                                            <div class="nav-item">
                                                                <img class='attachment-147x94 size-147x94' alt=''
                                                                    src={{ asset('clients/wp-content/uploads/2023/02/joe-neric-Zsqbptb_j-Y-unsplash-147x94.jpg') }}>
                                                            </div>


                                                            <div class="nav-item">
                                                                <img class='attachment-147x94 size-147x94' alt=''
                                                                    src={{ asset('clients/wp-content/uploads/2023/02/shane-rounce-DYpiND4Ic0k-unsplash-147x94.jpg') }}>
                                                            </div>


                                                            <div class="nav-item">
                                                                <img class='attachment-147x94 size-147x94' alt=''
                                                                    src={{ asset('clients/wp-content/uploads/2023/02/brett-jordan-i_2lTksTm_w-unsplash-147x94.jpg') }}>
                                                            </div>


                                                            <div class="nav-item">
                                                                <img class='attachment-147x94 size-147x94' alt=''
                                                                    src={{ asset('clients/wp-content/uploads/2023/06/spider_ex2-147x94.jpg') }}>
                                                            </div>

                                                            <div class="jws-nav-carousel">
                                                                <div class="nav_prev jws-icon-caret-down"></div>
                                                                <div class="nav_next jws-icon-caret-down"></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-b64594f elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="b64594f" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-589ec24"
                                        data-id="589ec24" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-83cde8d elementor-widget elementor-widget-heading"
                                                data-id="83cde8d" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">Deal
                                                        of the Week</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-72a2275"
                                        data-id="72a2275" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-ea93523 elementor-align-right elementor-widget elementor-widget-button"
                                                data-id="ea93523" data-element_type="widget"
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
                                class="elementor-section elementor-top-section elementor-element elementor-element-726b11d elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="726b11d" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3d90ce7"
                                        data-id="3d90ce7" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-0dc0a68 elementor-widget elementor-widget-jws_movies_advanced"
                                                data-id="0dc0a68" data-element_type="widget"
                                                data-widget_type="jws_movies_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-movies_advanced-element">


                                                        <div class="row movies_advanced_content layout2 movies_advanced_ajax_0dc0a68 jws_has_pagination owl-carousel jws_movies_advanced_slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "center":false,                "loop":false,                "autoWidth":true,                "smartSpeed": 750,                "responsive":{        "1500":{"items": 1,"slideBy": 1},        "1024":{"items": 1,"slideBy": 1},        "768":{"items": 1,"slideBy": 1},        "0":{"items": 1,"slideBy": 1}    }}'>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/intheback-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/man-in-the-black/index.html">
                                                                                Man in The Black </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/man-in-the-black/index.html">
                                                                                Man in The Black </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2021</div>
                                                                            <div class="video-time">1 hr 45 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/man-in-the-black/index.html"
                                                                            data-post-id="8559">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/warlick_of-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/warlock-of-dusk/index.html">
                                                                                Warlock of Dusk </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/warlock-of-dusk/index.html">
                                                                                Warlock of Dusk </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2019</div>
                                                                            <div class="video-time">2 hr 35 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                        </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/warlock-of-dusk/index.html"
                                                                            data-post-id="8561">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/8Vt6mWEReuy4Of61Lnj5Xj704m8-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                Spider Man Memo </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                Spider Man Memo </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="video-time">1 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Enjoy exclusive Amazon Originals as well
                                                                            as popular movies and TV shows for USD
                                                                            120z/month. Watch now, cancel anytime.
                                                                        </div>
                                                                        <a class="watchlist-add"
                                                                            href="../detail/index.html"
                                                                            data-post-id="8586">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/best-frenit-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/best-friend/index.html">
                                                                                Best Friend </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/best-friend/index.html">
                                                                                Best Friend </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2020</div>
                                                                            <div class="video-time">2 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/best-friend/index.html"
                                                                            data-post-id="8567">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/girl_best-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/wide-girl/index.html">
                                                                                Wide Girl </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/wide-girl/index.html">
                                                                                Wide Girl </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="video-time">1 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In ... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/wide-girl/index.html"
                                                                            data-post-id="8584">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/6TeIVKPw7nXXWy2zKmDmlnSwzb7-scaled-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                The White House </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                The White House </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2023</div>
                                                                            <div class="video-time">2 hr 35 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Enjoy exclusive Amazon Originals as well
                                                                            as popular movies and TV shows for USD
                                                                            120z/month. Watch now, cancel anytime.
                                                                        </div>
                                                                        <a class="watchlist-add"
                                                                            href="../detail/index.html"
                                                                            data-post-id="205">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/the_baner-288x400.jpg') }}><span
                                                                            class="jws-premium jws-icon-crown-1"></span>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/the-baker/index.html">
                                                                                The Baker </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/the-baker/index.html">
                                                                                The Baker </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="video-time">1 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In ... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/the-baker/index.html"
                                                                            data-post-id="8585">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/02/killer2-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/killer-design-2/index.html">
                                                                                Killer Design </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/killer-design-2/index.html">
                                                                                Killer Design </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2017</div>
                                                                            <div class="video-time">2 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/killer-design-2/index.html"
                                                                            data-post-id="243">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/Rectangle-6-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/friend-zone/index.html">
                                                                                Friend Zone </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../movie/friend-zone/index.html">
                                                                                Friend Zone </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2019</div>
                                                                            <div class="video-time">1 hr 55 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../movie/friend-zone/index.html"
                                                                            data-post-id="8565">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="content-front">
                                                                        <img class='attachment-288x400 size-288x400'
                                                                            alt=''
                                                                            src={{ asset('clients/wp-content/uploads/2023/06/the_post-288x400.jpg') }}>
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                The Post </a>
                                                                        </h6>
                                                                    </div>

                                                                    <div class="content-back">
                                                                        <h6 class="video_title">
                                                                            <a href="../detail/index.html">
                                                                                The Post </a>
                                                                        </h6>
                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="video-time">1 hr 25 mins
                                                                            </div>
                                                                        </div>
                                                                        <div class="video-description jws-scrollbar">
                                                                            Suspendisse eu porta quam, sit amet
                                                                            tristique sem. Maecenas tincidunt
                                                                            finibus ipsum, eget aliquet elit
                                                                            scelerisque non. In... </div>
                                                                        <a class="watchlist-add"
                                                                            href="../detail/index.html"
                                                                            data-post-id="8583">
                                                                            <i class="jws-icon-plus"></i>
                                                                            <span class="added">Added to My
                                                                                List</span>
                                                                            <span>Add to My List</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-5a1cc51 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="5a1cc51" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2c305f3"
                                        data-id="2c305f3" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-70f155f elementor-widget__width-auto elementor-widget elementor-widget-heading"
                                                data-id="70f155f" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">TV
                                                        Series</h5>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-87987c7 elementor-widget elementor-widget-jws_tv_shows_tabs"
                                                data-id="87987c7" data-element_type="widget"
                                                data-widget_type="jws_tv_shows_tabs.default">
                                                <div class="elementor-widget-container">
                                                    <div class="jws-tv_shows-tabs-element jws-tv-shows-advanced-element">
                                                        <div class="tv_shows-nav"
                                                            data-args='{"orderby":"date","order":"desc","tv_shows_tabs_display":"metro","tv_shows_tabs_layout":"layout3","tv_shows_tabs_columns":"3","images_size":{"width":"850","height":"500"}}'>
                                                            <div><a class="active" href="#"
                                                                    data-id='["663","665","666","667","4017","4073","4796"]'>Today</a>
                                                            </div>
                                                            <div><a class="" href="#"
                                                                    data-id='["8608","8610","8612","8614","8616","8618","8620"]'>This
                                                                    week</a></div>
                                                            <div><a class="" href="#"
                                                                    data-id='["665","4017","4073","8604","8608","8612","8616"]'>This
                                                                    month</a></div>
                                                            <div><a class="" href="#"
                                                                    data-id='["665","666","4017","4796","8604","8608","8612"]'>Last
                                                                    3 months</a></div>
                                                        </div>
                                                        <div class="tv_shows-content row layout3 metro">

                                                            <div
                                                                class="col-xl-5 col-lg-6 hidden_mobile hidden_tablet columns-left">
                                                                <div class="row">
                                                                    <div class="jws-post-item col-xl-12">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/falling-water/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/04/Falling-Water-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/falling-water/index.html">
                                                                                        Falling Water </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 2
                                                                                    Seasons </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-7 col-lg-12 columns-right">
                                                                <div class="row">
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/falling-water/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/04/Falling-Water-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/falling-water/index.html">
                                                                                        Falling Water </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 2
                                                                                    Seasons </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/the-unstoppable-soldier/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/02/Slide-2-av-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/the-unstoppable-soldier/index.html">
                                                                                        The Unstoppable Soldier </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 1
                                                                                    Season </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/political-animal/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/03/Political-Animal-2-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/political-animal/index.html">
                                                                                        Political Animal </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 3
                                                                                    Seasons </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/the-wasted-times/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/02/The-Wasted-Times-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/the-wasted-times/index.html">
                                                                                        The Wasted Times </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 2
                                                                                    Seasons </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/fireworks-wednesday/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/02/Fireworks-Wednesday-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/fireworks-wednesday/index.html">
                                                                                        Fireworks Wednesday </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 1
                                                                                    Season </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/zoombies-game/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/02/Zoombies-Game-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/zoombies-game/index.html">
                                                                                        Zoombies Game </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 1
                                                                                    Season </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item col-xl-4 col-lg-4 col-6">

                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a
                                                                                    href="../tv_shows/shark-hunters/index.html">
                                                                                    <img class='attachment-850x500 size-850x500'
                                                                                        alt=''
                                                                                        src={{ asset('clients/wp-content/uploads/2023/02/sahark-e1676001886337-850x500.jpg') }}>
                                                                                </a>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/shark-hunters/index.html">
                                                                                        Shark Hunters </a>
                                                                                </h6>


                                                                                <span class="seasions-numer"> 1
                                                                                    Season </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-9fa3c3f elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="9fa3c3f" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9c55d79"
                                        data-id="9c55d79" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <section
                                                class="elementor-section elementor-inner-section elementor-element elementor-element-112b379 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                                data-id="112b379" data-element_type="section"
                                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                                    <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-2551391"
                                                        data-id="2551391" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-90be76a elementor-widget elementor-widget-heading"
                                                                data-id="90be76a" data-element_type="widget"
                                                                data-widget_type="heading.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="elementor-heading-title elementor-size-default">
                                                                        A Netflix series</div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-f25f31a elementor-widget elementor-widget-heading"
                                                                data-id="f25f31a" data-element_type="widget"
                                                                data-widget_type="heading.default">
                                                                <div class="elementor-widget-container">
                                                                    <div
                                                                        class="elementor-heading-title elementor-size-default">
                                                                        Pieces of Her</div>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-d7af3ea elementor-widget elementor-widget-text-editor"
                                                                data-id="d7af3ea" data-element_type="widget"
                                                                data-widget_type="text-editor.default">
                                                                <div class="elementor-widget-container">
                                                                    <p>March 4<img decoding="async"
                                                                            class="alignnone size-full wp-image-580"
                                                                            style="margin-left: 35px; margin-top: -4px;"
                                                                            src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2064%2017'%3E%3C/svg%3E"
                                                                            alt="" width="64" height="17"
                                                                            data-lazy-src="{{ asset('clients/wp-content/uploads/2023/02/netflexm.png') }}" /><noscript><img
                                                                                decoding="async"
                                                                                class="alignnone size-full wp-image-580"
                                                                                style="margin-left: 35px; margin-top: -4px;"
                                                                                src="{{ asset('clients/wp-content/uploads/2023/02/netflexm.png') }}"
                                                                                alt="" width="64"
                                                                                height="17" /></noscript></p>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-element elementor-element-8c8a09c elementor-widget__width-auto elementor-absolute elementor-align-center elementor-widget-mobile__width-inherit remove-absolute elementor-widget elementor-widget-jws-gradient-button"
                                                                data-id="8c8a09c" data-element_type="widget"
                                                                data-settings="{&quot;_position&quot;:&quot;absolute&quot;}"
                                                                data-widget_type="jws-gradient-button.default">
                                                                <div class="elementor-widget-container">
                                                                    <div class="elementor-button-wrapper">
                                                                        <a href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4"
                                                                            class="elementor-button-link elementor-button btn-main button-custom video-trailer classic elementor-size-sm"
                                                                            role="button">
                                                                            <span class="elementor-button-content-wrapper">
                                                                                <span
                                                                                    class="elementor-button-icon elementor-align-icon-">

                                                                                </span>
                                                                                <span class="elementor-button-text">Watch
                                                                                    Trailer</span>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                </div>
                                            </section>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-7999358 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="7999358" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9119033"
                                        data-id="9119033" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-ef2dbe0 elementor-widget elementor-widget-heading"
                                                data-id="ef2dbe0" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">
                                                        Recommended TV Shows</h5>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-d36429e elementor-widget elementor-widget-jws_tv_shows_advanced"
                                                data-id="d36429e" data-element_type="widget"
                                                data-widget_type="jws_tv_shows_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-tv-shows-advanced-element">


                                                        <div class="row tv-shows-advanced-content layout4 tv-shows-advanced-ajax-d36429e jws_has_pagination owl-carousel jws-tv-shows-advanced-slider"
                                                            data-owl-option='{                "autoplay": true,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "loop":true,                "autoWidth":false,                "smartSpeed": 500,                "responsive":{        "1500":{"items": 4,"slideBy": 1},        "1024":{"items": 4,"slideBy": 1},        "768":{"items": 3,"slideBy": 1},        "0":{"items": 2,"slideBy": 1}    }}'>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a href="../tv_shows/arcane/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2024/12/wQEW3xLrQAThu1GvqpsKQyejrYS-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/arcane/index.html">
                                                                                Arcane </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2021</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/arcane/index.html">
                                                                                Arcane </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2021</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/arcane/index.html"
                                                                                data-post-id="10400">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/arcane/index.html"
                                                                                data-post-id="10400">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a
                                                                            href="../tv_shows/escape-to-the-farm/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Escape-to-the-Farm-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a
                                                                                href="../tv_shows/escape-to-the-farm/index.html">
                                                                                Escape to the Farm </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2020</div>
                                                                            <div class="seasions-numer"> 1 Season
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a
                                                                                href="../tv_shows/escape-to-the-farm/index.html">
                                                                                Escape to the Farm </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2020</div>
                                                                            <div class="seasions-numer"> 1 Season
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/escape-to-the-farm/index.html"
                                                                                data-post-id="8620">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/escape-to-the-farm/index.html"
                                                                                data-post-id="8620">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a href="../tv_shows/love-and-war/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Love-and-War-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/love-and-war/index.html">
                                                                                Love and War </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2021</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/love-and-war/index.html">
                                                                                Love and War </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2021</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/love-and-war/index.html"
                                                                                data-post-id="8618">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/love-and-war/index.html"
                                                                                data-post-id="8618">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a href="../tv_shows/date-night/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Date-Night-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/date-night/index.html">
                                                                                Date Night </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2023</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/date-night/index.html">
                                                                                Date Night </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2023</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/date-night/index.html"
                                                                                data-post-id="8616">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/date-night/index.html"
                                                                                data-post-id="8616">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a href="../tv_shows/day-dreamers/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Day-Dreamers-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/day-dreamers/index.html">
                                                                                Day Dreamers </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2019</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/day-dreamers/index.html">
                                                                                Day Dreamers </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2019</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/day-dreamers/index.html"
                                                                                data-post-id="8614">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/day-dreamers/index.html"
                                                                                data-post-id="8614">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner hover-video">

                                                                    <div class="post-media"
                                                                        data-trailer="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4">
                                                                        <a href="../tv_shows/crime-stories/index.html">
                                                                            <img class='attachment-630x400 size-630x400'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Crime-Stories-630x400.jpg') }}>
                                                                        </a>

                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/crime-stories/index.html">
                                                                                Crime Stories </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="popup-detail">
                                                                        <h6 class="video_title">
                                                                            <a href="../tv_shows/crime-stories/index.html">
                                                                                Crime Stories </a>
                                                                        </h6>

                                                                        <div class="video-meta">
                                                                            <div class="video-years">2022</div>
                                                                            <div class="seasions-numer"> 2 Seasons
                                                                            </div>

                                                                        </div>
                                                                        <div class="video-cat">
                                                                        </div>
                                                                        <div class="video-play">
                                                                            <a class="btn-main button-default jws-popup-detail"
                                                                                href="../tv_shows/crime-stories/index.html"
                                                                                data-post-id="8612">
                                                                                <span>View Detail</span>
                                                                                <i class="jws-icon-info-light"></i>
                                                                            </a>
                                                                            <a class="btn-main button-custom watchlist-add"
                                                                                href="../tv_shows/crime-stories/index.html"
                                                                                data-post-id="8612">
                                                                                <span class="added">Added
                                                                                    watchlist</span>
                                                                                <span>Watch Later</span>
                                                                                <i class="jws-icon-bookmark-simple"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-2e3bac3 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="2e3bac3" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6b8659f"
                                        data-id="6b8659f" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-f6e1759 elementor-widget elementor-widget-heading"
                                                data-id="f6e1759" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">
                                                        Exclusive Videos</h5>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-68ff24a elementor-widget elementor-widget-text-editor"
                                                data-id="68ff24a" data-element_type="widget"
                                                data-widget_type="text-editor.default">
                                                <div class="elementor-widget-container">
                                                    Celebrity interviews, trending entertainment stories, and expert
                                                    analysis </div>
                                            </div>
                                            <div class="elementor-element elementor-element-91106d1 elementor-widget elementor-widget-jws_videos_advanced"
                                                data-id="91106d1" data-element_type="widget"
                                                data-widget_type="jws_videos_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-videos-advanced-element">




                                                        <div class="row videos-advanced-content layout1 videos-advanced-ajax-91106d1 owl-carousel jws-videos-advanced-slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": false,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "loop":false,                "autoWidth":false,                "smartSpeed": 500,                "responsive":{        "1500":{"items": 3,"slideBy": 1},        "1024":{"items": 3,"slideBy": 1},        "768":{"items": 3,"slideBy": 1},        "0":{"items": 2,"slideBy": 1}    }}'>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../videos/top-10-reasons-to-watch-hocus-pocus-2/index.html">
                                                                            <img class='attachment-780x438 size-780x438'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/02/Top-10-Reasons-to-Watch-Hocus-Pocus-2-780x438.jpg') }}><span
                                                                                class="jws-premium jws-icon-crown-1"></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="title">
                                                                            <a
                                                                                href="../videos/top-10-reasons-to-watch-hocus-pocus-2/index.html">
                                                                                Top 10 Reasons to Watch Hocus Pocus
                                                                                2 </a>
                                                                        </h6>
                                                                        <div class="videos-meta">
                                                                            <span class="view">
                                                                                1738 views
                                                                            </span>
                                                                            <span class="time">
                                                                                3 years ago </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../videos/new-avatar-2-cast-share-first-impressions/index.html">
                                                                            <img class='attachment-780x438 size-780x438'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/02/New-Avatar-2-Cast-Share-First-Impressions-780x438.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="title">
                                                                            <a
                                                                                href="../videos/new-avatar-2-cast-share-first-impressions/index.html">
                                                                                New &#8216;Avatar 2&#8217; Cast
                                                                                Share First Impressions </a>
                                                                        </h6>
                                                                        <div class="videos-meta">
                                                                            <span class="view">
                                                                                2553 views
                                                                            </span>
                                                                            <span class="time">
                                                                                3 years ago </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../videos/camila-mendes-and-maya-hawke-answer-burning-questions/index.html">
                                                                            <img class='attachment-780x438 size-780x438'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/02/videos_thumbnail-780x438.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="videos-content">
                                                                        <h6 class="title">
                                                                            <a
                                                                                href="../videos/camila-mendes-and-maya-hawke-answer-burning-questions/index.html">
                                                                                Camila Mendes and Maya Hawke Answer
                                                                                Burning Questions </a>
                                                                        </h6>
                                                                        <div class="videos-meta">
                                                                            <span class="view">
                                                                                3627 views
                                                                            </span>
                                                                            <span class="time">
                                                                                3 years ago </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-a601961 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="a601961" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5932398"
                                        data-id="5932398" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <section
                                                class="elementor-section elementor-inner-section elementor-element elementor-element-151ad8b elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                                data-id="151ad8b" data-element_type="section"
                                                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                                <div
                                                    class="elementor-container elementor-column-gap-default jws_section_">
                                                    <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-b6925c9"
                                                        data-id="b6925c9" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-6143b27 blen_lighten elementor-invisible elementor-widget elementor-widget-image"
                                                                data-id="6143b27" data-element_type="widget"
                                                                data-settings="{&quot;_animation&quot;:&quot;fadeInRight&quot;}"
                                                                data-widget_type="image.default">
                                                                <div class="elementor-widget-container">
                                                                    <img fetchpriority="high" decoding="async"
                                                                        width="225" height="250"
                                                                        src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20225%20250'%3E%3C/svg%3E"
                                                                        class="attachment-full size-full wp-image-716"
                                                                        alt=""
                                                                        data-lazy-src="{{ asset('clients/wp-content/uploads/2023/02/movies_img.png') }}" /><noscript><img
                                                                            fetchpriority="high" decoding="async"
                                                                            width="225" height="250"
                                                                            src="{{ asset('clients/wp-content/uploads/2023/02/movies_img.png') }}"
                                                                            class="attachment-full size-full wp-image-716"
                                                                            alt="" /></noscript>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-b81f0f1"
                                                        data-id="b81f0f1" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-4b004ee elementor-widget elementor-widget-image"
                                                                data-id="4b004ee" data-element_type="widget"
                                                                data-widget_type="image.default">
                                                                <div class="elementor-widget-container">
                                                                    <img decoding="async" width="269"
                                                                        height="145"
                                                                        src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20269%20145'%3E%3C/svg%3E"
                                                                        class="attachment-full size-full wp-image-726"
                                                                        alt=""
                                                                        data-lazy-src="{{ asset('clients/wp-content/uploads/2023/02/text_banner.png') }}" /><noscript><img
                                                                            loading="lazy" decoding="async"
                                                                            width="269" height="145"
                                                                            src="{{ asset('clients/wp-content/uploads/2023/02/text_banner.png') }}"
                                                                            class="attachment-full size-full wp-image-726"
                                                                            alt="" /></noscript>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-58e85fc"
                                                        data-id="58e85fc" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-53fa974 elementor-widget elementor-widget-heading"
                                                                data-id="53fa974" data-element_type="widget"
                                                                data-widget_type="heading.default">
                                                                <div class="elementor-widget-container">
                                                                    <h3
                                                                        class="elementor-heading-title elementor-size-default">
                                                                        streaming on OCT 15</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-998286c"
                                                        data-id="998286c" data-element_type="column">
                                                        <div class="elementor-widget-wrap elementor-element-populated">
                                                            <div class="elementor-element elementor-element-1a8e6ec elementor-align-right elementor-mobile-align-center elementor-widget elementor-widget-jws-gradient-button"
                                                                data-id="1a8e6ec" data-element_type="widget"
                                                                data-widget_type="jws-gradient-button.default">
                                                                <div class="elementor-widget-container">
                                                                    <div class="elementor-button-wrapper">
                                                                        <a href="https://customer-342mt1gy0ibqe0dl.cloudflarestream.com/041d1c3ca67c6ca61855cd192ede5eb9/downloads/default.mp4"
                                                                            class="elementor-button-link elementor-button btn-main button-custom video-trailer classic elementor-size-sm"
                                                                            role="button">
                                                                            <span
                                                                                class="elementor-button-content-wrapper">
                                                                                <span
                                                                                    class="elementor-button-icon elementor-align-icon-">

                                                                                </span>
                                                                                <span class="elementor-button-text">Watch
                                                                                    Trailer</span>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                </div>
                                            </section>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-eb35200 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="eb35200" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a6d13d2"
                                        data-id="a6d13d2" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-03c9d89 elementor-widget elementor-widget-heading"
                                                data-id="03c9d89" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">Top
                                                        Artists</h5>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-f256fa6 elementor-widget elementor-widget-jws_person_advanced"
                                                data-id="f256fa6" data-element_type="widget"
                                                data-widget_type="jws_person_advanced.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-person-advanced-element">

                                                        <div class="row person-advanced-content layout1 person-advanced-ajax-f256fa6 jws_has_pagination owl-carousel jws-person-advanced-slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "loop":false,                "autoWidth":false,                "smartSpeed": 500,                "responsive":{        "1500":{"items": 8,"slideBy": 1},        "1024":{"items": 8,"slideBy": 1},        "768":{"items": 4,"slideBy": 1},        "0":{"items": 2,"slideBy": 1}    }}'>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/alaya-pacheco/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Alaya-Pacheco-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/alaya-pacheco/index.html">
                                                                                Alaya Pacheco </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/sarah-neal/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Sarah-Neal-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/sarah-neal/index.html">
                                                                                Sarah Neal </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/emma-narburgh/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Emma-Narburgh-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/emma-narburgh/index.html">
                                                                                Emma Narburgh </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/richard-cant/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Richard-Cant-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/richard-cant/index.html">
                                                                                Richard Cant </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/david-horovitch/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/David-Horovitch-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a
                                                                                href="../person/david-horovitch/index.html">
                                                                                David Horovitch </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/emily-carey/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Emily-Carey-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/emily-carey/index.html">
                                                                                Emily Carey </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/harry-styles/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Harry-Styles-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/harry-styles/index.html">
                                                                                Harry Styles </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/jefferson-hall/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Jefferson-Hall-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/jefferson-hall/index.html">
                                                                                Jefferson Hall </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item no_format">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a href="../person/brooke-mulford/index.html">
                                                                            <img class='attachment-305x305 size-305x305'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/06/Brooke-Mulford2-305x305.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="person-content">
                                                                        <h6 class="title">
                                                                            <a href="../person/brooke-mulford/index.html">
                                                                                Brooke Mulford </a>
                                                                        </h6>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="jws-nav-carousel">
                                                            <div class="jws-button-prev"><i
                                                                    class="jws-icon-left-open"></i></div>
                                                            <div class="jws-button-next"><i
                                                                    class="jws-icon-right-open"></i></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </section>
                            <section
                                class="elementor-section elementor-top-section elementor-element elementor-element-2395456 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                data-id="2395456" data-element_type="section">
                                <div class="elementor-container elementor-column-gap-default jws_section_">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2849674"
                                        data-id="2849674" data-element_type="column">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-820c931 elementor-widget elementor-widget-heading"
                                                data-id="820c931" data-element_type="widget"
                                                data-widget_type="heading.default">
                                                <div class="elementor-widget-container">
                                                    <h5 class="elementor-heading-title elementor-size-default">Top
                                                        News</h5>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-0f360b3 elementor-widget elementor-widget-jws_blog"
                                                data-id="0f360b3" data-element_type="widget"
                                                data-widget_type="jws_blog.default">
                                                <div class="elementor-widget-container">


                                                    <div class="jws-blog-element jws-carousel">
                                                        <div class="row blog_content jws_blog_layout1 blog_ajax_0f360b3 jws-isotope jws_has_pagination owl-carousel jws_blog_slider"
                                                            data-owl-option='{                "autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "loop":true,                "autoWidth":false,                "smartSpeed": 500,                "responsive":{        "1500":{"items": 3,"slideBy": 1},        "1024":{"items": 3,"slideBy": 1},        "768":{"items": 2,"slideBy": 1},        "0":{"items": 1,"slideBy": 1}    }}'>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../movies-that-will-make-your-holidays-the-best/index.html">
                                                                            <img class='attachment-148x200 size-148x200'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/04/osman-rana-BltXOAu8Ckw-unsplash-148x200.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="jws_post_content">
                                                                        <h6 class="entry-title"><a
                                                                                href="../movies-that-will-make-your-holidays-the-best/index.html">Movies
                                                                                That Will Make Your Holidays The
                                                                                Best</a></h6>
                                                                        <div class="jws_post_excerpt">
                                                                            Praesent iaculis, purus ac vehicula
                                                                            mattis, arcu lorem blandit nisl, non
                                                                            laoreet dui mi eget elit. Donec
                                                                            porttitor ex vel augue maximus luctus.
                                                                        </div>
                                                                        <div class="jws_post_meta fs-small">
                                                                            <span class="entry-date"><a
                                                                                    href="../2023/04/26/index.html">April
                                                                                    26, 2023</a></span>
                                                                            <span class="post_author"><a
                                                                                    href="../author/streamvid/index.html">Jane
                                                                                    Doe</a></span>
                                                                            <span class="post_cat"><a
                                                                                    href="../category/entertainment/index.html"
                                                                                    rel="tag">Entertainment</a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../must-watch-web-series-on-streamvid/index.html">
                                                                            <img class='attachment-148x200 size-148x200'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/04/alin-surdu-j5GCqQM3eYA-unsplash-148x200.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="jws_post_content">
                                                                        <h6 class="entry-title"><a
                                                                                href="../must-watch-web-series-on-streamvid/index.html">Must
                                                                                Watch Web Series On Streamvid</a>
                                                                        </h6>
                                                                        <div class="jws_post_excerpt">
                                                                            Praesent iaculis, purus ac vehicula
                                                                            mattis, arcu lorem blandit nisl, non
                                                                            laoreet dui mi eget elit. Donec
                                                                            porttitor ex vel augue maximus luctus.
                                                                        </div>
                                                                        <div class="jws_post_meta fs-small">
                                                                            <span class="entry-date"><a
                                                                                    href="../2023/04/26/index.html">April
                                                                                    26, 2023</a></span>
                                                                            <span class="post_author"><a
                                                                                    href="../author/streamvid/index.html">Jane
                                                                                    Doe</a></span>
                                                                            <span class="post_cat"><a
                                                                                    href="../category/entertainment/index.html"
                                                                                    rel="tag">Entertainment</a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="jws-post-item slider-item">
                                                                <div class="post-inner">
                                                                    <div class="post-media">
                                                                        <a
                                                                            href="../best-movies-to-cheer-your-mood-up-in-2022/index.html">
                                                                            <img class='attachment-148x200 size-148x200'
                                                                                alt=''
                                                                                src={{ asset('clients/wp-content/uploads/2023/04/jarritos-mexican-soda-dHn_feNlz38-unsplash-148x200.jpg') }}>
                                                                        </a>
                                                                    </div>
                                                                    <div class="jws_post_content">
                                                                        <h6 class="entry-title"><a
                                                                                href="../best-movies-to-cheer-your-mood-up-in-2022/index.html">Best
                                                                                Movies To Cheer Your Mood Up In
                                                                                2022</a></h6>
                                                                        <div class="jws_post_excerpt">
                                                                            Praesent iaculis, purus ac vehicula
                                                                            mattis, arcu lorem blandit nisl, non
                                                                            laoreet dui mi eget elit. Donec
                                                                            porttitor ex vel augue maximus luctus.
                                                                        </div>
                                                                        <div class="jws_post_meta fs-small">
                                                                            <span class="entry-date"><a
                                                                                    href="../2023/04/26/index.html">April
                                                                                    26, 2023</a></span>
                                                                            <span class="post_author"><a
                                                                                    href="../author/streamvid/index.html">Jane
                                                                                    Doe</a></span>
                                                                            <span class="post_cat"><a
                                                                                    href="../category/dramas/index.html"
                                                                                    rel="tag">Dramas</a>, <a
                                                                                    href="../category/movies-news/index.html"
                                                                                    rel="tag">Movies News</a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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

            </main><!-- #main -->
        </div><!-- #primary -->

    </div><!-- #content -->
@endsection
