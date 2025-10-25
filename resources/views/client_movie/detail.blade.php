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
    Phim {{ $movie->countries }}
    @foreach ($movie->categories->unique('id') as $category)
        , {{ $category->name }}
    @endforeach
@endsection
@section('content')
    <!-- details -->


    <div id="content" class="site-content">
        <div id="primary" class="content-area">
            <main id="main" class="site-main version-v2">

                <div class="container">
                    <div class="episodes-top">
                        <div class="row">
                            <div class="col-xl-9">



                                @if ($episode->link_video_internet != null)
                                    <video id="player" data-watched-duration="{{ $watchedDuration }}">

                                    </video>
                                    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
                                    <script>
                                        // URL của video HLS (.m3u8)
                                        const videoUrl = '{{ $episode->link_video_internet }}';

                                        // Lấy phần tử video
                                        const video = document.getElementById('player');

                                        // Kiểm tra nếu trình duyệt hỗ trợ native HLS (Safari)
                                        if (video.canPlayType('application/vnd.apple.mpegurl')) {
                                            video.src = videoUrl;
                                        } else if (Hls.isSupported()) {
                                            // Trình duyệt không hỗ trợ HLS natively, dùng HLS.js
                                            const hls = new Hls();
                                            hls.loadSource(videoUrl);
                                            hls.attachMedia(video);
                                        } else {
                                            console.error('HLS không được hỗ trợ trên trình duyệt này.');
                                        }
                                    </script>
                                @else
                                    <video height="465px" data-watched-duration="{{ $watchedDuration }}" id="player">

                                        <source src="{{ Storage::url('public/videos/' . $episode->video_url) }}"
                                            type="video/mp4">



                                    </video>
                                @endif

                                <script>
                                    const player = new Plyr('#player');

                                    player.on('ready', () => {
                                        const controls = document.querySelector('.plyr__controls');

                                        // Tạo nút lùi 10s
                                        const backBtn = document.createElement('button');
                                        backBtn.className = 'plyr__custom-button';
                                        backBtn.innerText = '⏪';
                                        backBtn.title = 'Lùi 10 giây';
                                        backBtn.addEventListener('click', () => {
                                            player.currentTime = Math.max(player.currentTime - 10, 0);
                                        });

                                        // Tạo nút tua 10s
                                        const forwardBtn = document.createElement('button');
                                        forwardBtn.className = 'plyr__custom-button';
                                        forwardBtn.innerText = '⏩';
                                        forwardBtn.title = 'Tua 10 giây';
                                        forwardBtn.addEventListener('click', () => {
                                            player.currentTime = Math.min(player.currentTime + 10, player.duration);
                                        });

                                        // Thêm nút vào thanh điều khiển (chèn sau nút play)
                                        const playButton = controls.querySelector('.plyr__control--overlaid') || controls.querySelector(
                                            '.plyr__control[aria-label="Play"]');
                                        if (playButton && playButton.parentNode) {
                                            controls.insertBefore(backBtn, playButton); // Chèn lùi 10s trước nút play
                                            controls.insertBefore(forwardBtn, playButton.nextSibling); // Chèn tua 10s sau nút play
                                        } else {
                                            // Nếu không tìm được nút play, thêm cuối cùng
                                            controls.appendChild(backBtn);
                                            controls.appendChild(forwardBtn);
                                        }
                                    });
                                </script>
                                <div class="vjs-loading-spinner"></div>




                            </div>

                            <div class="col-xl-3">

                                <div class="sidebar-list list">
                                    <div class="tv-shows-info">
                                        <h5><a target="_blank"
                                                href="../tv_shows/political-animal/index.html">{{ $movie->title }}</a></h5>
                                        <div class="dropdown select-seasion" data-id="4017">
                                            <button class="dropdown-toggle" type="button" data-display="episodes_version2">
                                                Season 1
                                            </button>
                                            <ul class="dropdown-menu jws-scrollbar" aria-labelledby="dropdownMenuButton">

                                                <li>
                                                    <a class="dropdown-item active" href="#" data-index="0"
                                                        data-value="Season 1">
                                                        Season 1 </a>
                                                </li>


                                                <li>
                                                    <a class="dropdown-item" href="#" data-index="1"
                                                        data-value="Season 2">
                                                        Season 2 </a>
                                                </li>


                                                <li>
                                                    <a class="dropdown-item" href="#" data-index="2"
                                                        data-value="Season 3">
                                                        Season 3 </a>
                                                </li>


                                            </ul>
                                        </div>


                                        <div class="jws-list-top">

                                            <div class="total-number">
                                                Episodes 1-7 </div>
                                            <a href="javascript:void(0)" class="change-layout"></a>
                                        </div>
                                    </div>
                                    <div class="jws-episodes_advanced-element layout-list">
                                        <div class="episodes-content layout4 jws-scrollbar">

                                            @if (isset($movie->episodes))

                                                @foreach ($movie->episodes as $list)
                                                 @php
                                        $style = '';

                                        // Nếu là tập hiện tại
                                        if (isset($episode) && $episode->id == $list->id) {
                                            $style = 'active';
                                        } else {
                                            // Nếu là tập đã xem
                                            foreach ($listWatched as $watched) {
                                                if ($watched->episode_id == $list->id) {
                                                    $style = 'active';
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                                    <div class="jws-pisodes_advanced-item {{ $style }}">


                                                        <div class="post-inner">
                                                            <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $list->id]) }}">
                                                                <div class="post-media">

                                                                    <img class='attachment-630x400 size-630x400'
                                                                        alt=''
                                                                        src="{{ asset('/clients/wp-content/uploads/2023/03/zoltan-tasi-0khu-rgbjzo-unsplash-630x400.jpg') }}">
                                                                    <span class="time"><i
                                                                            class="jws-icon-play-circle"></i>21:00</span>
                                                                </div>

                                                                <div class="episodes-info">
                                                                    <span class="episodes-number">S01E01</span>
                                                                    <h6>{{ $list->title}}</h6>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="number-item">
                                                            <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $list->id]) }}">
                                                                {{ $list->episode_number }}
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endif








                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="episodes-bottom row">
                        <div class="col-xl-9">
                            <div class="jws-breadcrumb"><a href="../index.html">Home</a><span class="delimiter"><span
                                        class="delimiter">/</span></span><a href="../tv_shows/index.html">Tv
                                    Shows</a><span class="delimiter">/</span><a href="../tv_shows_cat/music/index.html"
                                    rel="tag">Music</a>, <a href="../tv_shows_cat/reality/index.html"
                                    rel="tag">Reality</a><span class="delimiter">/</span><a
                                    href="../tv_shows/political-animal/index.html" class="tv-shows-link">Political
                                    Animal</a><span class="delimiter">/</span><a
                                    href="../tv_shows/political-animal/episodes/indexce5e.html?season=1"
                                    class="tv-shows-link">Season 1</a><span class="delimiter">/</span><span
                                    class="current">All or Nothing</span></div>
                            <div class="jws-title clear-both">
                                <h1 class="h3"><a href="../tv_shows/political-animal/index.html">Political
                                        Animal</a></h1>
                                <h6 class="season"><a
                                        href="../tv_shows/political-animal/episodes/indexce5e.html?season=1">Season
                                        1</a></h6>
                                <h6>All or Nothing</h6>
                            </div>
                            <div class="jws-meta-info clear-both">

                                <div class="jws-raring-number">
                                    <i class="fas fa-star"></i>0
                                </div>

                                <div class="jws-view">

                                    <i class="jws-icon-eye"></i>1911 Views
                                </div>

                                <div class="jws-comment-number">

                                    <i class="jws-icon-chat-dots"></i>0
                                </div>

                            </div>



                            <div class="jws-description"></div>

                            <div class="jws-tags">
                                <label>Tags:</label>
                                <a href="../tv_shows_tag/beautiful/index.html" rel="tag">Beautiful</a>, <a
                                    href="../tv_shows_tag/love/index.html" rel="tag">Love</a>
                            </div>

                            <div class="jws-tool">

                                <div class="jws-likes">
                                    <a href="#" class="like-button" data-type="tv_shows" data-post-id="4049">
                                        <i class="jws-icon-thumbs-up"></i>
                                        <span class="likes-count">2</span> <span>likes</span>
                                    </a>
                                </div>
                                <div class="jws-watchlist">
                                    <a class="watchlist-add" href="index.html" data-post-id="4049">
                                        <i class="jws-icon-plus"></i>
                                        <span>Watchlist</span>
                                        <span class="added">Watchlisted</span>
                                    </a>
                                </div>

                                <div class="jws-share">
                                    <a href="#" data-modal-jws="#share-videos">
                                        <i class="jws-icon-share-network"></i>
                                        <span>Share</span>
                                    </a>
                                </div>

                            </div>
                            <style id="elementor-post-4054">
                                .elementor-4054 .elementor-element.elementor-element-6ce9446 .post-inner {
                                    width: 280px;
                                }

                                .elementor-4054 .elementor-element.elementor-element-6ce9446 .jws-post-item {
                                    padding-right: calc(20px/2);
                                    padding-left: calc(20px/2);
                                }

                                .elementor-4054 .elementor-element.elementor-element-6ce9446 .tv_shows_advanced_content.row {
                                    margin-left: calc(-20px/2);
                                    margin-right: calc(-20px/2);
                                }

                                @media(max-width:767px) {
                                    .elementor-4054 .elementor-element.elementor-element-6ce9446 .post-inner {
                                        width: 205px;
                                    }
                                }
                            </style>
                            <div class="jws-related">
                                <style>
                                    .elementor-4054 .elementor-element.elementor-element-6ce9446 .post-inner {
                                        width: 280px;
                                    }

                                    .elementor-4054 .elementor-element.elementor-element-6ce9446 .jws-post-item {
                                        padding-right: calc(20px/2);
                                        padding-left: calc(20px/2);
                                    }

                                    .elementor-4054 .elementor-element.elementor-element-6ce9446 .tv_shows_advanced_content.row {
                                        margin-left: calc(-20px/2);
                                        margin-right: calc(-20px/2);
                                    }

                                    @media(max-width:767px) {
                                        .elementor-4054 .elementor-element.elementor-element-6ce9446 .post-inner {
                                            width: 205px;
                                        }
                                    }
                                </style>
                                <div data-elementor-type="wp-post" data-elementor-id="4054"
                                    class="elementor elementor-4054">
                                    <section
                                        class="elementor-section elementor-top-section elementor-element elementor-element-da548a8 elementor-section-full_width elementor-section-height-default elementor-section-height-default"
                                        data-id="da548a8" data-element_type="section">
                                        <div class="elementor-container elementor-column-gap-no jws_section_">
                                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a9ae5f9"
                                                data-id="a9ae5f9" data-element_type="column">
                                                <div class="elementor-widget-wrap elementor-element-populated">
                                                    <div class="elementor-element elementor-element-6ce9446 elementor-widget elementor-widget-jws_tv_shows_advanced"
                                                        data-id="6ce9446" data-element_type="widget"
                                                        data-widget_type="jws_tv_shows_advanced.default">
                                                        <div class="elementor-widget-container">


                                                            <div class="jws-tv-shows-advanced-element">
                                                                <h5 class="title-related">More Shows like this</h5>

                                                                <div class="row tv-shows-advanced-content layout2 tv-shows-advanced-ajax-6ce9446 jws_has_pagination owl-carousel jws-tv-shows-advanced-slider"
                                                                    data-owl-option='{"autoplay": false,                "nav": true,                "dots":false,                "autoplayTimeout": 5000,                "autoplayHoverPause":true,                "loop":false,                "autoWidth":true,                "smartSpeed": 500,                "responsive":{        "1500":{"items": 1,"slideBy": 1},        "1024":{"items": 1,"slideBy": 1},        "768":{"items": 1,"slideBy": 1},        "0":{"items": 1,"slideBy": 1}    }}'>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/the-unstoppable-soldier/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/02/Slide-2-av-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/the-unstoppable-soldier/index.html">
                                                                                        The Unstoppable Soldier </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/drama/index.html"
                                                                                        rel="tag">Drama</a>, <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/the-brady-bunch/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/06/The-Brady-Bunch-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/the-brady-bunch/index.html">
                                                                                        The Brady Bunch </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/family/index.html"
                                                                                        rel="tag">Family</a>, <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/love-and-war/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/06/Love-and-War-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/love-and-war/index.html">
                                                                                        Love and War </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/music/index.html"
                                                                                        rel="tag">Music</a>, <a
                                                                                        href="../tv_shows_cat/romance/index.html"
                                                                                        rel="tag">Romance</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/falling-water/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/04/Falling-Water-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/falling-water/index.html">
                                                                                        Falling Water </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/international/index.html"
                                                                                        rel="tag">International</a>,
                                                                                    <a href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/day-dreamers/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/06/Day-Dreamers-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/day-dreamers/index.html">
                                                                                        Day Dreamers </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/international/index.html"
                                                                                        rel="tag">International</a>,
                                                                                    <a href="../tv_shows_cat/music/index.html"
                                                                                        rel="tag">Music</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/american-nightmare/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/06/American-Nightmare-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/american-nightmare/index.html">
                                                                                        American Nightmare </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/drama/index.html"
                                                                                        rel="tag">Drama</a>, <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jws-post-item slider-item no_format">
                                                                        <div class="post-inner">
                                                                            <div class="post-media">
                                                                                <a class="videos-play fs-small fw-500"
                                                                                    href="../tv_shows/about-a-boy/index.html">
                                                                                    <i class="jws-icon-play-circle"></i>
                                                                                    Play Now </a>
                                                                                <img class='attachment-280x176 size-280x176'
                                                                                    alt=''
                                                                                    src=../wp-content/uploads/2023/06/About-a-Boy-280x176.jpg>
                                                                            </div>
                                                                            <div class="tv-shows-content">
                                                                                <h6 class="title">
                                                                                    <a
                                                                                        href="../tv_shows/about-a-boy/index.html">
                                                                                        About a Boy </a>
                                                                                </h6>
                                                                                <div class="tv-shows-cat fs-small">
                                                                                    <a href="../tv_shows_cat/music/index.html"
                                                                                        rel="tag">Music</a>, <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
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
                            </div>
                            <div id="reviews" class="jws-Reviews comments-area">

                                <div id="review_form_wrapper">
                                    <div id="review_form">
                                        <div id="respond" class="comment-respond">
                                            <h5 id="reply-title" class="comment-reply-title">Be the first to review
                                                &ldquo;Political Animal&rdquo; <small><a rel="nofollow"
                                                        id="cancel-comment-reply-link" href="index.html#respond"
                                                        style="display:none;">Cancel reply</a></small></h5>
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
                                                </div><input type="hidden" name="redirect_to" value="index.html">
                                                <p class="comment-form-comment"><label class="form-label"
                                                        for="comment">Your review&nbsp;<span
                                                            class="required">*</span></label>
                                                    <textarea id="comment" name="comment" cols="45" rows="8" required></textarea>
                                                </p>
                                                <p class="comment-form-author col-xl-6 col-12"><label
                                                        class="form-label">Name *</label><input id="author"
                                                        name="author" type="text" value="" size="30"
                                                        aria-required="true" /></p>
                                                <p class="comment-form-email col-xl-6 col-12"><label
                                                        class="form-label">Email *</label><input id="email"
                                                        name="email" type="text" value="" size="30"
                                                        aria-required="true" /></p>
                                                <p class="comment-form-cookies-consent"><input
                                                        id="wp-comment-cookies-consent" name="wp-comment-cookies-consent"
                                                        type="checkbox" value="yes" /> <label
                                                        for="wp-comment-cookies-consent">Save
                                                        my name, email, and website in this browser for the next
                                                        time I comment.</label></p>
                                                <p class="form-submit"><input name="submit" type="submit"
                                                        id="submit" class="submit" value="Submit" /> <input
                                                        type='hidden' name='comment_post_ID' value='4017'
                                                        id='comment_post_ID' />
                                                    <input type='hidden' name='comment_parent' id='comment_parent'
                                                        value='0' />
                                                </p>
                                            </form>
                                        </div><!-- #respond -->
                                    </div>
                                </div>

                                <div id="comments" class="comment_top">

                                    <p class="jws-noreviews">There are no reviews yet.</p>

                                </div>

                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="jws_sticky_move">
                                <style id="elementor-post-4078">
                                    .elementor-widget-heading .elementor-heading-title {
                                        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
                                        font-weight: var(--e-global-typography-primary-font-weight);
                                        color: var(--e-global-color-primary);
                                    }

                                    .elementor-4078 .elementor-element.elementor-element-9def3cf>.elementor-widget-container {
                                        margin: 0px 0px 5px 0px;
                                        padding: 0px 0px 15px 0px;
                                        border-style: solid;
                                        border-width: 0px 0px 1px 0px;
                                        border-color: #FFFFFF1A;
                                    }

                                    .elementor-4078 .elementor-element.elementor-element-9def3cf .elementor-heading-title {
                                        font-family: var(--e-global-typography-secondary-font-family), Sans-serif;
                                        font-weight: var(--e-global-typography-secondary-font-weight);
                                        color: var(--e-global-color-secondary);
                                    }
                                </style>
                                <style>
                                    .elementor-widget-heading .elementor-heading-title {
                                        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
                                        font-weight: var(--e-global-typography-primary-font-weight);
                                        color: var(--e-global-color-primary);
                                    }

                                    .elementor-4078 .elementor-element.elementor-element-9def3cf>.elementor-widget-container {
                                        margin: 0px 0px 5px 0px;
                                        padding: 0px 0px 15px 0px;
                                        border-style: solid;
                                        border-width: 0px 0px 1px 0px;
                                        border-color: #FFFFFF1A;
                                    }

                                    .elementor-4078 .elementor-element.elementor-element-9def3cf .elementor-heading-title {
                                        font-family: var(--e-global-typography-secondary-font-family), Sans-serif;
                                        font-weight: var(--e-global-typography-secondary-font-weight);
                                        color: var(--e-global-color-secondary);
                                    }
                                </style>
                                <div data-elementor-type="wp-post" data-elementor-id="4078"
                                    class="elementor elementor-4078">
                                    <section
                                        class="elementor-section elementor-top-section elementor-element elementor-element-6115c3a elementor-section-boxed elementor-section-height-default elementor-section-height-default"
                                        data-id="6115c3a" data-element_type="section">
                                        <div class="elementor-container elementor-column-gap-no jws_section_">
                                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-51db0ec"
                                                data-id="51db0ec" data-element_type="column">
                                                <div class="elementor-widget-wrap elementor-element-populated">
                                                    <div class="elementor-element elementor-element-9def3cf elementor-widget elementor-widget-heading"
                                                        data-id="9def3cf" data-element_type="widget"
                                                        data-widget_type="heading.default">
                                                        <div class="elementor-widget-container">
                                                            <h5 class="elementor-heading-title elementor-size-default">
                                                                Popular TV Shows</h5>
                                                        </div>
                                                    </div>
                                                    <div class="elementor-element elementor-element-5eea66e elementor-widget elementor-widget-jws_top_videos"
                                                        data-id="5eea66e" data-element_type="widget"
                                                        data-widget_type="jws_top_videos.default">
                                                        <div class="elementor-widget-container">
                                                            <div class="jws-top-videos-tabs-element">

                                                                <div class="top-videos-content row layout2">

                                                                    <div
                                                                        class="top-videos-item col-xl-12 col-lg-12 col-12">
                                                                        <div class="top-videos-inner">

                                                                            <div class="top-number h5">

                                                                                1
                                                                            </div>
                                                                            <div class="top-images">

                                                                                <a
                                                                                    href="../tv_shows/shark-hunters/index.html">
                                                                                    <img class='attachment-50x70 size-50x70'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/02/sahark-e1676001886337-50x70.jpg>
                                                                                </a>

                                                                            </div>
                                                                            <div class="top-content">
                                                                                <div class="video-years">2018</div>
                                                                                <h6>
                                                                                    <a
                                                                                        href="../tv_shows/shark-hunters/index.html">Shark
                                                                                        Hunters</a>
                                                                                </h6>
                                                                                <div class="video-cat">
                                                                                    <a href="../tv_shows_cat/action/index.html"
                                                                                        rel="tag">Action</a>
                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="top-videos-item col-xl-12 col-lg-12 col-12">
                                                                        <div class="top-videos-inner">

                                                                            <div class="top-number h5">

                                                                                2
                                                                            </div>
                                                                            <div class="top-images">

                                                                                <a
                                                                                    href="../tv_shows/the-wasted-times/index.html">
                                                                                    <img class='attachment-50x70 size-50x70'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/02/The-Wasted-Times-50x70.jpg>
                                                                                </a>

                                                                            </div>
                                                                            <div class="top-content">
                                                                                <div class="video-years">2028</div>
                                                                                <h6>
                                                                                    <a
                                                                                        href="../tv_shows/the-wasted-times/index.html">The
                                                                                        Wasted Times</a>
                                                                                </h6>
                                                                                <div class="video-cat">
                                                                                    <a href="../tv_shows_cat/drama/index.html"
                                                                                        rel="tag">Drama</a> <a
                                                                                        href="../tv_shows_cat/school/index.html"
                                                                                        rel="tag">School</a>
                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="top-videos-item col-xl-12 col-lg-12 col-12">
                                                                        <div class="top-videos-inner">

                                                                            <div class="top-number h5">

                                                                                3
                                                                            </div>
                                                                            <div class="top-images">

                                                                                <a
                                                                                    href="../tv_shows/political-animal/index.html">
                                                                                    <img class='attachment-50x70 size-50x70'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/03/Political-Animal-50x70.jpg>
                                                                                </a>

                                                                            </div>
                                                                            <div class="top-content">
                                                                                <div class="video-years">2019</div>
                                                                                <h6>
                                                                                    <a
                                                                                        href="../tv_shows/political-animal/index.html">Political
                                                                                        Animal</a>
                                                                                </h6>
                                                                                <div class="video-cat">
                                                                                    <a href="../tv_shows_cat/music/index.html"
                                                                                        rel="tag">Music</a> <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="top-videos-item col-xl-12 col-lg-12 col-12">
                                                                        <div class="top-videos-inner">

                                                                            <div class="top-number h5">

                                                                                4
                                                                            </div>
                                                                            <div class="top-images">

                                                                                <a
                                                                                    href="../tv_shows/the-unstoppable-soldier/index.html">
                                                                                    <img class='attachment-50x70 size-50x70'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/03/israel-palacio-IprD0z0zqss-unsplash-50x70.jpg>
                                                                                </a>

                                                                            </div>
                                                                            <div class="top-content">
                                                                                <div class="video-years">2020</div>
                                                                                <h6>
                                                                                    <a
                                                                                        href="../tv_shows/the-unstoppable-soldier/index.html">The
                                                                                        Unstoppable Soldier</a>
                                                                                </h6>
                                                                                <div class="video-cat">
                                                                                    <a href="../tv_shows_cat/drama/index.html"
                                                                                        rel="tag">Drama</a> <a
                                                                                        href="../tv_shows_cat/reality/index.html"
                                                                                        rel="tag">Reality</a>
                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="top-videos-item col-xl-12 col-lg-12 col-12">
                                                                        <div class="top-videos-inner">

                                                                            <div class="top-number h5">

                                                                                5
                                                                            </div>
                                                                            <div class="top-images">

                                                                                <a
                                                                                    href="../tv_shows/fireworks-wednesday/index.html">
                                                                                    <img class='attachment-50x70 size-50x70'
                                                                                        alt=''
                                                                                        src=../wp-content/uploads/2023/02/Fireworks-Wednesday-50x70.jpg>
                                                                                </a>

                                                                            </div>
                                                                            <div class="top-content">
                                                                                <div class="video-years">2019</div>
                                                                                <h6>
                                                                                    <a
                                                                                        href="../tv_shows/fireworks-wednesday/index.html">Fireworks
                                                                                        Wednesday</a>
                                                                                </h6>
                                                                                <div class="video-cat">
                                                                                    <a href="../tv_shows_cat/family/index.html"
                                                                                        rel="tag">Family</a> <a
                                                                                        href="../tv_shows_cat/international/index.html"
                                                                                        rel="tag">International</a>
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
                            </div>
                        </div>
                    </div>


                </div>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- #content -->
    <!-- end similar -->
@endsection
