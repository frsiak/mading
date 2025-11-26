<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, $id)
    {
        // Log untuk debugging
        \Log::info('Like toggle called', [
            'article_id' => $id,
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id()
        ]);
        
        $userId = null;
        
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // Untuk guest, gunakan user default
            $guestUser = \App\Models\User::where('email', 'guest@mading.com')->first();
            if (!$guestUser) {
                $guestUser = \App\Models\User::create([
                    'nama' => 'Guest User',
                    'username' => 'guest_user',
                    'email' => 'guest@mading.com',
                    'password' => bcrypt('guest123'),
                    'role' => 'siswa'
                ]);
            }
            $userId = $guestUser->id_user;
        }

        // Cek apakah artikel ada
        $artikel = Artikel::find($id);
        if (!$artikel) {
            \Log::warning('Article not found', ['article_id' => $id]);
            return response()->json(['error' => 'Artikel tidak ditemukan'], 404);
        }

        \Log::info('Processing like for user', ['user_id' => $userId, 'article_id' => $id]);

        try {
            // Cek apakah user sudah like artikel ini
            $existingLike = Like::where('id_artikel', $id)
                               ->where('id_user', $userId)
                               ->first();

            if ($existingLike) {
                // Jika sudah like, hapus like (unlike)
                $existingLike->delete();
                $liked = false;
                \Log::info('Like removed');
            } else {
                // Jika belum like, tambah like
                Like::create([
                    'id_artikel' => $id,
                    'id_user' => $userId
                ]);
                $liked = true;
                \Log::info('Like added');
            }

            // Hitung total likes
            $totalLikes = Like::where('id_artikel', $id)->count();

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'total_likes' => $totalLikes,
                'message' => $liked ? 'Artikel disukai' : 'Like dibatalkan',
                'user' => Auth::check() ? Auth::user()->nama : 'Guest'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in like toggle', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Terjadi kesalahan sistem',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}