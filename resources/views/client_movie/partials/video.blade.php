@if ($episode->link_video_internet != null)
                                    <video id="player" data-watched-duration="{{ $watchedDuration }}">

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
                                    <video height="465px" data-watched-duration="{{ $watchedDuration }}" id="player">

                                        <source src="{{ Storage::url('public/videos/' . $episode->video_url) }}" type="video/mp4">


                                    </video>
                                @endif

                                <script>
                                    const player = new Plyr('#player');

                                    player.on('ready', () => {
                                        const controls = document.querySelector('.plyr__controls');

                                        // Tạo nút lùi 10s
                                        const backBtn = document.createElement('button');
                                        backBtn.className = 'plyr__custom-button';
                                        backBtn.innerText = '⏪';
                                        backBtn.title = 'Lùi 10 giây';
                                        backBtn.addEventListener('click', () => {
                                            player.currentTime = Math.max(player.currentTime - 10, 0);
                                        });

                                        // Tạo nút tua 10s
                                        const forwardBtn = document.createElement('button');
                                        forwardBtn.className = 'plyr__custom-button';
                                        forwardBtn.innerText = '⏩';
                                        forwardBtn.title = 'Tua 10 giây';
                                        forwardBtn.addEventListener('click', () => {
                                            player.currentTime = Math.min(player.currentTime + 10, player.duration);
                                        });

                                        // Thêm nút vào thanh điều khiển (chèn sau nút play)
                                        const playButton = controls.querySelector('.plyr__control--overlaid') || controls.querySelector(
                                            '.plyr__control[aria-label="Play"]');
                                        if (playButton && playButton.parentNode) {
                                            controls.insertBefore(backBtn, playButton); // Chèn lùi 10s trước nút play
                                            controls.insertBefore(forwardBtn, playButton.nextSibling); // Chèn tua 10s sau nút play
                                        } else {
                                            // Nếu không tìm được nút play, thêm cuối cùng
                                            controls.appendChild(backBtn);
                                            controls.appendChild(forwardBtn);
                                        }
                                    });
                                </script>
                                <div class="vjs-loading-spinner"></div>
