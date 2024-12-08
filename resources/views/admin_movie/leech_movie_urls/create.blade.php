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
            <form action="{{ route('admin.leech_url.store') }}" class="form" method="POST">

                @csrf
                <div class="row" style="width: 100%">
                    <div class="col-12 col-md-7 form__content" style="width: 100%">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text"  onkeyup="ChangeToSlug()" id="title"  class="form__input is-valid" value="{{ old('name') }}"
                                        name="name" placeholder="Name" style="width: 100%">
                                    @error('name')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('url_list_movie') }}"
                                        name="slug" readonly id="slug" placeholder="url_list_movie" style="width: 100%">
                                    @error('url_list_movie')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('url_list_movie') }}"
                                        name="url_list_movie" placeholder="url_list_movie" style="width: 100%">
                                    @error('url_list_movie')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('url_video_m3u8') }}"
                                        name="url_video_m3u8" placeholder="url_video_m3u8" style="width: 100%">
                                    @error('url_video_m3u8')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('url_detail') }}"
                                        name="url_detail" placeholder="url_detail" style="width: 100%">
                                    @error('url_detail')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('url_poster') }}"
                                        name="url_poster" placeholder="url_poster" style="width: 100%">
                                    @error('url_poster')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ old('name') }}"
                                        name="name" placeholder="Name" style="width: 100%">
                                    @error('name')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div> --}}
                           
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
            </form>
        </div>
        <!-- end form -->
    </div>
    <script>
        function ChangeToSlug() {
            var title = document.getElementById("title").value;
            
            //Đổi chữ hoa thành chữ thường
            var slug = title.toLowerCase();
        
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặc biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            
            document.getElementById('slug').value = slug;
        }
    </script>
@endsection
