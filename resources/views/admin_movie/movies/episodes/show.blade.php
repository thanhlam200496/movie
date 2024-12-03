@extends('admin_movie.layouts.default')
@section('main')
    <div class="row">
        <!-- main title -->
        <div class="col-12">
            <div class="main__title"
                style="position: fixed; background-color: #131720; z-index: 1000; padding: 10px 0; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); width: 100%">
                <h2>Add new item</h2>
            </div>
        </div>
        <!-- end main title -->

        <!-- form -->
        <div class="col-12" style="margin-top: 80px;"> <!-- Adjust for fixed title height -->
            <form action="{{ route('admin.episode.update',['movie_id'=>$movie_id,'episode_id'=>$episode->id]) }}" class="form" method="POST" enctype="multipart/form-data">
@method('PUT')
                @csrf
                <div class="row">
                    <div class="col-12 col-md-5 form__cover">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12">
                                <div class="form__img">
                                    <label for="form__img-upload">Poster</label>
                                    {{-- <input id="form__img-upload" name="poster_url" type="file"
                                        accept=".png, .jpg, .jpeg" > --}}
                                    <img id="form__img" src="{{Storage::url('public/images/'.$movie->poster_url)}}" alt=" ">
                                    @error('poster_url')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-7 form__content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input" name="title" value="{{$episode->title}}"
                                        placeholder="Title">
                                    @error('title')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <input type="text" name="episode_number" class="form__input" placeholder="Episode number"
                                        value="{{$episode->episode_number}}">
                                    @error('episode_number')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__video">
                                    <label id="movie1" for="form__video-upload">Upload video</label>
                                    <input data-name="#movie1" id="form__video-upload" name="video_url"
                                        class="form__video-upload" type="file" accept="video/mp4,video/x-m4v,video/*">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group form__group--link">
                                    <input type="text" class="form__input" value="{{$episode->link_video_internet}}"  name="link_video_internet" placeholder="or add a link">
                                </div>
                            </div>

                            

                            

                            
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="row">
                           

                            <div class="col-12">
                                <button type="submit" class="form__btn">publish</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const movieRadio = document.getElementById('type1'); // Radio button Movie
                        const tvShowRadio = document.getElementById('type2'); // Radio button TV Show
                        const uploadSection = document.querySelectorAll('.form__video, .form__group--link'); // Chọn các div cần ẩn/hiện
                
                        // Hàm ẩn hoặc hiện phần upload
                        function toggleUploadSection() {
                            if (movieRadio.checked) {
                                uploadSection.forEach(element => element.style.display = 'block'); // Hiện khi chọn Movie
                            } else {
                                uploadSection.forEach(element => element.style.display = 'none');  // Ẩn khi chọn TV Show
                            }
                        }
                
                        // Lắng nghe sự kiện thay đổi radio button
                        movieRadio.addEventListener('change', toggleUploadSection);
                        tvShowRadio.addEventListener('change', toggleUploadSection);
                
                        // Gọi hàm khi tải trang lần đầu để đảm bảo trạng thái đúng
                        toggleUploadSection();
                    });
                </script>
                
            </form>
        </div>
        <!-- end form -->
    </div>
@endsection
