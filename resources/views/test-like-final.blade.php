<!DOCTYPE html>
<html>
<head>
    <title>Test Like Final</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Test Like Feature - Final Debug</h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Authentication Status</h5>
                        @if(Auth::check())
                            <div class="alert alert-success">
                                ✅ Logged in as: {{ Auth::user()->nama }} ({{ Auth::user()->role }})
                            </div>
                        @else
                            <div class="alert alert-warning">
                                ❌ Not logged in. <a href="{{ route('login') }}">Login here</a>
                            </div>
                        @endif
                        
                        <h5>CSRF Token</h5>
                        <div class="alert alert-info">
                            Token: {{ csrf_token() }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Test Article</h5>
                        @php
                            $artikel = App\Models\Artikel::first();
                        @endphp
                        
                        @if($artikel)
                            <p><strong>{{ $artikel->judul }}</strong></p>
                            <p>Current likes: <span id="currentLikes">{{ $artikel->likes->count() }}</span></p>
                            
                            @if(Auth::check())
                                <button id="likeBtn" class="btn btn-outline-danger" data-artikel-id="{{ $artikel->id_artikel }}">
                                    <i class="bi bi-heart{{ Auth::user()->hasLiked($artikel->id_artikel) ? '-fill' : '' }}"></i>
                                    <span id="likeCount">{{ $artikel->likes->count() }}</span> Likes
                                </button>
                            @else
                                <button class="btn btn-outline-danger" onclick="alert('Please login first')">
                                    <i class="bi bi-heart"></i>
                                    {{ $artikel->likes->count() }} Likes
                                </button>
                            @endif
                        @else
                            <div class="alert alert-warning">No articles found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Debug Log</h5>
                        <div id="debugLog" class="bg-light p-3" style="height: 300px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            Ready to test...<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function addLog(message) {
        const log = document.getElementById('debugLog');
        const time = new Date().toLocaleTimeString();
        log.innerHTML += `[${time}] ${message}<br>`;
        log.scrollTop = log.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', function() {
        addLog('Page loaded');
        
        const likeBtn = document.getElementById('likeBtn');
        if (!likeBtn) {
            addLog('Like button not found (user not logged in)');
            return;
        }
        
        addLog('Like button found, adding event listener');
        
        likeBtn.addEventListener('click', function() {
            const artikelId = this.dataset.artikelId;
            addLog(`Like button clicked for article ID: ${artikelId}`);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                addLog('ERROR: CSRF token not found');
                return;
            }
            
            const token = csrfToken.getAttribute('content');
            addLog(`CSRF token: ${token.substring(0, 10)}...`);
            
            addLog('Sending fetch request...');
            
            fetch(`/artikel/${artikelId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                addLog(`Response received - Status: ${response.status}`);
                addLog(`Response OK: ${response.ok}`);
                addLog(`Response type: ${response.type}`);
                
                if (response.status === 302) {
                    addLog('Got redirect response (302)');
                    return response.text().then(text => {
                        addLog(`Redirect body: ${text.substring(0, 100)}...`);
                        throw new Error('Redirected - probably to login');
                    });
                }
                
                if (response.status === 419) {
                    addLog('CSRF token mismatch (419)');
                    throw new Error('CSRF token expired');
                }
                
                if (!response.ok) {
                    return response.text().then(text => {
                        addLog(`Error response body: ${text}`);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                
                return response.json();
            })
            .then(data => {
                addLog(`Success response: ${JSON.stringify(data)}`);
                
                if (data && data.total_likes !== undefined) {
                    const icon = this.querySelector('i');
                    const count = document.getElementById('likeCount');
                    const currentLikes = document.getElementById('currentLikes');
                    
                    if (data.liked) {
                        icon.className = 'bi bi-heart-fill';
                        this.classList.remove('btn-outline-danger');
                        this.classList.add('btn-danger');
                        addLog('Like added - UI updated');
                    } else {
                        icon.className = 'bi bi-heart';
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-danger');
                        addLog('Like removed - UI updated');
                    }
                    
                    count.textContent = data.total_likes;
                    currentLikes.textContent = data.total_likes;
                    addLog(`Like count updated to: ${data.total_likes}`);
                }
            })
            .catch(error => {
                addLog(`ERROR: ${error.message}`);
                console.error('Error:', error);
            });
        });
    });
    </script>
</body>
</html>