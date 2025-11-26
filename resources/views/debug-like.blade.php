<!DOCTYPE html>
<html>
<head>
    <title>Debug Like</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Debug Like Feature</h2>
        
        @if(Auth::check())
            <div class="alert alert-success">
                ✅ Logged in as: {{ Auth::user()->nama }} ({{ Auth::user()->role }})
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5>Test Like Buttons</h5>
                    
                    <button id="debugBtn" class="btn btn-info me-2" data-artikel-id="1">
                        Test Debug Endpoint
                    </button>
                    
                    <button id="realLikeBtn" class="btn btn-danger" data-artikel-id="1">
                        Test Real Like Endpoint
                    </button>
                    
                    <div id="result" class="mt-3 p-3 bg-light">
                        <strong>Results will appear here...</strong>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                ❌ Not logged in. <a href="{{ route('login') }}">Login here</a>
            </div>
        @endif
    </div>

    <script>
    function addResult(message) {
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML += '<br>' + new Date().toLocaleTimeString() + ': ' + message;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const debugBtn = document.getElementById('debugBtn');
        const realLikeBtn = document.getElementById('realLikeBtn');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (debugBtn) {
            debugBtn.addEventListener('click', function() {
                const artikelId = this.dataset.artikelId;
                addResult('Testing debug endpoint...');
                
                fetch(`/debug-like/${artikelId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    addResult('Debug response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    addResult('Debug response: ' + JSON.stringify(data));
                })
                .catch(error => {
                    addResult('Debug error: ' + error.message);
                });
            });
        }

        if (realLikeBtn) {
            realLikeBtn.addEventListener('click', function() {
                const artikelId = this.dataset.artikelId;
                addResult('Testing real like endpoint...');
                
                fetch(`/artikel/${artikelId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    addResult('Like response status: ' + response.status);
                    if (response.status === 302) {
                        addResult('❌ Got redirect (probably to login)');
                        return { error: 'Redirected to login' };
                    }
                    return response.json();
                })
                .then(data => {
                    addResult('Like response: ' + JSON.stringify(data));
                })
                .catch(error => {
                    addResult('Like error: ' + error.message);
                });
            });
        }
    });
    </script>
</body>
</html>