<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruController extends Controller
{
    public function dashboard()
    {
        $artikelPending = Artikel::where('status', 'draft')->where('verified_by_guru', false)->count();
        $artikelSaya = Artikel::where('id_user', Auth::id())->count();
        $artikelTerbaru = Artikel::with(['user', 'kategori'])
            ->where('status', 'published')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
        
        return view('guru.dashboard', compact('artikelPending', 'artikelSaya', 'artikelTerbaru'));
    }
    
    public function tulis()
    {
        $kategoris = Kategori::all();
        return view('guru.tulis', compact('kategoris'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:500',
            'isi' => 'required',
            'id_kategori' => 'required',
            'foto' => 'nullable|image|max:5120'
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
        
        return redirect()->route('guru.dashboard')->with('success', 'Artikel berhasil dibuat dan menunggu verifikasi admin');
    }
    

    
    public function verifikasi()
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('verified_by_guru', false)
            ->whereIn('status', ['draft', 'pending'])
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('guru.verifikasi', compact('artikel'));
    }
    
    public function approve($id)
    {
        $artikel = Artikel::find($id);
        $artikel->verified_by_guru = true;
        
        // Jika sudah diverifikasi admin juga, baru published
        if ($artikel->verified_by_admin) {
            $artikel->status = 'published';
            $message = 'Artikel berhasil dipublish (sudah diverifikasi admin & guru)';
        } else {
            $message = 'Artikel disetujui guru. Menunggu verifikasi admin.';
        }
        
        $artikel->save();
        return back()->with('success', $message);
    }
    
    public function reject($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel ditolak');
    }
    
    public function edit($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        $kategoris = Kategori::all();
        return view('guru.edit', compact('artikel', 'kategoris'));
    }
    
    public function update(Request $request, $id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        
        $request->validate([
            'judul' => 'required|max:500',
            'isi' => 'required',
            'id_kategori' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);
        
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'id_kategori' => $request->id_kategori
        ];
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }
        
        $artikel->update($data);
        
        return redirect()->route('guru.dashboard')->with('success', 'Artikel berhasil diupdate');
    }
    
    public function kelola()
    {
        $artikel = Artikel::with(['kategori'])
            ->where('id_user', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('guru.kelola', compact('artikel'));
    }
    
    public function profil()
    {
        return view('guru.profil');
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
    
    public function detail($id)
    {
        $artikel = Artikel::with(['user', 'kategori', 'likes', 'komentar.user'])
            ->where('id_artikel', $id)
            ->firstOrFail();
            
        return view('guru.detail', compact('artikel'));
    }
}
