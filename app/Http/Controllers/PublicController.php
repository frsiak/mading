<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicController extends Controller
{

    public function home()
    {
        $artikelTerbaru = Artikel::with(['user', 'kategori', 'likes', 'komentar'])
            ->where('status', 'published')
            ->orderBy('tanggal', 'desc')
            ->take(6)
            ->get();
            
        $artikelPopuler = Artikel::with(['user', 'kategori', 'likes', 'komentar'])
            ->where('status', 'published')
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(3)
            ->get();
            
        // Tidak ada auto-like, user harus klik sendiri
            
        return view('public.home', compact('artikelTerbaru', 'artikelPopuler'));
    }
    
    public function detail($id_artikel)
    {
        $artikel = Artikel::with(['user', 'kategori', 'likes', 'komentar.user'])
            ->where('id_artikel', $id_artikel)
            ->where('status', 'published')
            ->firstOrFail();
            
        return view('public.detail', compact('artikel'));
    }
    
    public function artikel(Request $request)
    {
        $query = $request->get('q');
        $kategori = $request->get('kategori');
        $tanggal = $request->get('tanggal');
        $penulis = $request->get('penulis');
        
        $artikel = Artikel::with(['user', 'kategori', 'likes', 'komentar'])
            ->where('status', 'published')
            ->when($query, function($q) use ($query) {
                return $q->where(function($subQ) use ($query) {
                    $subQ->where('judul', 'like', '%' . $query . '%')
                         ->orWhere('isi', 'like', '%' . $query . '%');
                });
            })
            ->when($kategori, function($q) use ($kategori) {
                return $q->where('id_kategori', $kategori);
            })
            ->when($tanggal, function($q) use ($tanggal) {
                return $q->whereDate('tanggal', $tanggal);
            })
            ->when($penulis, function($q) use ($penulis) {
                return $q->whereHas('user', function($userQ) use ($penulis) {
                    $userQ->where('nama', 'like', '%' . $penulis . '%');
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
            
        $kategoris = Kategori::all();
        $users = User::whereIn('role', ['guru', 'siswa'])->get();
        
        return view('public.artikel', compact('artikel', 'kategoris', 'users', 'query', 'kategori', 'tanggal', 'penulis'));
    }
    
    public function download($id_artikel)
    {
        try {
            $artikel = Artikel::with(['user', 'kategori'])
                ->where('id_artikel', $id_artikel)
                ->where('status', 'published')
                ->firstOrFail();
                
            $pdf = Pdf::loadView('pdf.artikel', compact('artikel'))
                ->setPaper('a4', 'portrait')
                ->setOptions(['isRemoteEnabled' => true]);
                
            $filename = 'artikel-' . $artikel->id_artikel . '.pdf';
            
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->output();
            }, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunduh artikel: ' . $e->getMessage());
        }
    }

}
