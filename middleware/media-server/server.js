const NodeMediaServer = require('node-media-server');

const config = {
  rtmp: {
    port: 1935,
    chunk_size: 60000,
    gop_cache: true,
    ping: 30,
    ping_timeout: 60
  },
  http: {
    port: 8008, // Port untuk mengakses stream HLS secara lokal
    allow_origin: '*'
  },
  trans: {
    ffmpeg: 'ffmpeg.exe', // Path ke ffmpeg di Windows
    tasks: [
      {
        app: 'live',
        hls: true,
        hlsFlags: '[hls_time=2:hls_list_size=3:hls_flags=delete_segments]',
        hlsKeep: false, 
      }
    ]
  },
  relay: {
    ffmpeg: 'ffmpeg.exe',
    tasks: [
      {
        app: 'live',
        mode: 'pull',
        // ▼▼▼ GANTI DENGAN URL RTSP LOKAL KAMERA ANDA ▼▼▼
        edge: 'rtsp://admin:Banjir12@192.168.5.4:554/Streaming/Channels/101',
        name: 'cctv_sungai_local', // Nama stream lokal Anda
        rtsp_transport: 'tcp' 
      }
    ]
  }
};

var nms = new NodeMediaServer(config)
nms.run();
console.log('Media Server LOKAL berjalan di port http://localhost:8008');