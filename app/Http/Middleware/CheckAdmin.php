<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Giả sử user có cột 'role' trong bảng users
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, có thể redirect hoặc trả lỗi 403
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
