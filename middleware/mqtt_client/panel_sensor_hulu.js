const mqtt = require('mqtt');

// Konfigurasi koneksi ke broker
const brokerUrl = 'mqtt://public.grootech.id'; // ganti dengan broker Anda
const topic = 'Polsri/panel_sensor_hulu';       // ganti dengan topic Anda

const {
    startWebSocketServer
} = require("../websocket/websocket");

startWebSocketServer();

// Connect ke broker
const client = mqtt.connect(brokerUrl);

client.on('connect', () => {
    console.log(`✅ Terhubung ke broker: ${brokerUrl}`);
    
    // Subscribe ke topic
    client.subscribe(topic, (err) => {
        if (err) {
            console.error('❌ Gagal subscribe ke topic:', topic);
        } else {
            console.log(`📡 Berlangganan ke topic: ${topic}`);
        }
    });
});

// Ketika pesan diterima dari topic
client.on('message', (topic, message) => {
    // Pesan dalam bentuk Buffer, kita ubah ke string
    console.log(`📥 Pesan dari ${topic}: ${message.toString()}`);
    socket.emit('panel_sensor_hulu', message.toString());

});

// Tangani error
client.on('error', (err) => {
    console.error('🚨 Error MQTT:', err);
});
