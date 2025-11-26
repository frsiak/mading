<!DOCTYPE html>
<html>
<head>
    <title>Test Like Simple</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Test Like Feature - Simple</h2>
        
        @if(Auth::check())
            <div class="alert alert-info">
                Logged in as: {{ Auth::user()->nama }} ({{ Auth::user()->role }})
            </div>
            
            @php
                $artikel = App\Models\Artikel::first();
            @endphp
            
            @if($artikel)
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $artikel->judul }}</h5>
                        <p>{{ Str::limit($artikel->isi, 100) }}</p>
                        
                        <button id="likeBtn" class="btn btn-outline-danger" data-artikel-id="{{ $artikel->id_artikel }}">
                            <i class="bi bi-heart"></i>
                            <span id="likeCount">{{ $artikel->likes->count() }}</span> Likes
                        </button>
                        
                        <div id="debug" class="mt-3 p-3 bg-light">
                            <strong>Debug Info:</strong>
                            <div id="debugContent">Ready to test...</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">No articles found</div>
            @endif
        @else
            <div class="alert alert-warning">
                Please <a href="{{ route('login') }}">login</a> first
            </div>
        @endif
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeBtn = document.getElementById('likeBtn');
        const debugDiv = document.getElementById('debugContent');
        
        function addDebug(message) {
            debugDiv.innerHTML += '<br>' + new Date().toLocaleTimeString() + ': ' + message;
        }
        
        if (likeBtn) {
            likeBtn.addEventListener('click', function() {
                const artikelId = this.dataset.artikelId;
                addDebug('Button clicked for article ID: ' + artikelId);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                addDebug('CSRF Token: ' + csrfToken.substring(0, 10) + '...');
                
                fetch('/artikel/' + artikelId + '/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    addDebug('Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    addDebug('Response data: ' + JSON.stringify(data));
                    
                    if (data.liked !== undefined) {
                        const icon = this.querySelector('i');
                        const count = document.getElementById('likeCount');
                        
                        if (data.liked) {
                            icon.className = 'bi bi-heart-fill';
                            this.classList.remove('btn-outline-danger');
                            this.classList.add('btn-danger');
                        } else {
                            icon.className = 'bi bi-heart';
                            this.classList.remove('btn-danger');
                            this.classList.add('btn-outline-danger');
                        }
                        
                        count.textContent = data.total_likes;
                        addDebug('Like updated successfully');
                    }
                })
                .catch(error => {
                    addDebug('Error: ' + error.message);
                    console.error('Error:', error);
                });
            });
        }
    });
    </script>
</body>
</html>