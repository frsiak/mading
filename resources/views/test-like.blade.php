@extends('welcome')

@section('title', 'Test Like Feature')

@section('content')
<div class="container mt-5">
    <h2>Test Like Feature</h2>
    
    @if(Auth::check())
        <p>Logged in as: {{ Auth::user()->nama }} ({{ Auth::user()->role }})</p>
        
        <div class="card mt-3">
            <div class="card-body">
                <h5>Test Article</h5>
                <p>This is a test article for like functionality.</p>
                
                @php
                    $testArtikel = App\Models\Artikel::first();
                @endphp
                
                @if($testArtikel)
                <button class="btn btn-outline-danger like-btn" data-artikel-id="{{ $testArtikel->id_artikel }}">
                    <i class="bi bi-heart"></i>
                    <span class="like-count">{{ $testArtikel->likes->count() }}</span> Likes
                </button>
                <p class="mt-2">Testing with article: {{ $testArtikel->judul }}</p>
                @else
                <p>No articles found. Please create an article first.</p>
                @endif
            </div>
        </div>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to test like feature.</p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.querySelector('.like-btn');
    
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const artikelId = this.dataset.artikelId;
            console.log('Clicking like for article:', artikelId);
            
            fetch(`/artikel/${artikelId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                const icon = this.querySelector('i');
                const count = this.querySelector('.like-count');
                
                if (data.liked) {
                    icon.className = 'bi bi-heart-fill';
                    this.classList.add('btn-danger');
                    this.classList.remove('btn-outline-danger');
                } else {
                    icon.className = 'bi bi-heart';
                    this.classList.add('btn-outline-danger');
                    this.classList.remove('btn-danger');
                }
                
                count.textContent = data.total_likes;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memberikan like');
            });
        });
    }
});
</script>
@endsection