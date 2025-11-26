<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Komentar;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();
        $totalArtikel = Artikel::count();
        $totalKategori = Kategori::count();
        $artikelPending = Artikel::where('status', 'draft')->count();
        
        return view('admin.dashboard', compact(
            'totalUser', 'totalArtikel', 'totalKategori', 'artikelPending'
        ));
    }
    
    // Kelola User
    public function users()
    {
        $users = User::orderBy('id_user', 'desc')->get();
        return view('admin.users', compact('users'));
    }
    
    public function createUser(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,guru,siswa'
        ]);
        
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        
        return back()->with('success', 'User berhasil ditambahkan');
    }
    
    public function deleteUser($id)
    {
        User::find($id)->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
    
    // Verifikasi Artikel
    public function verifikasi()
    {
        $artikel = Artikel::with(['user', 'kategori'])
            ->where('verified_by_admin', false)
            ->whereIn('status', ['draft', 'pending'])
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('admin.verifikasi', compact('artikel'));
    }
    
    public function approveArtikel($id)
    {
        $artikel = Artikel::find($id);
        $artikel->verified_by_admin = true;
        
        // Jika artikel dari guru, langsung publish setelah admin approve
        if ($artikel->user->role == 'guru') {
            $artikel->status = 'published';
            $message = 'Artikel guru berhasil dipublish';
        } else {
            // Artikel siswa perlu verifikasi guru juga
            if ($artikel->verified_by_guru) {
                $artikel->status = 'published';
                $message = 'Artikel siswa berhasil dipublish (sudah diverifikasi admin & guru)';
            } else {
                $message = 'Artikel siswa disetujui admin. Menunggu verifikasi guru.';
            }
        }
        
        $artikel->save();
        return back()->with('success', $message);
    }
    
    public function rejectArtikel($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel ditolak');
    }
    
    // Kelola Kategori
    public function kategori()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }
    
    public function storeKategori(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        Kategori::create($request->only('nama_kategori'));
        return back()->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function deleteKategori($id)
    {
        Kategori::where('id_kategori', $id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    
    // Membuat Laporan
    public function laporan()
    {
        $stats = [
            'total_user' => User::count(),
            'total_artikel' => Artikel::count(),
            'artikel_published' => Artikel::where('status', 'published')->count(),
            'artikel_draft' => Artikel::where('status', 'draft')->count(),
            'user_admin' => User::where('role', 'admin')->count(),
            'user_guru' => User::where('role', 'guru')->count(),
            'user_siswa' => User::where('role', 'siswa')->count(),
        ];
        
        return view('admin.laporan', compact('stats'));
    }
    
    public function exportPDF()
    {
        $stats = [
            'total_user' => User::count(),
            'total_artikel' => Artikel::count(),
            'artikel_published' => Artikel::where('status', 'published')->count(),
            'artikel_draft' => Artikel::where('status', 'draft')->count(),
            'artikel_rejected' => Artikel::where('status', 'rejected')->count(),
            'total_likes' => \App\Models\Like::count(),
            'user_admin' => User::where('role', 'admin')->count(),
            'user_guru' => User::where('role', 'guru')->count(),
            'user_siswa' => User::where('role', 'siswa')->count(),
        ];
        
        $artikelPerKategori = Kategori::withCount('artikel')->get();
        $artikelTerbaru = Artikel::with(['user', 'kategori'])->orderBy('tanggal', 'desc')->take(10)->get();
        
        $pdf = \PDF::loadView('admin.laporan-pdf', compact('stats', 'artikelPerKategori', 'artikelTerbaru'));
        return $pdf->download('laporan-mading-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Menghapus komentar.
     *
     * @param  \App\Models\Komentar  $komentar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteComment(Komentar $komentar)
    {
        $user = Auth::user();
        
        // Check authorization: admin, guru, or comment owner can delete
        if ($user->role !== 'admin' && $user->role !== 'guru' && $user->id_user !== $komentar->id_user) {
            abort(403, 'Unauthorized access');
        }
        
        $komentar->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
