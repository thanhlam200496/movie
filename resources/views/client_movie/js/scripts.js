document.addEventListener('DOMContentLoaded', () => {
    const video = document.getElementById('player'); // Lấy thẻ video
    const movieId = '{{ $movie->id }}'; // Lấy ID phim từ server (Laravel Blade)
    const token = '{{ csrf_token() }}'; // CSRF token nếu cần
    
    // Hàm để gửi dữ liệu lịch sử xem
    function saveViewHistory() {
        const currentTime = video.currentTime; // Thời gian hiện tại của video

        // Gửi dữ liệu đến server bằng fetch
        fetch('/api/view-history', { // hoặc dùng URL chính xác
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer <your-token>' // Nếu cần token
            },
            body: JSON.stringify({
                user_id: userId,
                movie_id: movieId,
                current_time: currentTime
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error updating view history:', error);
        });
        
    }

    // Gửi dữ liệu định kỳ mỗi 5 giây
    setInterval(() => {
        if (!video.paused) { // Chỉ lưu nếu video đang được phát
            saveViewHistory();
        }
    }, 5000); // Mỗi 5 giây
});
