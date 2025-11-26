<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $artikel->judul }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #007bff;
        }
        .meta {
            color: #666;
            font-size: 11px;
            margin-bottom: 10px;
        }
        .meta-item {
            display: inline-block;
            margin: 0 10px;
        }
        .content {
            text-align: justify;
            margin: 30px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $artikel->judul }}</div>
        <div class="meta">
            <span class="meta-item">Penulis: {{ $artikel->user->nama }}</span>
            <span class="meta-item">Kategori: {{ $artikel->kategori->nama_kategori }}</span>
            <span class="meta-item">Tanggal: {{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') }}</span>
        </div>
    </div>
    
    @if($artikel->foto && file_exists(storage_path('app/public/' . $artikel->foto)))
    <div class="image-section" style="text-align: center; margin: 20px 0;">
        @php
            $imagePath = storage_path('app/public/' . $artikel->foto);
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $src = 'data:image/' . $imageType . ';base64,' . $imageData;
        @endphp
        <img src="{{ $src }}" style="max-width: 100%; height: auto; max-height: 300px;" alt="{{ $artikel->judul }}">
    </div>
    @endif
    
    <div class="content">
        {!! nl2br(e($artikel->isi)) !!}
    </div>
    
    <div class="footer">
        <p>Mading Digital - Diunduh pada {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>