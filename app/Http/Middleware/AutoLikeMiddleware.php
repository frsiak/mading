<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth;

class AutoLikeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Hanya jalankan untuk halaman detail artikel
        if ($request->route() && $request->route()->getName() === 'artikel.detail') {
            $articleId = $request->route('id');
            
            // Pastikan artikel ada
            $artikel = Artikel::find($articleId);
            if ($artikel && Auth::check()) {
                $userId = Auth::id();
                
                // Cek apakah user sudah like artikel ini
                $existingLike = Like::where('id_artikel', $articleId)
                                  ->where('id_user', $userId)
                                  ->first();
                
                // Jika belum like, berikan like otomatis
                if (!$existingLike) {
                    Like::create([
                        'id_artikel' => $articleId,
                        'id_user' => $userId
                    ]);
                }
            }
        }
        
        return $response;
    }
}