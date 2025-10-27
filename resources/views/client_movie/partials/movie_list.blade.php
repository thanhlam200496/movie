{{-- movie_list.blade.php --}}
@foreach ($movies as $movie)
    <div class="jws-post-item col-xl-20 col-lg-4 col-md-6 col-12">
        <div class="post-inner">
            <div class="content-display">
                <div class="post-media">
                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id ?? '']) }}">
                        <img class='attachment-488x680 size-488x680' alt=''
                             src="{{ $movie->poster_url != null ? Storage::url('public/images/' . $movie->poster_url) : $movie->link_poster_internet }}">
                    </a>
                    <div class="content-hover">
                        <div class="hover-inner jws-scrollbar">
                            <div class="video-imdb"><span>{{ $movie->rating ?? '—' }}</span></div>
                            <h5 class="video_title">
                                <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id ?? '']) }}">
                                    {{ Str::limit($movie->title, 50) }}
                                </a>
                            </h5>
                            <div class="video-meta">
                                <div class="video-badge">{{ $movie->type_film }}</div>
                                <div class="video-years">{{ $movie->release_year }}</div>
                                <div class="video-time">{{ $movie->duration }}</div>
                            </div>
                            <div class="video-description">
                                {!! Str::limit($movie->description, 150) !!}
                            </div>
                            <div class="video-play">
                                <a class="video-trailer" href="{{ $movie->trailer_url }}"><i class="jws-icon-play-fill"></i> Trailer</a>
                                <a class="video-detail" href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id ?? '']) }}">
                                    <i class="jws-icon-info-light"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="video_title">
                    <a href="{{ route('movie.show', ['slug' => $movie->slug, 'episode' => $movie->episodes[0]->id ?? '']) }}">
                        {{ $movie->title }}
                    </a>
                </h6>
                <div class="video-cat">
                    @foreach ($movie->categories->unique('id') as $category)
                        <a href="#" rel="tag">{{ $category->name }}</a>@if (!$loop->last), @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
