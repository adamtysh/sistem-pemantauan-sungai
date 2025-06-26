// File: websocket.js
// Status: FINAL - Dengan perbaikan SyntaxError dan handler event yang benar

const express = require('express');
const { createServer } = require('http');
const { Server } = require('socket.io');
require('dotenv').config({ path: '../../.env' });

const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    // Mengizinkan koneksi dari alamat web Laravel Anda.
    origin: "https://puprsvmos.info",
    methods: ["GET", "POST"]
  }
});

io.on('connection', (socket) => {
  console.log('Browser client terhubung:', socket.id);

  socket.on('disconnect', () => {
    console.log('Browser client terputus:', socket.id);
  });

  // ▼▼▼ HANDLER EVENT YANG SUDAH BENAR ▼▼▼
  // Handler generik untuk event 'data_from_mqtt' yang dikirim dari skrip utama.
  // Ini adalah "jembatan" yang akan menerima data dari SEMUA lokasi.
  socket.on('data_from_mqtt', (payload) => {
    // Log untuk memastikan server menerima data dari skrip
    console.log('Server WebSocket menerima data:', payload); 

    // Siarkan event yang sama ke semua browser client yang terhubung
    io.emit('data_from_mqtt', payload);
  });
  // ▲▲▲ BATAS AKHIR PERUBAHAN HANDLER ▲▲▲
});

// Mengambil port dari environment variable atau menggunakan default 3001
const PORT = process.env.WEBSOCKET_PORT || 3001;

function startWebSocketServer() {
    httpServer.listen(PORT, () => {
        // ▼▼▼ PERBAIKAN SYNTAX ERROR DI SINI (DENGAN BACKTICK) ▼▼▼
        console.log(`Server WebSocket berjalan di port ${PORT}`);
    });
}

// Jalankan server jika file ini dieksekusi langsung
if (require.main === module) {
    startWebSocketServer();
}

module.exports = { io, app, startWebSocketServer };
