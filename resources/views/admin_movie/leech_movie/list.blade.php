@extends('admin_movie.layouts.default')
@push('styles')
    <style>
        /* Centered Toast container styling */
        .toast-container {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        /* Toast styling */
        .toast {
            display: flex;
            flex-direction: column;
            width: 350px;
            background-color: #151f30;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .toast-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            font-weight: bold;
            background-color: #232225;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .toast-body {
            padding: 10px 12px;
        }

        /* Progress bar styling */
        .progress-bar {
            height: 4px;
            background-color: #2f80ed;
            width: 0%;
            transition: width linear;
        }

        /* Close button styling */
        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
@endpush
@section('main')
    <div class="row">
        <!-- main title -->
        <div class="col-12">
            <div class="main__title"
                style="position: fixed; background-color: #131720; z-index: 1000; padding: 10px 0; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); width: 75%">
                <h2>List </h2>

                <span class="main__title-stat">14 452 total</span>

                <div class="main__title-wrap">

                    <form action="{{ route('admin.leech.list',$leechUrl->slug) }}" method="get">
                        {{-- <input type="text" name="apiUrl" id="" value="{{request()->apiUrl}}"> --}}
                        <select name="page" id=""  style="padding: 0 20px 0 20px; background-color:    #151f30; color:#fff; border: none; margin-right: 10px; height: 40px; border-radius: 16px;">
                            <option value="" > Select page number</option>
                            @for ($i = 1; $i <= $pagination['totalPages']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#2f80ed" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>                                </button>
                    </form>
                     <form action="{{ route('admin.leech.postByPage',$leechUrl->slug) }}" method="post">
                        @csrf

                        <select name="trangdau" id="">
                            @for ($i = 1; $i <= $pagination['totalPages']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <span style="color: #fff"><></span>
                        <select name="trangcuoi" id="">
                            @for ($i = 1; $i <= $pagination['totalPages']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit" style="background-color: #fff">leech</button>
                    </form>
                    <!-- end filter sort -->

                    <!-- search -->
                    <form action="{{ route('admin.leech.slug') }}" method="POST" class="main__title-form">
                        @csrf
                        <input type="text" placeholder="nhập api đến phim" name="slug"
                            value="{{$leechUrl->url_detail.request()->search }}">
                        <button type="submit">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.25998" cy="8.25995" r="7.48191" stroke="#2F80ED" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></circle>
                                <path d="M13.4637 13.8523L16.3971 16.778" stroke="#2F80ED" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </form>
                    <!-- end search -->
                </div>
            </div>
        </div>
        <!-- end main title -->
        @if (session('success'))
            <div class="toast-container" style="color: red"></div>
            <audio id="toast-sound" src="/public/iPhone Notification Sound (HD).mp3"></audio>
        @endif
        <!-- table -->
        <div class="col-12" style="margin-top: 100px;">
            <div class="main__table-wrap">
                <table class="main__table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>RATING</th>
                            <th>CATEGORY</th>
                            <th>VIEWS</th>
                            <th>STATUS</th>
                            <th>CRAETED DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="movieTable">
                        {{-- @foreach ($movies as $movie)
                            <div id="modal-status-{{ $movie->id }}" class="zoom-anim-dialog mfp-hide modal">
                                <h6 class="modal__title">Status change</h6>

                                <p class="modal__text">Are you sure about immediately change status?</p>

                                <div class="modal__btns">
                                    <form action="{{ route('admin.update_status', $movie->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $movie->status }}">
                                        <button class="modal__btn modal__btn--apply" type="submit">Apply</button>
                                    </form>
                                    <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
                                </div>
                            </div>
                            <div id="modal-delete-{{ $movie->id }}" class="zoom-anim-dialog mfp-hide modal">
                                <h6 class="modal__title">movie delete</h6>

                                <p class="modal__text">Are you sure to permanently delete this movie?</p>

                                <div class="modal__btns">
                                    <form action="{{ route('admin.movie.destroy', $movie->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="modal__btn modal__btn--apply" type="submit">Delete</button>
                                    </form>

                                    <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
                                </div>
                            </div>
                            <tr class="main__table-row">
                                <td>
                                    <div class="main__table-text">{{ $movie->id }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">
                                        @if (strlen($movie->title) > 40)
                                            {{ substr($movie->title, 0, 39) }}...
                                        @else
                                            {{ $movie->title }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $movie->rating ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">Category</div> <!-- Replace with real category -->
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $movie->views }}</div>
                                </td>
                                <td>
                                    @if ($movie->status == 'Public')
                                        <div class="main__table-text main__table-text--green">{{ $movie->status }}</div>
                                    @endif
                                    @if ($movie->status == 'Hidden')
                                        <div class="main__table-text main__table-text--red">{{ $movie->status }}</div>
                                    @endif
                                    @if ($movie->status == 'Not Released')
                                        <div class="main__table-text" style="color: rgba(255, 255, 0, 0.77)">
                                            {{ $movie->status }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $movie->created_at->format('Y-m-d') }}</div>
                                </td>
                                <td>
                                    <div class="main__table-btns">
                                        @if ($movie->status == 'Hidden')
                                            <a href="#modal-status-{{ $movie->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#eb5757"
                                                        d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($movie->status == 'Public')
                                            <a href="#modal-status-{{ $movie->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12,13a1.49,1.49,0,0,0-1,2.61V17a1,1,0,0,0,2,0V15.61A1.49,1.49,0,0,0,12,13Zm5-4V7A5,5,0,0,0,7,7V9a3,3,0,0,0-3,3v7a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V12A3,3,0,0,0,17,9ZM9,7a3,3,0,0,1,6,0V9H9Zm9,12a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z" />
                                                </svg>

                                            </a>
                                        @endif
                                        @if ($movie->status == 'Not Released')
                                            <a href="#modal-status-{{ $movie->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#dece21"
                                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                </svg>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.movie.show', $movie->id) }}"
                                            class="main__table-btn main__table-btn--edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M22,7.24a1,1,0,0,0-.29-.71L17.47,2.29A1,1,0,0,0,16.76,2a1,1,0,0,0-.71.29L13.22,5.12h0L2.29,16.05a1,1,0,0,0-.29.71V21a1,1,0,0,0,1,1H7.24A1,1,0,0,0,8,21.71L18.87,10.78h0L21.71,8a1.19,1.19,0,0,0,.22-.33,1,1,0,0,0,0-.24.7.7,0,0,0,0-.14ZM6.83,20H4V17.17l9.93-9.93,2.83,2.83ZM18.17,8.66,15.34,5.83l1.42-1.41,2.82,2.82Z" />
                                            </svg>
                                        </a>

                                        <a href="#modal-delete-{{ $movie->id }}"
                                            class="main__table-btn main__table-btn--delete open-modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" />
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach --}}
                        @foreach ($movies as $movie)
                            <tr class="main__table-row">
                                <td>
                                    <div class="main__table-text">
                                        {{ $movie['name'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class="main__table-text">
                                        {{ $movie['year'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class="main__table-text">
                                        <form action="{{route('admin.leech.info')}}" method="get">
                                            <input type="hidden" name="leechUrl" value="{{$leechUrl->url_detail.$movie['slug']}}">
                                            <button type="submit">Thông tin</button>
                                        </form>
                                        {{-- <a href="{{ route('admin.leech.info',$leechUrl->url_detail.$movie['slug'])  }}">Thông tin</a> --}}
                                    </div>
                                </td>
                                <td>

                                    <img src="{{ $leechUrl->url_poster.$movie['thumb_url'] }}"
                                        height="70px" alt="{{ $movie['name'] }}">

                                </td>
                                <td>
                                    <div class="main__table-text">
                                        <a href="{{ route('admin.leech.bySlug', ['slug'=>$leechUrl->slug,'movie'=>$movie['slug']]) }}">leech all episode</a>
                                    </div>
                                </td>
                            </tr>
                            {{-- <li>
                            <h2> ({{ $movie['year'] }})</h2>
                            <p><strong>IMDB:</strong> {{ $movie['imdb']['id'] }}</p>
                            <p><strong>Vote Average:</strong> {{ $movie['tmdb']['vote_average'] }}</p>
                            <img src="{{ $movie['thumb_url'] }}" alt="{{ $movie['name'] }}">
                        </li> --}}
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- end table -->

        <!-- paginator -->
        <div class="col-12">
            <div class="paginator">
                <span class="paginator__pages">
                    {{-- Showing
                    @if ($movies->lastItem() != $movies->total())
                        {{ $movies->firstItem() }}
                        to
                    @endif
                    {{ $movies->lastItem() }} item
                    of {{ $movies->total() }} results --}}
                </span>

                <ul class="paginator__paginator">
                    <!-- Nút Previous -->
                    {{-- @if (!$movies->onFirstPage())
                        <li>
                            <a href="{{ $movies->previousPageUrl() }}">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                    @endif --}}

                    <!-- Hiển thị các trang lân cận -->
                    {{-- @php
                        $start = max(1, $movies->currentPage() - 2); // Trang bắt đầu hiển thị (2 trang trước)
                        $end = min($movies->lastPage(), $movies->currentPage() + 2); // Trang kết thúc hiển thị (2 trang sau)
                    @endphp

                    <!-- Hiển thị trang đầu tiên và '...' nếu cần -->
                    @if ($start > 1)
                        <li><a href="{{ $movies->url(1) }}">1</a></li>
                        @if ($start > 2)
                            <li><span style="color: #fff">...</span></li>
                        @endif
                    @endif --}}

                    <!-- Vòng lặp hiển thị các trang trong khoảng $start đến $end -->
                    {{-- @for ($page = 1; $page <= $pagination; $page++)
                        <li class="{{ $movies->currentPage() == $page ? 'active' : '' }}">
                            <a href="{{ $movies->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor --}}

                    {{-- <!-- Hiển thị trang cuối cùng và '...' nếu cần -->
                    @if ($end < $movies->lastPage())
                        @if ($end < $movies->lastPage() - 1)
                            <li><span style="color: #fff">...</span></li>
                        @endif
                        <li><a href="{{ $movies->url($movies->lastPage()) }}">{{ $movies->lastPage() }}</a></li>
                    @endif --}}

                    <!-- Nút Next -->
                    {{-- @if ($movies->hasMorePages())
                        <li>
                            <a href="{{ $movies->nextPageUrl() }}">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </div>
        </div>

        <!-- end paginator -->
    </div>

    </div>



    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý click phân trang
            document.addEventListener('click', function(event) {
                if (event.target.closest('.paginator__paginator a')) {
                    event.preventDefault();
                    let pageUrl = event.target.closest('a').href;

                    fetch(pageUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                        })
                        .then(response => response.text())
                        .then(html => {
                            // Tạo DOM tạm để lấy nội dung trả về
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Cập nhật bảng
                            document.querySelector('#movieTable').innerHTML =
                                doc.querySelector('#movieTable').innerHTML;

                            // Cập nhật phân trang
                            document.querySelector('.paginator').innerHTML =
                                doc.querySelector('.paginator').innerHTML;
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script> --}}
@endsection
@push('script')
<script>
    // Function to create and display a toast with a progress bar
    function showToast(message, duration) {
        const toastContainer = document.querySelector('.toast-container');
        const toastSound = document.getElementById('toast-sound');

        // Play notification sound
        if (toastSound) {
            toastSound.currentTime = 0; // Reset sound to start
            toastSound.play(); // Play the sound
        }

        // Create toast elements
        const toast = document.createElement('div');
        toast.classList.add('toast');

        const toastHeader = document.createElement('div');
        toastHeader.classList.add('toast-header');
        toastHeader.innerHTML = `
            <span>Notification</span>
            <button class="close-btn" onclick="closeToast(this)">✖</button>
        `;

        const toastBody = document.createElement('div');
        toastBody.classList.add('toast-body');
        toastBody.innerText = message;

        const progressBar = document.createElement('div');
        progressBar.classList.add('progress-bar');

        // Append elements
        toast.appendChild(toastHeader);
        toast.appendChild(toastBody);
        toast.appendChild(progressBar);
        toastContainer.appendChild(toast);

        // Start progress bar animation
        setTimeout(() => {
            progressBar.style.width = '100%';
            progressBar.style.transitionDuration = duration + 'ms';
        }, 10);

        // Hide toast after duration
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500); // Remove element after fade out
        }, duration);
    }

    // Function to close the toast
    function closeToast(button) {
        const toast = button.closest('.toast');
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }

    // Example usage: Display a toast for 10 seconds
    showToast('{{ Session::get('success') }}', 1000000);
</script>
@endpush
