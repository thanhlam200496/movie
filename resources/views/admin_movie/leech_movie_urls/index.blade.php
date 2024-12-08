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

                <span class="main__title-stat">14 452 total</span>

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
                            <li>Date created</li>
                            <li>Rating</li>
                            <li>Views</li>
                        </ul>
                    </div>
                    <!-- end filter sort -->

                    <!-- search -->
                    <form action="{{ route('admin.movie.index') }}" method="GET" class="main__title-form">
                        <input type="text" placeholder="Find category / description..." name="search"
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
        <!-- users -->
        <div class="col-12">
            <div class="main__table-wrap">
                <table class="main__table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Link</th>
                            <th>Link image</th>
                            <th>Link video</th>
                            
                            <th>ACTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($leechUrls as $leechUrl)
                        <div id="modal-delete-{{$leechUrl->id}}" class="zoom-anim-dialog mfp-hide modal">
                            <h6 class="modal__title">Item delete</h6>
                    
                            <p class="modal__text">Are you sure to permanently delete this item?</p>
                    
                            <div class="modal__btns">
                                <form action="{{ route('admin.category.destroy', $leechUrl->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="modal__btn modal__btn--apply" type="submit">Delete</button>
                                </form>
                                
                                <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
                            </div>
                        </div>
                            <tr>
                                <td>
                                    <div class="main__table-text">{{ $leechUrl->id }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $leechUrl->name }}</div>
                                </td>

                                <td>
                                    <div class="main__table-text">{{ $leechUrl->url_list_movie }}</div>
                                </td>

                                <td>
                                    <div class="main__table-text">{{ $leechUrl->url_video_m3u8 }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $leechUrl->url_poster }}</div>
                                </td>
                                <td>
                                    <div class="main__table-btns">
                                        
                                        <a href="{{ route('admin.leech.list', $leechUrl->slug) }}"
                                            class="main__table-btn main__table-btn--edit">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="#eb5757"
                                                d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                                        </svg>
                                        </a>
                                        <a href="{{ route('admin.category.show', $leechUrl->id) }}"
                                            class="main__table-btn main__table-btn--edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M22,7.24a1,1,0,0,0-.29-.71L17.47,2.29A1,1,0,0,0,16.76,2a1,1,0,0,0-.71.29L13.22,5.12h0L2.29,16.05a1,1,0,0,0-.29.71V21a1,1,0,0,0,1,1H7.24A1,1,0,0,0,8,21.71L18.87,10.78h0L21.71,8a1.19,1.19,0,0,0,.22-.33,1,1,0,0,0,0-.24.7.7,0,0,0,0-.14ZM6.83,20H4V17.17l9.93-9.93,2.83,2.83ZM18.17,8.66,15.34,5.83l1.42-1.41,2.82,2.82Z" />
                                            </svg>
                                        </a>
                                        <a href="#modal-delete-{{$leechUrl->id}}" class="main__table-btn main__table-btn--delete open-modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" />
                                            </svg>
                                        </a>
                                        {{-- <form action="{{ route('admin.category.destroy', $leechUrl->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><a href="#modal-delete"
                                                    class="main__table-btn main__table-btn--delete"
                                                    onclick="return confirm('Bạn có muốn xóa?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path
                                                            d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18ZM20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Zm-3-1a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z" />
                                                    </svg>
                                                </a> </button>
                                        </form> --}}

                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <!-- end users -->

        <!-- paginator -->
        <div class="col-12">
            <div class="paginator">

                <span class="paginator__pages">
                    Showing
                    @if ($leechUrls->lastItem() != $leechUrls->total())
                        {{ $leechUrls->firstItem() }}
                        to
                    @endif
                    {{ $leechUrls->lastItem() }} item
                    of {{ $leechUrls->total() }} results
                </span>

                <ul class="paginator__paginator">
                    <li>
                        @if (!$leechUrls->onFirstPage())
                            <a href="{{ $leechUrls->previousPageUrl() }}">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.75 5.36475L13.1992 5.36475" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M5.771 10.1271L0.749878 5.36496L5.771 0.602051" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        @endif

                    </li>
                    @for ($page = 1; $page <= $leechUrls->lastPage(); $page++)
                        <li class="{{ $leechUrls->currentPage() == $page ? 'active' : '' }}">
                            <a href="{{ $leechUrls->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor


                    <li>
                        @if ($leechUrls->hasMorePages())
                            <a href="{{ $leechUrls->nextPageUrl() }}">


                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1992 5.3645L0.75 5.3645" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M8.17822 0.602051L13.1993 5.36417L8.17822 10.1271" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>
                        @endif

                    </li>
                </ul>
            </div>
        </div>
        <!-- end paginator -->
    </div>
    
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
