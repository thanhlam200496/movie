<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // function store(Request $request)  {
    //     $request->validate([
    //         "content"=>"required|max:1000"
    //     ]);
    //     $data=[
    //         "user_id"=>Auth::user()->id,
    //         "episode_id"=>$request->episode_id,
    //         "content"=>$request->content
    //     ];
    //     try {
    //         Comment::create($data);
    //         return redirect()->back();
    //     } catch (\Throwable $th) {

    //     }
    // }
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'episode_id' => 'required|exists:episodes,id',
        'parent_id' => 'nullable|exists:comments,id', // Thêm validate cho parent_id
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'episode_id' => $request->episode_id,
            'parent_id' => $request->parent_id, // Lưu parent_id nếu có
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user'),
        ]);
    }

    public function index(Request $request, $episode_id)
    {
        $perPage = 5;
        // Lấy các bình luận cha và load tất cả replies phân cấp
        $comments = Comment::where('episode_id', $episode_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user']) // Load user và replies
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'comments' => $comments->items(),
            'current_page' => $comments->currentPage(),
            'last_page' => $comments->lastPage(),
            'total' => $comments->total(),
        ]);
    }
}
