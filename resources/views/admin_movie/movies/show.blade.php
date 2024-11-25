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
            <form action="{{ route('admin.movie.update', $movie->id) }}" class="form" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-12 col-md-5 form__cover">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-12">
                                <div class="form__img">
                                    <label for="form__img-upload">Upload cover (190 x 270)</label>
                                    <input id="form__img-upload" name="poster_url_new" type="file"
                                        accept=".png, .jpg, .jpeg">
                                    <img id="form__img" src="{{ Storage::url('public/images/' . $movie->poster_url) }}"
                                        alt=" ">
                                    @error('poster_url')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-12">
                            @if ($movie->video_url == null || $movie->video_url == '')
                                <span style="color: #fff">Không có video</span>
                            @else
                                <video id="videoPlayer" controls width="270">
                                    <source src="{{ Storage::url('public/videos/' . $movie->video_url) }}" type="video/mp4">
                                    Trình duyệt của bạn không hỗ trợ thẻ video.
                                </video>
                            @endif
                            </div>
                        </div>
                    </div>



                    <div class="col-12 col-md-7 form__content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Title:</label>
                                    <input type="text" class="form__input" name="title" value="{{ $movie->title }}"
                                        placeholder="Title">
                                    @error('title')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Description:</label>
                                    <textarea id="text" name="description" class="form__textarea" placeholder="Description">{{ $movie->description }}</textarea>
                                    @error('description')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Release year:</label>
                                    <input type="text" name="release_year" class="form__input" placeholder="Release year"
                                        value="{{ $movie->release_year }}">
                                    @error('release_year')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Running timed in minutes:</label>
                                    <input type="text" name="duration" class="form__input"
                                        placeholder="Running timed in minutes" value="{{ $movie->duration }}">
                                    @error('duration')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Status:</label>
                                    <select class="js-example-basic-single" name="status" id="quality">
                                        <option value="Hidden" {{ $movie->status == 'Hidden' ? 'selected' : '' }}>Hidden</option>
                                        <option value="Public" {{ $movie->status == 'Public' ? 'selected' : '' }}>Public</option>
                                        <option value="Not Released"
                                            {{ $movie->status == 'Not Released' ? 'selected' : '' }}>Not Released</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Age:</label>
                                    <input type="text" name="age_rating" class="form__input" placeholder="Age"
                                        value="{{ $movie->age_rating }}">
                                    @error('age_rating')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Countries:</label>
                                    <select class="js-example-basic-multiple" name="countries[]" id="country" multiple="multiple">

                                        <option value="Afghanistan" @if (in_array('Afghanistan', old('countries', []))) selected @endif>
                                            Afghanistan</option>
                                        <option value="Åland Islands" @if (in_array('Åland Islands', old('countries', []))) selected @endif>
                                            Åland Islands</option>
                                        <option value="Albania" @if (in_array('Albania', old('countries', []))) selected @endif>Albania
                                        </option>
                                        <option value="Algeria" @if (in_array('Algeria', old('countries', []))) selected @endif>Algeria
                                        </option>
                                        <option value="American Samoa" @if (in_array('American Samoa', old('countries', []))) selected @endif>
                                            American Samoa</option>
                                        <option value="Andorra" @if (in_array('Andorra', old('countries', []))) selected @endif>Andorra
                                        </option>
                                        <option value="Angola" @if (in_array('Angola', old('countries', []))) selected @endif>Angola
                                        </option>
                                        <option value="Anguilla" @if (in_array('Anguilla', old('countries', []))) selected @endif>Anguilla
                                        </option>
                                        <option value="Antarctica" @if (in_array('Antarctica', old('countries', []))) selected @endif>
                                            Antarctica</option>
                                        <option value="Antigua and Barbuda"
                                            @if (in_array('Antigua and Barbuda', old('countries', []))) selected @endif>Antigua and Barbuda</option>
                                        <option value="Argentina" @if (in_array('Argentina', old('countries', []))) selected @endif>
                                            Argentina</option>
                                        <option value="Armenia" @if (in_array('Armenia', old('countries', []))) selected @endif>Armenia
                                        </option>
                                        <option value="Aruba" @if (in_array('Aruba', old('countries', []))) selected @endif>Aruba
                                        </option>
                                        <option value="Australia" @if (in_array('Australia', old('countries', []))) selected @endif>
                                            Australia</option>
                                        <option value="Austria" @if (in_array('Austria', old('countries', []))) selected @endif>Austria
                                        </option>
                                        <option value="Azerbaijan" @if (in_array('Azerbaijan', old('countries', []))) selected @endif>
                                            Azerbaijan</option>
                                        <option value="Bahamas" @if (in_array('Bahamas', old('countries', []))) selected @endif>Bahamas
                                        </option>
                                        <option value="Bahrain" @if (in_array('Bahrain', old('countries', []))) selected @endif>Bahrain
                                        </option>
                                        <option value="Bangladesh" @if (in_array('Bangladesh', old('countries', []))) selected @endif>
                                            Bangladesh</option>
                                        <option value="Barbados" @if (in_array('Barbados', old('countries', []))) selected @endif>
                                            Barbados</option>
                                        <option value="Belarus" @if (in_array('Belarus', old('countries', []))) selected @endif>Belarus
                                        </option>
                                        <option value="Belgium" @if (in_array('Belgium', old('countries', []))) selected @endif>Belgium
                                        </option>
                                        <option value="Belize" @if (in_array('Belize', old('countries', []))) selected @endif>Belize
                                        </option>
                                        <option value="Benin" @if (in_array('Benin', old('countries', []))) selected @endif>Benin
                                        </option>
                                        <option value="Bermuda" @if (in_array('Bermuda', old('countries', []))) selected @endif>Bermuda
                                        </option>
                                        <option value="Bhutan" @if (in_array('Bhutan', old('countries', []))) selected @endif>Bhutan
                                        </option>
                                        <option value="Bolivia" @if (in_array('Bolivia', old('countries', []))) selected @endif>Bolivia
                                        </option>
                                        <option value="Bosnia and Herzegovina"
                                            @if (in_array('Bosnia and Herzegovina', old('countries', []))) selected @endif>Bosnia and Herzegovina
                                        </option>
                                        <option value="Botswana" @if (in_array('Botswana', old('countries', []))) selected @endif>
                                            Botswana</option>
                                        <option value="Bouvet Island" @if (in_array('Bouvet Island', old('countries', []))) selected @endif>
                                            Bouvet Island</option>
                                        <option value="Brazil" @if (in_array('Brazil', old('countries', []))) selected @endif>Brazil
                                        </option>
                                        <option value="Brunei Darussalam"
                                            @if (in_array('Brunei Darussalam', old('countries', []))) selected @endif>Brunei Darussalam</option>
                                        <option value="Bulgaria" @if (in_array('Bulgaria', old('countries', []))) selected @endif>
                                            Bulgaria</option>
                                        <option value="Burkina Faso" @if (in_array('Burkina Faso', old('countries', []))) selected @endif>
                                            Burkina Faso</option>
                                        <option value="Burundi" @if (in_array('Burundi', old('countries', []))) selected @endif>Burundi
                                        </option>
                                        <option value="Cambodia" @if (in_array('Cambodia', old('countries', []))) selected @endif>
                                            Cambodia</option>
                                        <option value="Cameroon" @if (in_array('Cameroon', old('countries', []))) selected @endif>
                                            Cameroon</option>
                                        <option value="Canada" @if (in_array('Canada', old('countries', []))) selected @endif>Canada
                                        </option>
                                        <option value="Cape Verde" @if (in_array('Cape Verde', old('countries', []))) selected @endif>Cape
                                            Verde</option>
                                        <option value="Cayman Islands" @if (in_array('Cayman Islands', old('countries', []))) selected @endif>
                                            Cayman Islands</option>
                                        <option value="Central African Republic"
                                            @if (in_array('Central African Republic', old('countries', []))) selected @endif>Central African Republic
                                        </option>
                                        <option value="Chad" @if (in_array('Chad', old('countries', []))) selected @endif>Chad
                                        </option>
                                        <option value="Chile" @if (in_array('Chile', old('countries', []))) selected @endif>Chile
                                        </option>
                                        <option value="China" @if (in_array('China', old('countries', []))) selected @endif>China
                                        </option>
                                        <option value="Colombia" @if (in_array('Colombia', old('countries', []))) selected @endif>
                                            Colombia</option>
                                        <option value="Comoros" @if (in_array('Comoros', old('countries', []))) selected @endif>Comoros
                                        </option>
                                        <option value="Congo" @if (in_array('Congo', old('countries', []))) selected @endif>Congo
                                        </option>
                                        <option value="Cook Islands" @if (in_array('Cook Islands', old('countries', []))) selected @endif>
                                            Cook Islands</option>
                                        <option value="Costa Rica" @if (in_array('Costa Rica', old('countries', []))) selected @endif>
                                            Costa Rica</option>
                                        <option value="Cote D'ivoire" @if (in_array("Cote D'ivoire", old('countries', []))) selected @endif>
                                            Cote D'ivoire</option>
                                        <option value="Croatia" @if (in_array('Croatia', old('countries', []))) selected @endif>Croatia
                                        </option>
                                        <option value="Cuba" @if (in_array('Cuba', old('countries', []))) selected @endif>Cuba
                                        </option>
                                        <option value="Cyprus" @if (in_array('Cyprus', old('countries', []))) selected @endif>Cyprus
                                        </option>
                                        <option value="Czech Republic" @if (in_array('Czech Republic', old('countries', []))) selected @endif>
                                            Czech Republic</option>
                                        <option value="Denmark" @if (in_array('Denmark', old('countries', []))) selected @endif>Denmark
                                        </option>
                                        <option value="Djibouti" @if (in_array('Djibouti', old('countries', []))) selected @endif>
                                            Djibouti</option>
                                        <option value="Dominica" @if (in_array('Dominica', old('countries', []))) selected @endif>
                                            Dominica</option>
                                        <option value="Dominican Republic"
                                            @if (in_array('Dominican Republic', old('countries', []))) selected @endif>Dominican Republic</option>
                                        <option value="Ecuador" @if (in_array('Ecuador', old('countries', []))) selected @endif>Ecuador
                                        </option>
                                        <option value="Egypt" @if (in_array('Egypt', old('countries', []))) selected @endif>Egypt
                                        </option>
                                        <option value="El Salvador" @if (in_array('El Salvador', old('countries', []))) selected @endif>El
                                            Salvador</option>
                                        <option value="Equatorial Guinea"
                                            @if (in_array('Equatorial Guinea', old('countries', []))) selected @endif>Equatorial Guinea</option>
                                        <option value="Eritrea" @if (in_array('Eritrea', old('countries', []))) selected @endif>Eritrea
                                        </option>
                                        <option value="Estonia" @if (in_array('Estonia', old('countries', []))) selected @endif>Estonia
                                        </option>
                                        <option value="Eswatini" @if (in_array('Eswatini', old('countries', []))) selected @endif>
                                            Eswatini</option>
                                        <option value="Ethiopia" @if (in_array('Ethiopia', old('countries', []))) selected @endif>
                                            Ethiopia</option>
                                        <option value="Fiji" @if (in_array('Fiji', old('countries', []))) selected @endif>Fiji
                                        </option>
                                        <option value="Finland" @if (in_array('Finland', old('countries', []))) selected @endif>Finland
                                        </option>
                                        <option value="France" @if (in_array('France', old('countries', []))) selected @endif>France
                                        </option>
                                        <option value="Gabon" @if (in_array('Gabon', old('countries', []))) selected @endif>Gabon
                                        </option>
                                        <option value="Gambia" @if (in_array('Gambia', old('countries', []))) selected @endif>Gambia
                                        </option>
                                        <option value="Georgia" @if (in_array('Georgia', old('countries', []))) selected @endif>Georgia
                                        </option>
                                        <option value="Germany" @if (in_array('Germany', old('countries', []))) selected @endif>Germany
                                        </option>
                                        <option value="Ghana" @if (in_array('Ghana', old('countries', []))) selected @endif>Ghana
                                        </option>
                                        <option value="Greece" @if (in_array('Greece', old('countries', []))) selected @endif>Greece
                                        </option>
                                        <option value="Greenland" @if (in_array('Greenland', old('countries', []))) selected @endif>
                                            Greenland</option>
                                        <option value="Grenada" @if (in_array('Grenada', old('countries', []))) selected @endif>Grenada
                                        </option>
                                        <option value="Guadeloupe" @if (in_array('Guadeloupe', old('countries', []))) selected @endif>
                                            Guadeloupe</option>
                                        <option value="Guam" @if (in_array('Guam', old('countries', []))) selected @endif>Guam
                                        </option>
                                        <option value="Guatemala" @if (in_array('Guatemala', old('countries', []))) selected @endif>
                                            Guatemala</option>
                                        <option value="Guinea" @if (in_array('Guinea', old('countries', []))) selected @endif>Guinea
                                        </option>
                                        <option value="Guinea-bissau" @if (in_array('Guinea-bissau', old('countries', []))) selected @endif>
                                            Guinea-bissau</option>
                                        <option value="Guyana" @if (in_array('Guyana', old('countries', []))) selected @endif>Guyana
                                        </option>
                                        <option value="Haiti" @if (in_array('Haiti', old('countries', []))) selected @endif>Haiti
                                        </option>
                                        <option value="Honduras" @if (in_array('Honduras', old('countries', []))) selected @endif>
                                            Honduras</option>
                                        <option value="Hong Kong" @if (in_array('Hong Kong', old('countries', []))) selected @endif>Hong
                                            Kong</option>
                                        <option value="Hungary" @if (in_array('Hungary', old('countries', []))) selected @endif>Hungary
                                        </option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jersey">Jersey</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea">Korea</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic
                                        </option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macao">Macao</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montenegro">Montenegro</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn">Pitcairn</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russian Federation">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia">Serbia</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Timor-leste">Timor-leste</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Viet Nam">Viet Nam</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>

                                    </select>
                                    @error('countries')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form__group">
                                    <label style="color: #fff" for="">Categories:</label>
                                    <select class="js-example-basic-multiple" name="categories_id[]" id="genre"
                                        multiple="multiple">
                                        @foreach ($allCategories as $item)
                                            <option value="{{ $item->id }}"
                                                @foreach ($categories as $category)
                                                @if ($category->id == $item->id)
                                                selected
                                            @endif @endforeach>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('categories_id')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="form__radio">
                                    <li>
                                        <span>Item type:</span>
                                    </li>
                                    <li>
                                        <input id="type1" type="radio" value="Movie" name="type_film"
                                            @if ($movie->type_film == 'Movie') checked @endif>
                                        <label for="type1">Movie</label>
                                    </li>
                                    <li>
                                        <input id="type2" type="radio" value="TV Show" name="type_film"
                                            @if ($movie->type_film == 'TV Show') checked @endif>
                                        <label for="type2">TV Show</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form__video">
                                    <label id="movie1" for="form__video-upload">Upload video</label>
                                    <input data-name="#movie1" id="form__video-upload" name="video_url_new"
                                        class="form__video-upload" type="file" accept="video/mp4,video/x-m4v,video/*">
                                    @error('video_url')
                                        <div class="main__table-text--red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form__group form__group--link">
                                    <input type="text" class="form__input" placeholder="or add a link">
                                </div>
                            </div>
                            
                            

                                <div class="col-12">
                                    <button type="submit" class="form__btn">publish</button>
                                </div>
                            
                        </div>
                    </div>
                    



                    <div class="col-12">

                    </div>
                </div>
            </form>
        </div>
        <!-- end form -->
    </div>
@endsection
