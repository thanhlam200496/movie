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
            <form action="{{ route('admin.category.update',$category->id) }}" class="form" method="POST">
                @method('PUT')
                @csrf
                <div class="row" style="width: 100%">
                    <div class="col-12 col-md-7 form__content" style="width: 100%">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__group">
                                    <input type="text" class="form__input is-valid" value="{{ $category->name }}"
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
                                    <textarea id="text" class="form__textarea is-valid" value="" name="description"
                                        placeholder="Description">{{ $category->description }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback" style="color: red">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
            </form>
        </div>
        <!-- end form -->
    </div>
@endsection
