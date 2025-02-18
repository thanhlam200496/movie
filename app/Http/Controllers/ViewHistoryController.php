<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\ViewHistory;
use Illuminate\Support\Facades\DB;

class ViewHistoryController extends Controller
{
    

    public function store(Request $request)
    {
        // Lấy dữ liệu từ request
        $data = $request->all();

        // Tạo hoặc cập nhật lịch sử xem
        $viewHistory = ViewHistory::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'episode_id' => $data['episode_id'],
            ],
            [
                'watched_duration' => $data['watched_duration'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lịch sử xem đã được lưu thành công.',
            'data' => $viewHistory,
        ]);
    }
}
