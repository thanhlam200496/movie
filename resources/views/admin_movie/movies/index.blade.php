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
                            <li><a href="{{route('admin.movie.index','filter=date-created')}}">Date created</a></li>
                            <li><a href="{{route('admin.movie.index','filter=rating')}}">Rating</a></li>
                            <li><a href="{{route('admin.movie.index','filter=views')}}">Views</a></li>
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
        <!-- users -->
        <div class="col-12">
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

                    <tbody>
                        @foreach ($movies as $item)
                            <div id="modal-status-{{ $item->id }}" class="zoom-anim-dialog mfp-hide modal">
                                <h6 class="modal__title">Status change</h6>

                                <p class="modal__text">Are you sure about immediately change status?</p>

                                <div class="modal__btns">
                                    <form action="{{ route('admin.update_status', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $item->status }}">
                                        <button class="modal__btn modal__btn--apply" type="submit">Apply</button>
                                    </form>
                                    <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
                                </div>
                            </div>
                            <div id="modal-delete-{{ $item->id }}" class="zoom-anim-dialog mfp-hide modal">
                                <h6 class="modal__title">Item delete</h6>

                                <p class="modal__text">Are you sure to permanently delete this item?</p>

                                <div class="modal__btns">
                                    <form action="{{ route('admin.movie.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="modal__btn modal__btn--apply" type="submit">Delete</button>
                                    </form>

                                    <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
                                </div>
                            </div>
                            <tr>
                                <td>
                                    <div class="main__table-text">{{ $item->id }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $item->title }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $item->rating == null ? 'null' : $item->rating }}</div>
                                </td>
                                <td>
                                    <div class="main__table-text">cate:null</div>
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $item->views }}</div>
                                </td>
                                <td>
                                    @if ($item->status == 'Public')
                                        <div class="main__table-text main__table-text--green">{{ $item->status }}</div>
                                    @endif
                                    @if ($item->status == 'Hidden')
                                        <div class="main__table-text main__table-text--red">{{ $item->status }}</div>
                                    @endif
                                    @if ($item->status == 'Not Released')
                                        <div class="main__table-text" style="color: rgba(255, 255, 0, 0.77)">
                                            {{ $item->status }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="main__table-text">{{ $item->created_at }}</div>
                                </td>
                                <td>
                                    <div class="main__table-btns">
                                        @if ($item->status == 'Hidden')
                                            <a href="#modal-status-{{ $item->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#eb5757"
                                                        d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if ($item->status == 'Public')
                                            <a href="#modal-status-{{ $item->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12,13a1.49,1.49,0,0,0-1,2.61V17a1,1,0,0,0,2,0V15.61A1.49,1.49,0,0,0,12,13Zm5-4V7A5,5,0,0,0,7,7V9a3,3,0,0,0-3,3v7a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V12A3,3,0,0,0,17,9ZM9,7a3,3,0,0,1,6,0V9H9Zm9,12a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z" />
                                                </svg>

                                            </a>
                                        @endif
                                        @if ($item->status == 'Not Released')
                                            <a href="#modal-status-{{ $item->id }}"
                                                class="main__table-btn main__table-btn--banned open-modal">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#dece21"
                                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                </svg>
                                            </a>
                                        @endif
                                        {{-- <a href="#" class="main__table-btn main__table-btn--view">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z"/></svg>
                                        </a> --}}
                                        <a href="{{ route('admin.movie.show', $item->id) }}"
                                            class="main__table-btn main__table-btn--edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M22,7.24a1,1,0,0,0-.29-.71L17.47,2.29A1,1,0,0,0,16.76,2a1,1,0,0,0-.71.29L13.22,5.12h0L2.29,16.05a1,1,0,0,0-.29.71V21a1,1,0,0,0,1,1H7.24A1,1,0,0,0,8,21.71L18.87,10.78h0L21.71,8a1.19,1.19,0,0,0,.22-.33,1,1,0,0,0,0-.24.7.7,0,0,0,0-.14ZM6.83,20H4V17.17l9.93-9.93,2.83,2.83ZM18.17,8.66,15.34,5.83l1.42-1.41,2.82,2.82Z" />
                                            </svg>
                                        </a>

                                        <a href="#modal-delete-{{ $item->id }}"
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
        <!-- end users -->

        <!-- paginator -->
        <div class="col-12">
            <div class="paginator">

                <span class="paginator__pages">
                    Showing
                    @if ($movies->lastItem() != $movies->total())
                        {{ $movies->firstItem() }}
                        to
                    @endif
                    {{ $movies->lastItem() }} item
                    of {{ $movies->total() }} results
                </span>

                <ul class="paginator__paginator">
                    <li>
                        @if (!$movies->onFirstPage())
                            <a href="{{ $movies->previousPageUrl() }}">
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
                    @for ($page = 1; $page <= $movies->lastPage(); $page++)
                        <li class="{{ $movies->currentPage() == $page ? 'active' : '' }}">
                            <a href="{{ $movies->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor


                    <li>
                        @if ($movies->hasMorePages())
                            <a href="{{ $movies->nextPageUrl() }}">


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
    <div id="modal-delete" class="zoom-anim-dialog mfp-hide modal">
        <h6 class="modal__title">Item delete</h6>

        <p class="modal__text">Are you sure to permanently delete this item?</p>

        <div class="modal__btns">
            <button class="modal__btn modal__btn--apply" type="button">Delete</button>
            <button class="modal__btn modal__btn--dismiss" type="button">Dismiss</button>
        </div>
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
