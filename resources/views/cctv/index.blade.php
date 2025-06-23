@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $page_title }}</h5>
        <hr>
        <div class="video-container" style="background-color: #000;">
            <video id="cctv-player" class="w-100" controls autoplay muted playsinline></video>
        </div>
        <div class="alert alert-info mt-3">
            <i class='bx bx-info-circle'></i> 
            Streaming mungkin mengalami sedikit jeda (delay) beberapa detik, ini adalah hal yang normal untuk teknologi HLS.
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var video = document.getElementById('cctv-player');
        // ▼▼▼ URL ini mengarah ke media server yang berjalan di komputer LOKAL Anda ▼▼▼
        var hlsUrl = 'http://127.0.0.1:8008/live/cctv_sungai_local/index.m3u8';

        if (Hls.isSupported()) {
            var hls = new Hls();
            hls.loadSource(hlsUrl);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                video.play().catch(e => console.error("Gagal memulai video secara otomatis:", e));
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = hlsUrl;
        }
    });
</script>
@endpush