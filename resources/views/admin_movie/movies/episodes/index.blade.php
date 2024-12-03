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
            <div class="main__title">
                <h2>Catalog</h2>

                <span class="main__title-stat"><a href="{{route('admin.episode.create',$movie_id)}}">Add episode</a></span>

                <div class="main__title-wrap">
                    <!-- filter sort -->
                    <div class="filter" id="filter__sort">
                        <span class="filter__item-label">Sort by:</span>

                        <div class="filter__item-btn dropdown-toggle" role="navigation" id="filter-sort"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <input type="button" value="Date created">
                            <span></span>
                        </div>

                        <ul class="filter__item-menu dropdown-menu scrollbar-dropdown" aria-labelledby="filter-sort">
                            <li><a href="{{ route('admin.movie.index', 'filter=date-created') }}">Date created</a></li>
                            <li><a href="{{ route('admin.movie.index', 'filter=rating') }}">Rating</a></li>
                            <li><a href="{{ route('admin.movie.index', 'filter=views') }}">Views</a></li>
                        </ul>
                    </div>
                    <!-- end filter sort -->

                    <!-- search -->
                    <form action="{{ route('admin.movie.index') }}" method="GET" class="main__title-form">
                        <input type="text" placeholder="Find movie / description..." name="search"
                            value="{{ request()->search }}">
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
        @endif
        <!-- table -->
        <div class="col-12">
            <div class="main__table-wrap">
                <table class="main__table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>Episode number</th>

                            <th>CRAETED DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="movieTable">
                        @foreach ($episodes as $movie)
                            
                            <div id="modal-delete-{{ $movie->id }}" class="zoom-anim-dialog mfp-hide modal">
                                <h6 class="modal__title">movie delete</h6>

                                <p class="modal__text">Are you sure to permanently delete this movie?</p>

                                <div class="modal__btns">
                                    <form action="{{ route('admin.episode.destroy', $movie->id) }}" method="POST">
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
                                    <div class="main__table-text">{{ $movie->episode_number }}</div>
                                </td>


                                <td>
                                    <div class="main__table-text">{{ $movie->created_at->format('Y-m-d') }}</div>
                                </td>
                                <td>
                                    <div class="main__table-btns">


                                        <a href="{{ route('admin.episode.show', ['movie_id'=>$movie_id,'episode_id'=>$movie->id]) }}"
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
                    Showing
                    @if ($episodes->lastItem() != $episodes->total())
                        {{ $episodes->firstItem() }}
                        to
                    @endif
                    {{ $episodes->lastItem() }} item
                    of {{ $episodes->total() }} results
                </span>

                <ul class="paginator__paginator">
                    <!-- Nút Previous -->
                    @if (!$episodes->onFirstPage())
                        <li>
                            <a href="{{ $episodes->previousPageUrl() }}">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                    @endif

                    <!-- Hiển thị các trang lân cận -->
                    @php
                        $start = max(1, $episodes->currentPage() - 2); // Trang bắt đầu hiển thị (2 trang trước)
                        $end = min($episodes->lastPage(), $episodes->currentPage() + 2); // Trang kết thúc hiển thị (2 trang sau)
                    @endphp

                    <!-- Hiển thị trang đầu tiên và '...' nếu cần -->
                    @if ($start > 1)
                        <li><a href="{{ $episodes->url(1) }}">1</a></li>
                        @if ($start > 2)
                            <li><span style="color: #fff">...</span></li>
                        @endif
                    @endif

                    <!-- Vòng lặp hiển thị các trang trong khoảng $start đến $end -->
                    @for ($page = $start; $page <= $end; $page++)
                        <li class="{{ $episodes->currentPage() == $page ? 'active' : '' }}">
                            <a href="{{ $episodes->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor

                    <!-- Hiển thị trang cuối cùng và '...' nếu cần -->
                    @if ($end < $episodes->lastPage())
                        @if ($end < $episodes->lastPage() - 1)
                            <li><span style="color: #fff">...</span></li>
                        @endif
                        <li><a href="{{ $episodes->url($episodes->lastPage()) }}">{{ $episodes->lastPage() }}</a></li>
                    @endif

                    <!-- Nút Next -->
                    @if ($episodes->hasMorePages())
                        <li>
                            <a href="{{ $episodes->nextPageUrl() }}">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        </li>
                    @endif
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

        // Example usage: Display a toast for 3 seconds
        showToast('{{ Session::get('success') }}', 10000);
    </script>
@endpush
