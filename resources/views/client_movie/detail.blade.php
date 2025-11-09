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
@push('style')
    <style>
        .site-header {
            margin-bottom: 70px
        }


        .plyr__controls {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép xuống dòng */
            align-items: center;


        }

        /* Phần tử ngắt dòng */

        .plyr__break {
            flex-basis: 100%;
            /* Chiếm trọn chiều ngang */
            height: 0;
            /* Không chiếm thêm không gian thừa */
        }
    </style>
@endpush
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
                                    <video id="player" data-watched-duration="{{ $watched_duration }}">

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
                                    <video height="465px" data-watched-duration="{{ $watched_duration }}" id="player">

                                        <source src="{{ Storage::url('public/videos/' . $episode->video_url) }}"
                                            type="video/mp4">



                                    </video>
                                @endif

                                <script>
                                    const player = new Plyr('#player', {
                                        controls: [


                                            'rewind',
                                            'play', // cho play ra sau volume
                                            'fast-forward',
                                            'mute',
                                            'volume',
                                            'pip',
                                            'settings',
                                            'fullscreen',
                                            'progress',
                                            'current-time',
                                            'duration'
                                        ]
                                    });

                                    // player.on('ready', () => {
                                    //     const controls = document.querySelector('.plyr__controls');

                                    //     // Tạo nút lùi 10s
                                    //     const backBtn = document.createElement('button');
                                    //     backBtn.className = 'plyr__custom-button';
                                    //     backBtn.innerText = '⏪';
                                    //     backBtn.title = 'Lùi 10 giây';
                                    //     backBtn.addEventListener('click', () => {
                                    //         player.currentTime = Math.max(player.currentTime - 10, 0);
                                    //     });

                                    //     // Tạo nút tua 10s
                                    //     const forwardBtn = document.createElement('button');
                                    //     forwardBtn.className = 'plyr__custom-button';
                                    //     forwardBtn.innerText = '⏩';
                                    //     forwardBtn.title = 'Tua 10 giây';
                                    //     forwardBtn.addEventListener('click', () => {
                                    //         player.currentTime = Math.min(player.currentTime + 10, player.duration);
                                    //     });

                                    //     // Thêm nút vào thanh điều khiển (chèn sau nút play)
                                    //     const playButton = controls.querySelector('.plyr__control--overlaid') || controls.querySelector(
                                    //         '.plyr__control[aria-label="Play"]');
                                    //     if (playButton && playButton.parentNode) {
                                    //         controls.insertBefore(backBtn, playButton); // Chèn lùi 10s trước nút play
                                    //         controls.insertBefore(forwardBtn, playButton.nextSibling); // Chèn tua 10s sau nút play
                                    //     } else {
                                    //         // Nếu không tìm được nút play, thêm cuối cùng
                                    //         controls.appendChild(backBtn);
                                    //         controls.appendChild(forwardBtn);
                                    //     }
                                    // });
                                </script>
                                <div class="vjs-loading-spinner"></div>




                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const controls = document.querySelector('.plyr__controls');

                                    if (controls) {
                                        const breakElement = document.createElement('div');
                                        breakElement.classList.add('plyr__break');
                                        // Ví dụ: ngắt dòng sau phần volume
                                        const volume = controls.querySelector('[data-plyr="fullscreen"]');
                                        if (volume && volume.nextSibling) {
                                            controls.insertBefore(breakElement, volume.nextSibling);
                                        }
                                    }
                                });
                            </script>
                            <style>
                                .plyr__controls {
                                    display: flex;
                                    justify-content: space-evenly;
                                }
                            </style>
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
                                                {{ $totalEpisode }} tập</div>
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


                                                            <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $list->id]) }}"
                                                                class="episode-link" data-episode-id="{{ $list->id }}">
                                                                <div class="post-media">

                                                                    <img class='attachment-630x400 size-630x400'
                                                                        alt=''
                                                                        src="{{ asset('/clients/wp-content/uploads/2023/03/zoltan-tasi-0khu-rgbjzo-unsplash-630x400.jpg') }}">
                                                                    <span class="time"><i
                                                                            class="jws-icon-play-circle"></i>21:00</span>
                                                                </div>

                                                                <div class="episodes-info">
                                                                    <span class="episodes-number">S01E01</span>
                                                                    <h6>{{ $list->title }}</h6>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="number-item">
                                                            <a
                                                                href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $list->id]) }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/02/Slide-2-av-280x176.jpg') }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/06/The-Brady-Bunch-280x176.jpg') }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/06/Love-and-War-280x176.jpg') }}">
                                                                            </div>x
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/04/Falling-Water-280x176.jpg') }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/06/Day-Dreamers-280x176.jpg') }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/06/American-Nightmare-280x176.jpg') }}">
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
                                                                                    src="{{ asset('clients/wp-content/uploads/2023/06/About-a-Boy-280x176.jpg') }}">
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
                                            <form action="{{ route('comment') }}" method="POST" id="commentform"
                                                class="comment-form" novalidate>
                                                @csrf
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
                                                <input type="hidden" name="episode_id" id="episode_id"
                                                    value="{{ $episode->id }}">
                                                <p class="comment-form-comment"><label class="form-label"
                                                        for="comment">Your review&nbsp;<span
                                                            class="required">*</span></label>
                                                    <textarea id="comment" name="content" cols="45" rows="8" required>{{ $episode->title }}</textarea>
                                                </p>
                                                <p class="comment-form-author col-xl-6 col-12"><label
                                                        class="form-label">Name *</label><input id="author"
                                                        name="name" type="text" value="{{ Auth::user()->name??'' }}"
                                                        size="30" aria-required="true" /></p>
                                                <p class="comment-form-email col-xl-6 col-12"><label
                                                        class="form-label">Email *</label><input id="email"
                                                        name="email" type="text" value="{{ Auth::user()->email??'' }}"
                                                        size="30" aria-required="true" /></p>
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
                                <style>
                                    .submit.loading {
                                        position: relative;
                                        color: transparent !important;
                                    }

                                    .submit.loading::after {
                                        content: '';
                                        position: absolute;
                                        top: 50%;
                                        left: 50%;
                                        width: 18px;
                                        height: 18px;
                                        margin: -9px 0 0 -9px;
                                        border: 2px solid #fff;
                                        border-top-color: transparent;
                                        border-radius: 50%;
                                        animation: spin 0.7s linear infinite;
                                    }

                                    @keyframes spin {
                                        from {
                                            transform: rotate(0deg);
                                        }

                                        to {
                                            transform: rotate(360deg);
                                        }
                                    }
                                </style>

                                {{-- <div id="comments" class="comment_top">

                                    <p class="jws-noreviews">There are no reviews yet.</p>

                                </div> --}}
                                <div id="comments" class="comment_top">
                                    <ol class="comment-list" id="comment-list">
                                        @foreach ($comments as $comment)
                                            <li class="comment byuser comment-author-streamvid bypostauthor even thread-even depth-1"
                                                id="comment-168">
                                                <div id="div-comment-168" class="comment-body">

                                                    <div class="comment-avatar">
                                                        <img alt=''
                                                            src='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg'
                                                            srcset='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 300w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1024x576.jpg 1024w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-768x432.jpg 768w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1536x864.jpg 1536w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1422x800.jpg 1422w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-600x338.jpg 600w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2.jpg 1920w'
                                                            class='avatar avatar-32 photo' height='32' width='32'
                                                            decoding='async' />
                                                    </div>
                                                    <div class="comment-info">
                                                        <div class="jws-raring-result"><span data-star="5"
                                                                style="width:100%"></span></div>
                                                        <h6 class="comment-author">{{ $comment->name }}</h6>
                                                        <span class="comment-date">{{ $comment->created_at }} </span>
                                                        <div class="comment-content">
                                                            <p>{{ $comment->content }}</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </li>
                                        @endforeach

                                    </ol>



                                    <div class="clear"></div>
                                    <div class="jws-pagination-number">
                                        <ul class='page-numbers'>
                                            <li><span aria-current="page" class="page-numbers current">1</span></li>
                                            <li><a class="page-numbers"
                                                    href="https://streamvid.jwsuperthemes.com/movie/page/2/?sortby=views">2</a>
                                            </li>
                                            <li><a class="next page-numbers"
                                                    href="https://streamvid.jwsuperthemes.com/movie/page/2/?sortby=views"><i
                                                        class="jws-icon-caret-double-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Thêm jQuery và script Ajax -->
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                // Gửi bình luận chính qua Ajax
                                $(document).on('submit', '#commentform', function(e) {
                                    e.preventDefault();
                                    let content = $('textarea[name="content"]').val();
                                    let episodeId = $('input[name="episode_id"]').val();
                                    let name = $('input[name="name"]').val();
                                    let email = $('input[name="email"]').val();


                                    $.ajax({
                                        url: '{{ route('comment') }}',
                                        method: 'POST',
                                        data: {
                                            content: content,
                                            episode_id: episodeId,
                                            name: name,
                                            email: email,
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        },

                                        beforeSend: function() {
                                            // 👇 đổi nút thành trạng thái "đang gửi"
                                            $('#submit')
                                                .prop('disabled', true) // khóa nút
                                                .val('Đang gửi...') // đổi text
                                                .addClass('loading'); // thêm class nếu muốn hiệu ứng CSS
                                        },

                                        success: function(response) {
                                            if (response.success) {
                                                $('#text').val('');
                                                $('#error-message').empty();
                                                loadComments(currentPage);
                                            }
                                        },

                                        error: function(xhr) {
                                            if (xhr.status === 422) {
                                                let errors = xhr.responseJSON.errors;
                                                $('#error-message').empty();
                                                if (errors.content) {
                                                    $('#error-message').text(errors.content[0]);
                                                }
                                            } else {
                                                console.log('Lỗi khác:', xhr.responseText);
                                            }
                                        },

                                        complete: function() {
                                            // 👇 khôi phục nút về trạng thái ban đầu
                                            $('#submit')
                                                .prop('disabled', false)
                                                .val('Submit')
                                                .removeClass('loading');
                                        }
                                    });


                                });

                                let currentPage = 1;
                                let shownReplies = {};

                                // Hàm tạo HTML cho bình luận
                                function renderComment(comment, parentContent = '') {
                                    let itemClass = comment.parent_id ? 'comments__item comments__item--answer' : 'comments__item';
                                    let hasReplies = comment.replies && comment.replies.length > 0;
                                    let isShown = shownReplies[comment.id] || false;
                                    let displayStyle = comment.parent_id && !isShown ? 'display: none;' : '';
                                    //                             let html = `
        //     <li class="${itemClass}" data-comment-id="${comment.id}" data-parent-id="${comment.parent_id || ''}" style="${displayStyle}">
        //         <div class="comments__autor">
        //             <img class="comments__avatar" src="{{ asset('clients/img/avatar.svg') }}" alt="">
        //             <span class="comments__name">${comment.user.name}</span>
        //             <span class="comments__time">${new Date(comment.created_at).toLocaleString()}</span>
        //         </div>
        // `;
                                    let html = `
        <li class="comment byuser comment-author-streamvid bypostauthor even thread-even depth-1"
                                                id="comment-168">
                                                <div id="div-comment-168" class="comment-body">

                                                    <div class="comment-avatar">
                                                        <img alt=''
                                                            src='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg'
                                                            srcset='https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-300x169.jpg 300w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1024x576.jpg 1024w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-768x432.jpg 768w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1536x864.jpg 1536w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-1422x800.jpg 1422w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2-600x338.jpg 600w, https://streamvid.jwsuperthemes.com/wp-content/uploads/2023/06/spider_ex2.jpg 1920w'
                                                            class='avatar avatar-32 photo' height='32' width='32'
                                                            decoding='async' />
                                                    </div>
                                                    <div class="comment-info">
                                                        <div class="jws-raring-result"><span data-star="5"
                                                                style="width:100%"></span></div>
                                                        <h6 class="comment-author">${comment.name}</h6>
                                                        <span class="comment-date">${new Date(comment.created_at).toLocaleString()} </span>
                                                        <div class="comment-content">
                                                            <p>${comment.content}</p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </li>
        `;

                                    return html;
                                }

                                // Load bình luận và phân trang
                                function loadComments(page = 1) {
                                    let episodeId = $('input[name="episode_id"]').val();
                                    $.get('/comments/' + episodeId + '?page=' + page, function(data) {
                                        $('#comment-list').empty();
                                        data.comments.forEach(comment => {
                                            $('#comment-list').append(renderComment(comment));
                                        });

                                        // Cập nhật tổng số bình luận
                                        $('#total-comments').text(data.total);

                                        Object.keys(shownReplies).forEach(commentId => {
                                            if (shownReplies[commentId]) {
                                                $(`#comment-list li[data-parent-id="${commentId}"]`).show();
                                            }
                                        });

                                        let perPage = 5;
                                        let from = (data.current_page - 1) * perPage + 1;
                                        let to = Math.min(data.current_page * perPage, data.total);
                                        $('#page-info').text(`${from} - ${to} from ${data.total}`);

                                        updatePagination(data.current_page, data.last_page);
                                    });
                                }

                                // Tạo phân trang động
                                function updatePagination(currentPage, lastPage) {
                                    $('#paginator').empty();
                                    if (currentPage > 1) {
                                        $('#paginator').append(`
                <li>
                    <a href="#" class="page-link" data-page="${currentPage - 1}">
                        <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            `);
                                    }

                                    let startPage = Math.max(1, currentPage - 2);
                                    let endPage = Math.min(lastPage, currentPage + 2);
                                    for (let i = startPage; i <= endPage; i++) {
                                        $('#paginator').append(`
                <li class="${i === currentPage ? 'active' : ''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                </li>
            `);
                                    }

                                    if (currentPage < lastPage) {
                                        $('#paginator').append(`
                <li>
                    <a href="#" class="page-link" data-page="${currentPage + 1}">
                        <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
            `);
                                    }

                                    $('.page-link').click(function(e) {
                                        e.preventDefault();
                                        let page = $(this).data('page');
                                        currentPage = page;
                                        loadComments(page);
                                    });
                                }



                                // Hiển thị popup và nội dung bình luận cha
                                $(document).on('click', '.reply-btn', function() {
                                    let commentId = $(this).data('comment-id');
                                    let parentContent = $(this).data('content');
                                    let shortParentContent = parentContent.length > 50 ? parentContent.substring(0, 50) + '...' :
                                        parentContent;
                                    $('#parent_id').val(commentId);
                                    $('#reply-text').val('');
                                    $('#parent-content').text(`Replying to: "${shortParentContent}"`);
                                    $('#reply-popup-overlay').show();
                                    $('#reply-popup').show();
                                });

                                // Đóng popup
                                $(document).on('click', '#close-popup, #reply-popup-overlay', function() {
                                    $('#reply-popup-overlay').hide();
                                    $('#reply-popup').hide();
                                    $('#reply-text').val('');
                                    $('#reply-error-message').empty();
                                    $('#parent-content').text('');
                                });

                                // Ngăn sự kiện click trong popup lan ra overlay
                                $(document).on('click', '#reply-popup', function(e) {
                                    e.stopPropagation();
                                });

                                // Gửi reply qua Ajax
                                $(document).on('submit', '#reply-form', function(e) {
                                    e.preventDefault();
                                    let content = $('#reply-text').val();
                                    let episodeId = $('input[name="episode_id"]').val();
                                    let parentId = $('#parent_id').val();

                                    $.ajax({
                                        url: '{{ route('comment') }}',
                                        method: 'POST',
                                        data: {
                                            content: content,
                                            episode_id: episodeId,
                                            parent_id: parentId,
                                            _token: $('input[name="_token"]').val()
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                $('#reply-text').val('');
                                                $('#reply-error-message').empty();
                                                $('#parent-content').text('');
                                                $('#reply-popup-overlay').hide();
                                                $('#reply-popup').hide();
                                                loadComments(currentPage);
                                            }
                                        },
                                        error: function(xhr) {
                                            if (xhr.status === 422) {
                                                let errors = xhr.responseJSON.errors;
                                                $('#reply-error-message').empty();
                                                if (errors.content) {
                                                    $('#reply-error-message').text(errors.content[0]);
                                                }
                                            } else {
                                                console.log('Lỗi khác:', xhr.responseText);
                                            }
                                        }
                                    });
                                });

                                // // Xử lý nút "Show more"/"Show less"
                                // $(document).on('click', '.toggle-replies', function() {
                                //     let commentId = $(this).data('comment-id');
                                //     let $replies = $(`#comment-list li[data-parent-id="${commentId}"]`);
                                //     if ($replies.is(':visible')) {
                                //         $replies.hide();
                                //         $(this).text(`Show more (${$replies.length})`);
                                //         shownReplies[commentId] = false;
                                //     } else {
                                //         $replies.show();
                                //         $(this).text('Show less');
                                //         shownReplies[commentId] = true;
                                //     }
                                // });

                                // Gọi loadComments khi trang được tải
                                $(document).ready(function() {
                                    loadComments();
                                });
                            </script>

                            <!-- CSS tùy chỉnh -->
                            <style>
                                .sign__btn:hover {
                                    background: #0056b3;
                                }

                                #close-popup:hover {
                                    background: #999;
                                }

                                .popup {
                                    animation: fadeIn 0.3s ease-in-out;
                                }

                                #reply-popup-overlay {
                                    animation: fadeInOverlay 0.3s ease-in-out;
                                }

                                @keyframes fadeIn {
                                    from {
                                        opacity: 0;
                                        transform: translate(-50%, -60%);
                                    }

                                    to {
                                        opacity: 1;
                                        transform: translate(-50%, -50%);
                                    }
                                }

                                @keyframes fadeInOverlay {
                                    from {
                                        opacity: 0;
                                    }

                                    to {
                                        opacity: 1;
                                    }
                                }

                                .comments__item--answer {
                                    margin-left: 20px;
                                    border-left: 2px solid #ddd;
                                    padding-left: 15px;
                                }

                                .toggle-replies:hover {
                                    text-decoration: underline;
                                }

                                .comments__text,
                                .comments__quote,
                                #parent-content {
                                    word-wrap: break-word;
                                    overflow-wrap: break-word;
                                    white-space: normal;
                                    max-width: 100%;
                                }
                            </style>
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
                                                                                            src="{{ asset('clients/wp-content/uploads/2023/02/sahark-e1676001886337-50x70.jpg') }}">
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
                                                                                            src="{{ asset('clients/wp-content/uploads/2023/02/The-Wasted-Times-50x70.jpg') }}">
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
                                                                                            src="{{ asset('clients/wp-content/uploads/2023/03/Political-Animal-50x70.jpg') }}">
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
                                                                                            src="{{ asset('clients/wp-content/uploads/2023/03/israel-palacio-IprD0z0zqss-unsplash-50x70.jpg') }}">
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
                                                                                            src="{{ asset('clients/wp-content/uploads/2023/02/Fireworks-Wednesday-50x70.jpg') }}">
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
                                                                                                rel="tag">Family</a>
                                                                                            <a href="../tv_shows_cat/international/index.html"
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videoWrapperSelector = '.col-xl-9'; // container chứa video area
            const videoWrapper = document.querySelector(videoWrapperSelector);
            let plyrInstance = null;
            let hlsInstance = null;

            // Utility: destroy existing player/hls cleanly
            function destroyPlayer() {
                try {
                    if (hlsInstance) {
                        try {
                            hlsInstance.destroy();
                        } catch (e) {
                            console.warn('destroy hls err', e);
                        }
                        hlsInstance = null;
                    }
                    if (plyrInstance) {
                        try {
                            plyrInstance.destroy();
                        } catch (e) {
                            console.warn('destroy plyr err', e);
                        }
                        plyrInstance = null;
                    }
                    // remove any existing #player to avoid duplicates
                    const old = videoWrapper.querySelector('#player');
                    if (old) old.remove();
                } catch (err) {
                    console.error('Error destroying player:', err);
                }
            }

            // Create video element markup and return video DOM element
            function createVideoElement() {
                // create a <video> element with reasonable attributes
                const video = document.createElement('video');
                video.id = 'player';
                // video.setAttribute('playsinline', ''); // important for mobile
                video.setAttribute('controls', ''); // show controls
                video.setAttribute('preload', 'metadata');
                // optional: video.muted = false;
                return video;
            }

            // Initialize player for given data from server
            // data = { id, title, type: 'hls'|'mp4', video_url }
            async function initVideoFromData(data) {
                destroyPlayer();

                // Create and insert new video element into wrapper (replace area)
                const video = createVideoElement();
                // Insert video at top of wrapper (or use specific sub-container)
                // Better to find exact container for video area if not wrapper
                // we assume wrapper contains video and we want to place at its top
                videoWrapper.prepend(video);

                // HLS case
                if (data.type === 'hls') {
                    if (Hls.isSupported()) {
                        hlsInstance = new Hls();
                        // attach event listeners for debug if needed
                        hlsInstance.on(Hls.Events.ERROR, function(event, data_) {
                            console.warn('Hls error', event, data_);
                        });
                        hlsInstance.loadSource(data.video_url);
                        hlsInstance.attachMedia(video);
                        // Wait until media attached and manifest parsed before init Plyr
                        hlsInstance.on(Hls.Events.MANIFEST_PARSED, function() {
                            // initialize Plyr after HLS is ready
                            plyrInstance = new Plyr('#player');
                            // Optionally resume from watched_duration if you have it in data
                            if (data.watched_duration) {
                                try {
                                    video.currentTime = Number(data.watched_duration) || 0;
                                } catch (e) {}
                            }
                        });
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        // Safari native HLS
                        video.src = data.video_url;
                        video.addEventListener('loadedmetadata', () => {
                            plyrInstance = new Plyr('#player');
                            if (data.watched_duration) try {
                                video.currentTime = Number(data.watched_duration) || 0;
                            } catch (e) {}
                        }, {
                            once: true
                        });
                    } else {
                        console.error('HLS not supported');
                    }
                } else {
                    // mp4: add <source> and call load()
                    const source = document.createElement('source');
                    source.src = data.video_url;
                    source.type = 'video/mp4';
                    video.appendChild(source);
                    // ensure browser picks up source
                    video.load();
                    // wait metadata then init Plyr
                    video.addEventListener('loadedmetadata', () => {
                        plyrInstance = new Plyr('#player');
                        if (data.watched_duration) try {
                            video.currentTime = Number(data.watched_duration) || 0;
                        } catch (e) {}
                    }, {
                        once: true
                    });
                }
            }

            // Event delegation: click episode links
            document.addEventListener('click', async (e) => {
                const link = e.target.closest('.episode-link, .jws-pisodes_advanced-item a');
                if (!link) return;

                e.preventDefault();

                // find episode id from data attribute or parse href
                const episodeId = link.dataset.episodeId || (new URL(link.href, window.location.origin)
                    .pathname.split('/').pop());
                if (!episodeId) {
                    console.warn('Missing episode id');
                    return;
                }

                try {
                    const res = await fetch(`/ajax/episode/${episodeId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!res.ok) {
                        const txt = await res.text().catch(() => null);
                        throw new Error('Fetch error: ' + res.status + ' ' + txt);
                    }

                    const data = await res.json();
                    if (data.error) {
                        console.warn('Server error:', data.error);
                        return;
                    }

                    // init video player with returned data
                    await initVideoFromData(data);

                    // update active class visual
                    document.querySelectorAll('.jws-pisodes_advanced-item').forEach(el => el.classList
                        .remove('active'));
                    const activeItem = link.closest('.jws-pisodes_advanced-item');
                    if (activeItem) activeItem.classList.add('active');

                    // Optionally update URL without reloading
                    const newUrl = new URL(link.href, window.location.origin);
                    window.history.pushState({}, '', newUrl);

                } catch (err) {
                    console.error('Error loading episode:', err);
                }
            });

            // OPTIONAL: handle back/forward to re-load episode from URL
            window.addEventListener('popstate', () => {
                const pathParts = window.location.pathname.split('/');
                const last = pathParts[pathParts.length - 1];
                const id = Number(last) ? last : null;
                if (id) {
                    // simulate click on corresponding link if present
                    const link = document.querySelector(`[data-episode-id="${id}"]`);
                    if (link) link.click();
                }
            });

            // INITIAL: if page already has a player markup (initial load), we should instantiate it safely once
            (function initInitialPlayer() {
                const existingVideo = document.getElementById('player');
                if (!existingVideo) return;
                // If it's HLS and has data attribute or blade code handled it, you may initialize Plyr here.
                // But to avoid double-init, ensure code that was previously in blade is removed.
                try {
                    plyrInstance = new Plyr('#player');
                } catch (e) {
                    console.warn('init initial plyr err', e);
                }
            })();
        });
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videoWrapperSelector = '.col-xl-9'; // container chứa video area
            const videoWrapper = document.querySelector(videoWrapperSelector);
            let plyrInstance = null;
            let hlsInstance = null;
            let saveInterval = null; // interval lưu lịch sử

            // ID người dùng và CSRF từ Laravel
            const userId = {{ auth()->user()->id??0 }};
            const token = '{{ csrf_token() }}';

            if (userId) {
// --- Hàm gửi lịch sử xem ---
            async function saveViewHistory(video, episodeId) {
                try {
                    if (!video || video.paused) return; // chỉ lưu khi đang phát
                    const currentTime = Math.floor(video.currentTime);

                    const response = await fetch('/api/view-history', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            episode_id: episodeId,
                            watched_duration: currentTime,
                        }),
                    });

                    if (!response.ok) throw new Error('Failed to save view history');
                    const data = await response.json();
                    console.log('View history updated:', data);
                } catch (error) {
                    console.error('Error updating view history:', error);
                }
            }
            }


            // --- Dọn dẹp ---
            function destroyPlayer() {
                try {
                    if (saveInterval) clearInterval(saveInterval);
                    if (hlsInstance) {
                        hlsInstance.destroy();
                        hlsInstance = null;
                    }
                    if (plyrInstance) {
                        plyrInstance.destroy();
                        plyrInstance = null;
                    }
                    const old = videoWrapper.querySelector('#player');
                    if (old) old.remove();
                } catch (err) {
                    console.error('Error destroying player:', err);
                }
            }

            // --- Tạo thẻ video ---
            function createVideoElement() {
                const video = document.createElement('video');
                video.id = 'player';
                video.setAttribute('controls', '');
                video.setAttribute('preload', 'metadata');
                return video;
            }

            // --- Khởi tạo video từ dữ liệu trả về ---
            async function initVideoFromData(data) {
                destroyPlayer();
                const video = createVideoElement();
                videoWrapper.prepend(video);

                // HLS
                if (data.type === 'hls') {
                    if (Hls.isSupported()) {
                        hlsInstance = new Hls();
                        hlsInstance.loadSource(data.video_url);
                        hlsInstance.attachMedia(video);
                        hlsInstance.on(Hls.Events.MANIFEST_PARSED, function() {
                            plyrInstance = new Plyr('#player');
                            if (data.watched_duration)
                                video.currentTime = Number(data.watched_duration) || 0;
                        });
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = data.video_url;
                        video.addEventListener(
                            'loadedmetadata',
                            () => {
                                plyrInstance = new Plyr('#player');
                                if (data.watched_duration)
                                    video.currentTime = Number(data.watched_duration) || 0;
                            }, {
                                once: true
                            }
                        );
                    }
                } else {
                    // MP4
                    const source = document.createElement('source');
                    source.src = data.video_url;
                    source.type = 'video/mp4';
                    video.appendChild(source);
                    video.load();
                    video.addEventListener(
                        'loadedmetadata',
                        () => {
                            plyrInstance = new Plyr('#player');
                            if (data.watched_duration)
                                video.currentTime = Number(data.watched_duration) || 0;
                        }, {
                            once: true
                        }
                    );
                }

                // --- Bắt đầu lưu lịch sử xem ---
                const episodeId = data.id;
                saveInterval = setInterval(() => saveViewHistory(video, episodeId), 5000);
            }

            // --- Sự kiện click đổi tập ---
            document.addEventListener('click', async (e) => {
                const link = e.target.closest('.episode-link, .jws-pisodes_advanced-item a');
                if (!link) return;
                e.preventDefault();

                const episodeId =
                    link.dataset.episodeId ||
                    new URL(link.href, window.location.origin).pathname.split('/').pop();
                if (!episodeId) return console.warn('Missing episode id');

                try {
                    const res = await fetch(`/ajax/episode/${episodeId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            Accept: 'application/json',
                        },
                    });
                    if (!res.ok) throw new Error('Fetch error ' + res.status);
                    const data = await res.json();
                    if (data.error) return console.warn('Server error:', data.error);

                    await initVideoFromData(data);

                    document.querySelectorAll('.jws-pisodes_advanced-item').forEach((el) =>
                        el.classList.remove('active')
                    );

                    // đổi id tập phim trong form comment
                    const idEpisode = document.getElementById('episode_id');
                    idEpisode.value = data.id;
                    // Gọi loadComments khi trang được tải
                                $(document).ready(function() {
                                    loadComments();
                                });

                    const activeItem = link.closest('.jws-pisodes_advanced-item');
                    if (activeItem) activeItem.classList.add('active');

                    window.history.pushState({}, '', link.href);
                } catch (err) {
                    console.error('Error loading episode:', err);
                }
            });

            // --- Nếu load sẵn player ban đầu ---
            (function initInitialPlayer() {
                const existingVideo = document.getElementById('player');
                if (!existingVideo) return;
                try {
                    plyrInstance = new Plyr('#player');
                    const currentEpisode = {{ $episode->id }};
                    saveInterval = setInterval(() => saveViewHistory(existingVideo, currentEpisode), 5000);
                } catch (e) {
                    console.warn('init initial plyr err', e);
                }
            })();
        });
    </script>

    @if (!empty(Auth::user()))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const video = document.getElementById('player'); // Lấy thẻ video
                const watched_duration = parseInt(video.getAttribute('data-watched-duration'), 10) ||
                    0; // Lấy watched_duration từ data-watched-duration

                // Set thời gian bắt đầu cho video
                video.currentTime = watched_duration;

                console.log("Video starts at:", watched_duration);

                // Xử lý các sự kiện khác như lưu lịch sử xem
            });
        </script>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const video = document.getElementById('player'); // Lấy thẻ video
                const userId = {{ auth()->user()->id }};
                const movieId = {{ $episode->id }}; // Lấy ID phim từ server (Laravel Blade)
                const token = '{{ csrf_token() }}'; // CSRF token nếu cần

                // Hàm để gửi dữ liệu lịch sử xem
                function saveViewHistory() {
                    const currentTime = video.currentTime; // Thời gian hiện tại của video

                    // Gửi dữ liệu đến server bằng fetch
                    fetch('/api/view-history', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer <YOUR_ACCESS_TOKEN>` // Thay YOUR_ACCESS_TOKEN bằng token thực tế nếu cần
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                episode_id: movieId,
                                watched_duration: Math.floor(
                                    currentTime), // Lấy thời gian hiện tại (làm tròn)
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to save view history');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('View history updated:', data);
                        })
                        .catch(error => {
                            console.error('Error updating view history:', error);
                        });
                }

                // Gửi dữ liệu định kỳ mỗi 5 giây
                setInterval(() => {
                    if (!video.paused) { // Chỉ lưu nếu video đang được phát
                        saveViewHistory();
                    }
                }, 5000); // Mỗi 5 giây
            });
        </script> --}}
    @endif
@endsection
