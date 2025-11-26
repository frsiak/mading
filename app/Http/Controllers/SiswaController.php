<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $artikelSaya = Artikel::where('id_user', Auth::id())->count();
        $artikelTerbaru = Artikel::with(['user', 'kategori'])
            ->where('status', 'published')
            ->orderBy('id_artikel', 'desc')
            ->limit(6)
            ->get();
        
        // Debug - hapus setelah masalah teratasi
        \Log::info('Dashboard Debug', [
            'user_id' => Auth::id(),
            'artikel_saya' => $artikelSaya,
            'artikel_terbaru_count' => $artikelTerbaru->count(),
            'artikel_ids' => $artikelTerbaru->pluck('id_artikel')->toArray()
        ]);
        
        return view('siswa.dashboard', compact('artikelSaya', 'artikelTerbaru'));
    }
    
    public function tulis()
    {
        $kategoris = Kategori::all();
        return view('siswa.tulis', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:500',
            'isi' => 'required',
            'id_kategori' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);
        
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('artikel', 'public');
        }
        
        Artikel::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal' => now(),
            'id_user' => Auth::id(),
            'id_kategori' => $request->id_kategori,
            'foto' => $foto,
            'status' => 'draft',
            'verified_by_admin' => false,
            'verified_by_guru' => false
        ]);
        
        return redirect()->route('siswa.kelola')->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan admin');
    }
    
    public function kelola()
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('id_user', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('siswa.kelola', compact('artikel'));
    }
    
    public function edit($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        $kategoris = Kategori::all();
        return view('siswa.edit', compact('artikel', 'kategoris'));
    }
    
    public function update(Request $request, $id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        
        $request->validate([
            'judul' => 'required|max:500',
            'isi' => 'required',
            'id_kategori' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);
        
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'id_kategori' => $request->id_kategori,
            'status' => 'draft',
            'verified_by_admin' => false,
            'verified_by_guru' => false
        ];
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        $artikel->update($data);
        
        return redirect()->route('siswa.kelola')->with('success', 'Artikel berhasil diupdate dan akan direview ulang');
    }
    
    public function baca()
    {
        $artikel = Artikel::with(['user', 'kategori', 'komentar.user'])
            ->where('status', 'published')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('siswa.baca', compact('artikel'));
    }
    
    public function detail($id)
    {
        $artikel = Artikel::with(['user', 'kategori', 'komentar.user', 'likes'])
            ->where('id_artikel', $id)
            ->where('status', 'published')
            ->firstOrFail();
        return view('siswa.detail', compact('artikel'));
    }
    
    public function preview($id)
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('id_artikel', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();
        return view('siswa.detail', compact('artikel'));
    }
    
    public function comment(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|min:3|max:500'
        ]);
        
        Komentar::create([
            'id_artikel' => $id,
            'id_user' => Auth::user()->id_user,
            'komentar' => $request->komentar,
            'tanggal' => now()
        ]);
        
        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
    
    public function delete($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        
        // Hapus likes dan komentar terkait
        Like::where('id_artikel', $id)->delete();
        Komentar::where('id_artikel', $id)->delete();
        
        // Hapus foto jika ada
        if ($artikel->foto && Storage::disk('public')->exists($artikel->foto)) {
            Storage::disk('public')->delete($artikel->foto);
        }
        
        $artikel->delete();
        return back()->with('success', 'Artikel berhasil dihapus');
    }
    
    public function download($id)
    {
        try {
            $artikel = Artikel::with(['user', 'kategori'])
                ->where('id_artikel', $id)
                ->where('id_user', Auth::id())
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