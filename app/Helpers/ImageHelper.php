<?php

namespace App\Helpers;

class ImageHelper
{
    public static function getDefaultImage($kategori = null, $index = 0)
    {
        $images = [
            'Berita Sekolah' => 'assets/img/blog/blog-post-square-1.webp',
            'Prestasi' => 'assets/img/blog/blog-post-square-2.webp', 
            'Kegiatan' => 'assets/img/blog/blog-post-square-3.webp',
            'Pengumuman' => 'assets/img/blog/blog-post-square-4.webp',
            'Artikel' => 'assets/img/blog/blog-post-square-5.webp'
        ];
        
        if ($kategori && isset($images[$kategori])) {
            return asset($images[$kategori]);
        }
        
        $defaultImages = [
            'assets/img/blog/blog-post-square-1.webp',
            'assets/img/blog/blog-post-square-2.webp', 
            'assets/img/blog/blog-post-square-3.webp',
            'assets/img/blog/blog-post-square-4.webp',
            'assets/img/blog/blog-post-square-5.webp',
            'assets/img/blog/blog-post-square-6.webp'
        ];
        
        return asset($defaultImages[$index % count($defaultImages)]);
    }
}