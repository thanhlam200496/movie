@extends('client_movie.layouts.default')
@section('title')
    @if (strlen($movie->title) < 40)
        Phim {{ substr($movie->title, 0, 30) }} Capy Phim miễn phí.
    @else
        {{ substr($movie->title, 0, 50) }}
    @endif
@endsection
@section('description')
    @if (strlen($movie->description) > 150)
        {!! substr($movie->description, 0, 150) !!}
    @else
        {!! $movie->description !!}
    @endif

@endsection
@section('keywords')
Phim {{$movie->countries}}
@foreach ($movie->categories->unique('id') as $category)
, {{ $category->name }}
                            @endforeach
@endsection
@section('main')
    <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main version-v1">

                    <div class="container">
                        <div class="videos_player ratio_21x9 application/x-mpegURL vjs-waiting" data-playerid="9053">


                            <video id="videos_player" class="jws_player video-js vjs-default-skin" data-playerid="9053"
                                data-player='{"controls":true,"muted":false,"autoplay":true,"preload":"auto","playbackRates":[0.5,1,1.5,2],"logo":{"url":"https:\/\/streamvid.jwsuperthemes.com\/wp-content\/uploads\/2023\/02\/logo_sin.svg"},"sources":[{"src":"dmlkZW8gaGlkZGVu","type":"application\/x-mpegURL"}],"poster":"https:\/\/streamvid.jwsuperthemes.com\/wp-content\/uploads\/2024\/12\/7I6VUdPj6tQECNHdviJkUHD2u89-scaled.jpg","current_time":""}'
                                poster="/timthumb.php?src={{Storage::url('images/'.$movie->poster_url)}}">
                                <track label="Enligh" kind="subtitles" srclang="Enligh"
                                    src="../wp-content/uploads/2023/06/English-John-Wick_-Chapter-4-2023-Movie-Official-Trailer-%e2%80%93-Keanu-Reeves-Donnie-Yen-Bill-Skarsgard-DownSub.com_.vtt.txt"
                                    default />
                                <track label="Japan" kind="subtitles" srclang="Japan"
                                    src="../wp-content/uploads/2023/06/English-John-Wick_-Chapter-4-2023-Movie-Official-Trailer-%e2%80%93-Keanu-Reeves-Donnie-Yen-Bill-Skarsgard-DownSub.com_.ja_.vtt.txt" />
                                <track label="Arabic" kind="subtitles" srclang="Arabic"
                                    src="../wp-content/uploads/2023/06/English-John-Wick_-Chapter-4-2023-Movie-Official-Trailer-%e2%80%93-Keanu-Reeves-Donnie-Yen-Bill-Skarsgard-DownSub.com_.ar_.vtt.txt" />
                            </video>
                            <div class="vjs-loading-spinner"></div>



                        </div>
                        <div class="sources-videos sources-list fs-small" data-id="9053">
                            <ul class="reset_ul_ol clear-both">

                                <li class="label">Change Source:</li>

                                <li class="active"> <button class="reset-button main" data-index="0"><i
                                            class="jws-icon-link"></i>Link 1</button></li>
                                <li class=""> <button class="reset-button" data-index="1"><i
                                            class="jws-icon-link"></i>Link 2</button></li>
                            </ul>
                        </div>


                        <div class="row">

                            <div class="col-xl-3 col-lg-4">
                                <div class="jws_sticky_move">
                                    <div class="jws-images">
                                        <img class='attachment-full' alt=''
                                            src="/timthumb.php?src={{Storage::url('/images/'.$movie->poster_url)}}">
                                        <div class="jws-tool">

                                            <div class="jws-likes">
                                                <a href="#" class="like-button" data-type="movies" data-post-id="9053">
                                                    <i class="jws-icon-thumbs-up"></i>
                                                    <span class="likes-count">1</span> <span>like</span>
                                                </a>
                                            </div>

                                            <div class="jws-share">
                                                <a href="#" data-modal-jws="#share-videos">
                                                    <i class="jws-icon-share-network"></i>
                                                    <span>Share</span>
                                                </a>
                                            </div>

                                            <div class="jws-watchlist">
                                                <a class="watchlist-add" href="index.html" data-post-id="9053">
                                                    <i class="jws-icon-plus"></i>
                                                    <span>Watchlist</span>
                                                    <span class="added">Watchlisted</span>
                                                </a>
                                            </div>
                                        </div>

                                        <a href='#' class='jws-download-videos fw-700' data-id='9053'><span
                                                class='text'>Download Videos</span><i
                                                class='jws-icon-arrow-line-down'></i></a>
                                        <ul class="jws-download-list">
                                            <li><a href="#" data-url="../wp-content/uploads/2023/06/video_Ex.mp4">File
                                                    Download 1</a></li>
                                            <li><a href="#"
                                                    data-url="../wp-content/uploads/2023/09/production_id_4124024-720p.html">File
                                                    Download 2</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-9 col-lg-8">

                                <h1 class="jws-title">
                                  {{$movie->title}}</h1>

                                <div class="jws-meta-info">

                                    <div class="jws-raring-result">
                                        <span data-star="5" style="width:100%"></span>
                                    </div>

                                    <div class="jws-imdb">
                                        8.2 </div>

                                    <div class="jws-view">

                                        <i class="jws-icon-eye"></i> 7986 Views
                                    </div>


                                    <div class="jws-comment-number">

                                        <i class="jws-icon-chat-dots"></i>1
                                    </div>

                                </div>

                                <div class="jws-meta-info2">
                                    <span class="video-years">{{$movie->release_year}}</span><span class="video-time"> - {{$movie->duration}} - </span><span
                                        class="video-badge">{{$movie->type_film}}</span>
                                </div>

                                <div class="jws-category">
					@foreach($movie->categories->unique('id') as $category)
<a href="../../movies_cat/action/index.html" rel="tag">{{$category->name}}</a
@endforeach                                </div>
                                <div class="js-content-container">
                                    <div class="js-content">
{!!$movie->description!!}                                        <p>

</p>
                                    </div><button class="view-more-content reset-button fs-small fw-700 cl-heading">Show
                                        More<i class="jws-icon-caret-down"></i></button>
                                </div>
                                <div class="jws-description"></div>
                                <div class="jws-meta-director">
                                    <div><label>Cast:</label>
                                        <a href="../../person/brooke-mulford/index.html">Brooke Mulford</a>
                                    </div>

                                    <div><label>Crew:</label>
                                        <a href="../../person/alaya-pacheco/index.html">Alaya Pacheco</a>, <a
                                            href="../../person/ricky-aleman/index.html">Ricky Aleman</a>, <a
                                            href="../../person/sarah-neal/index.html">Sarah Neal</a>
                                    </div>

                                </div>
                                <style id="elementor-post-3903">
                                    .elementor-3903 .elementor-element.elementor-element-4ece72f .post-inner {
                                        width: 208px;
                                    }

                                    .elementor-3903 .elementor-element.elementor-element-4ece72f .jws-post-item {
                                        padding-right: calc(20px/2);
                                        padding-left: calc(20px/2);
                                    }

                                    .elementor-3903 .elementor-element.elementor-element-4ece72f .movies_advanced_content.row {
                                        margin-left: calc(-20px/2);
                                        margin-right: calc(-20px/2);
                                    }
                                </style>
                                <div class="jws-related">
                                    <style>
                                        .elementor-3903 .elementor-element.elementor-element-4ece72f .post-inner {
                                            width: 208px;
                                        }

                                        .elementor-3903 .elementor-element.elementor-element-4ece72f .jws-post-item {
                                            padding-right: calc(20px/2);
                                            padding-left: calc(20px/2);
                                        }

                                        .elementor-3903 .elementor-element.elementor-element-4ece72f .movies_advanced_content.row {
                                            margin-left: calc(-20px/2);
                                            margin-right: calc(-20px/2);
                                        }
                                    </style>
                                    <div data-elementor-type="wp-post" data-elementor-id="3903"
                                        class="elementor elementor-3903">
                                        <section
                                            class="elementor-section elementor-top-section elementor-element elementor-element-57783d0 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                            data-id="57783d0" data-element_type="section">
                                            <div class="elementor-container elementor-column-gap-no jws_section_">
                                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-351a87b"
                                                    data-id="351a87b" data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="elementor-element elementor-element-4ece72f elementor-widget elementor-widget-jws_movies_advanced"
                                                            data-id="4ece72f" data-element_type="widget"
                                                            data-widget_type="jws_movies_advanced.default">
                                                            <div class="elementor-widget-container">


                                                                <div class="jws-movies_advanced-element">

                                                                    <h5 class="title-related">Recommended For You</h5>
                                                                    <div class="row movies_advanced_content layout2 movies_advanced_ajax_4ece72f jws_has_pagination owl-carousel jws_movies_advanced_slider"
                                                                        data-owl-option='{
                "autoplay": false,
                "nav": true,
                "dots":false,
                "autoplayTimeout": 5000,
                "autoplayHoverPause":true,
                "center":false,
                "loop":false,
                "autoWidth":true,
                "smartSpeed": 500,
                "responsive":{
        "1500":{"items": 1,"slideBy": 1},
        "1024":{"items": 1,"slideBy": 1},
        "768":{"items": 1,"slideBy": 1},
        "0":{"items": 1,"slideBy": 1}
    }}'>
                                                                        <div class="jws-post-item slider-item">
                                                                            <div class="post-inner">
                                                                                <div class="content-front">
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/06/warlick_of-488x680.jpg>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../warlock-of-dusk/index.html">
                                                                                            Warlock of Dusk </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../warlock-of-dusk/index.html">
                                                                                            Warlock of Dusk </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2019
                                                                                        </div>
                                                                                        <div class="video-time">2 hr 35
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                    </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../warlock-of-dusk/index.html"
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/06/6TeIVKPw7nXXWy2zKmDmlnSwzb7-scaled-488x680.jpg>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-white-house/index.html">
                                                                                            The White House </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-white-house/index.html">
                                                                                            The White House </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2023
                                                                                        </div>
                                                                                        <div class="video-time">2 hr 35
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Enjoy exclusive Amazon Originals
                                                                                        as well as popular movies and TV
                                                                                        shows for USD 120z/month. Watch
                                                                                        now, cancel anytime. </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../the-white-house/index.html"
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/02/movies2-488x680.jpg><span
                                                                                        class="jws-premium jws-icon-crown-1"></span>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-sleeping-angel/index.html">
                                                                                            The Sleeping Angel </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-sleeping-angel/index.html">
                                                                                            The Sleeping Angel </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2019
                                                                                        </div>
                                                                                        <div class="video-time">1 hr 25
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Suspendisse eu porta quam, sit
                                                                                        amet tristique sem. Maecenas
                                                                                        tincidunt finibus ipsum, eget
                                                                                        aliquet elit scelerisque non.
                                                                                        In... </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../the-sleeping-angel/index.html"
                                                                                        data-post-id="244">
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/06/the_post-488x680.jpg>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-post/index.html">
                                                                                            The Post </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../the-post/index.html">
                                                                                            The Post </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2022
                                                                                        </div>
                                                                                        <div class="video-time">1 hr 25
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Suspendisse eu porta quam, sit
                                                                                        amet tristique sem. Maecenas
                                                                                        tincidunt finibus ipsum, eget
                                                                                        aliquet elit scelerisque non.
                                                                                        In... </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../the-post/index.html"
                                                                                        data-post-id="8583">
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/06/8Vt6mWEReuy4Of61Lnj5Xj704m8-488x680.jpg>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../spider-man-memo/index.html">
                                                                                            Spider Man Memo </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../spider-man-memo/index.html">
                                                                                            Spider Man Memo </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2022
                                                                                        </div>
                                                                                        <div class="video-time">1 hr 25
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Enjoy exclusive Amazon Originals
                                                                                        as well as popular movies and TV
                                                                                        shows for USD 120z/month. Watch
                                                                                        now, cancel anytime. </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../spider-man-memo/index.html"
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/06/intheback-488x680.jpg>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../man-in-the-black/index.html">
                                                                                            Man in The Black </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../man-in-the-black/index.html">
                                                                                            Man in The Black </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2021
                                                                                        </div>
                                                                                        <div class="video-time">1 hr 45
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Suspendisse eu porta quam, sit
                                                                                        amet tristique sem. Maecenas
                                                                                        tincidunt finibus ipsum, eget
                                                                                        aliquet elit scelerisque non.
                                                                                        In... </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../man-in-the-black/index.html"
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
                                                                                    <img class='attachment-488x680 size-488x680'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/01/cityhun-488x680.jpg><span
                                                                                        class="jws-premium jws-icon-crown-1"></span>
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../city-hunter/index.html">
                                                                                            City Hunter </a>
                                                                                    </h6>
                                                                                </div>

                                                                                <div class="content-back">
                                                                                    <h6 class="video_title">
                                                                                        <a
                                                                                            href="../city-hunter/index.html">
                                                                                            City Hunter </a>
                                                                                    </h6>
                                                                                    <div class="video-meta">
                                                                                        <div class="video-years">2016
                                                                                        </div>
                                                                                        <div class="video-time">1 hr 55
                                                                                            mins</div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="video-description jws-scrollbar">
                                                                                        Enjoy exclusive Amazon Originals
                                                                                        as well as popular movies and TV
                                                                                        shows for USD 120z/month. Watch
                                                                                        now, cancel anytime. </div>
                                                                                    <a class="watchlist-add"
                                                                                        href="../city-hunter/index.html"
                                                                                        data-post-id="19">
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
                                    </div>
                                </div>
                                <div id="reviews" class="jws-Reviews comments-area">

                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                <h5 id="reply-title" class="comment-reply-title">Add a review <small><a
                                                            rel="nofollow" id="cancel-comment-reply-link"
                                                            href="index.html#respond" style="display:none;">Cancel
                                                            reply</a></small></h5>
                                                <form action="https://streamvid.jwsuperthemes.com/wp-comments-post.php"
                                                    method="post" id="commentform" class="comment-form" novalidate>
                                                    <p class="comment-notes"><span id="email-notes">Your email address
                                                            will not be published.</span> <span
                                                            class="required-field-message">Required fields are marked
                                                            <span class="required">*</span></span></p>
                                                    <div class="comment-rating-field">
                                                        <label>Your rating</label>
                                                        <div id="comment_rating_stars">
                                                            <i class="fa fa-star" data-rating="1"></i>
                                                            <i class="fa fa-star" data-rating="2"></i>
                                                            <i class="fa fa-star" data-rating="3"></i>
                                                            <i class="fa fa-star" data-rating="4"></i>
                                                            <i class="fa fa-star" data-rating="5"></i>
                                                        </div>
                                                        <input type="hidden" name="comment_rating" id="comment_rating"
                                                            required>
                                                    </div>
                                                    <p class="comment-form-comment"><label class="form-label"
                                                            for="comment">Your review&nbsp;<span
                                                                class="required">*</span></label><textarea id="comment"
                                                            name="comment" cols="45" rows="8" required></textarea></p>
                                                    <p class="comment-form-author col-xl-6 col-12"><label
                                                            class="form-label">Name *</label><input id="author"
                                                            name="author" type="text" value="" size="30"
                                                            aria-required="true" /></p>
                                                    <p class="comment-form-email col-xl-6 col-12"><label
                                                            class="form-label">Email *</label><input id="email"
                                                            name="email" type="text" value="" size="30"
                                                            aria-required="true" /></p>
                                                    <p class="comment-form-cookies-consent"><input
                                                            id="wp-comment-cookies-consent"
                                                            name="wp-comment-cookies-consent" type="checkbox"
                                                            value="yes" /> <label for="wp-comment-cookies-consent">Save
                                                            my name, email, and website in this browser for the next
                                                            time I comment.</label></p>
                                                    <p class="form-submit"><input name="submit" type="submit"
                                                            id="submit" class="submit" value="Submit" /> <input
                                                            type='hidden' name='comment_post_ID' value='9053'
                                                            id='comment_post_ID' />
                                                        <input type='hidden' name='comment_parent' id='comment_parent'
                                                            value='0' />
                                                    </p>
                                                </form>
                                            </div><!-- #respond -->
                                        </div>
                                    </div>

                                    <div id="comments" class="comment_top">
                                        <ol class="comment-list">
                                            <li class="comment byuser comment-author-streamvid bypostauthor even thread-even depth-1"
                                                id="comment-168">
                                                <div id="div-comment-168" class="comment-body">

                                                    <div class="comment-avatar">
                                                        <img alt=''
                                                            src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2032%2032'%3E%3C/svg%3E"
                                                            data-lazy-srcset='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 300w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1024x576.jpg 1024w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-768x432.jpg 768w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1536x864.jpg 1536w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1422x800.jpg 1422w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-600x338.jpg 600w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2.jpg 1920w'
                                                            class='avatar avatar-32 photo' height='32' width='32'
                                                            decoding='async'
                                                            data-lazy-src="../wp-content/uploads/2023/06/spider_ex2-300x169.jpg" /><noscript><img
                                                                alt=''
                                                                src='../wp-content/uploads/2023/06/spider_ex2-300x169.jpg'
                                                                srcset='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 300w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1024x576.jpg 1024w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-768x432.jpg 768w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1536x864.jpg 1536w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1422x800.jpg 1422w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-600x338.jpg 600w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2.jpg 1920w'
                                                                class='avatar avatar-32 photo' height='32' width='32'
                                                                decoding='async' /></noscript>
                                                    </div>
                                                    <div class="comment-info">
                                                        <div class="jws-raring-result"><span data-star="5"
                                                                style="width:100%"></span></div>
                                                        <h6 class="comment-author">Jane Doe</h6>
                                                        <span class="comment-date">September 20, 2024 </span>
                                                        <div class="comment-content">
                                                            <p>John Wick: Chapter 4 is a non-stop thrill ride, packed
                                                                with jaw-dropping action, breathtaking visuals, and
                                                                Keanu Reeves in peak form. The film masterfully expands
                                                                the Wick universe while maintaining relentless
                                                                intensity. With stunning choreography and standout
                                                                performances, it’s a must-see for action fans. Pure
                                                                adrenaline from start to finish!</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </li><!-- #comment-## -->
                                        </ol>


                                    </div>

                                    <div class="clear"></div>
                                </div>

                            </div>

                        </div>
                    </div>

                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
@endsection
