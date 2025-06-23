// File: panel_sensor_rumah_pompa.js
// Status: FINAL LENGKAP - Multi-Lokasi dengan Notifikasi Ganda (Fonnte & Pushover)

const mqtt = require('mqtt');
const { io } = require("socket.io-client");
const axios = require('axios');

// ================== PENGATURAN PENTING (SUDAH DIISI) ==================
const LARAVEL_URL = 'http://127.0.0.1:8000';

// --- Kredensial Anda berdasarkan file dan riwayat percakapan ---
const WHATSAPP_PHONE_NUMBER = '6285935056842';
const FONNTE_TOKEN = 'CyP64SZNRxgqKWGH1NZc';
const PUSHOVER_USER_KEY = 'usn64k9f9nsxysjm27ufu84879s82b';
const PUSHOVER_API_TOKEN = 'amfm3bpssioy559vae7c3qirgvaaav';
// ======================================================================

const mqttOptions = {
    host: 'public.grootech.id',
    port: 1883,
    protocol: 'mqtt',
    clientId: 'dashboard_handler_' + Math.random().toString(16).substr(2, 8)
};
const socket = io("http://127.0.0.1:3001");
const mqttClient = mqtt.connect(mqttOptions);

// PETA LOKASI: Kunci dari sistem multi-lokasi
const locationMap = {
    'Polsri/panel_sensor_rumah_pompa': {
        locationSlug: 'panel-sensor-rumah-pompa-24ilir', 
        eventName: 'data_from_mqtt',
        jsonKey: 'RUMAH_POMPA'
    },
    'Polsri/panel_sensor_hulu': {
        locationSlug: 'panel-sensor-hulu',
        eventName: 'data_from_mqtt',
        jsonKey: 'HULU'
    },
    'Polsri/panel_sensor_hilir': {
        locationSlug: 'panel-sensor-hilir',
        eventName: 'data_from_mqtt',
        jsonKey: 'HILIR'
    }
};

const topics = Object.keys(locationMap);
let activeAlarms = [];
let alarmStates = {};

async function fetchAlarmSettings() {
    try {
        console.log('INFO: Mengambil pengaturan alarm dari Laravel...');
        const response = await axios.get(`${LARAVEL_URL}/api/active-alarms`);
        activeAlarms = response.data;
        console.log(`BERHASIL: ${activeAlarms.length} aturan alarm aktif dimuat.`);
    } catch (error) {
        console.error('ERROR: Gagal mengambil pengaturan alarm. Pastikan server Laravel berjalan.');
    }
}

function checkAlarms(sensorName, sensorValue) {
    activeAlarms.forEach(alarm => {
        if (alarm.sensor_name === sensorName) {
            const value = parseFloat(sensorValue);
            const threshold = alarm.threshold;
            let conditionMet = false;

            if (alarm.operator === '>' && value > threshold) conditionMet = true;
            else if (alarm.operator === '<' && value < threshold) conditionMet = true;
            else if (alarm.operator === '>=' && value >= threshold) conditionMet = true;
            else if (alarm.operator === '<=' && value <= threshold) conditionMet = true;
            else if (alarm.operator === '==' && value == threshold) conditionMet = true;

            if (conditionMet) {
                if (!alarmStates[alarm.id] || !alarmStates[alarm.id].triggered) {
                    console.log(`ALARM TERPICU: ${sensorName} (${value}) ${alarm.operator} ${threshold}.`);
                    triggerAlarmActions(alarm, value);
                    alarmStates[alarm.id] = { triggered: true };
                }
            } else {
                if (alarmStates[alarm.id] && alarmStates[alarm.id].triggered) {
                    console.log(`INFO: Kondisi alarm untuk ${sensorName} telah kembali normal.`);
                    alarmStates[alarm.id] = { triggered: false };
                }
            }
        }
    });
}

function triggerAlarmActions(alarm, value) {
    const textMessage = `🚨 ALARM: ${alarm.message} 🚨\n\nLokasi: ${alarm.location_name}\nSensor: ${alarm.sensor_name}\nNilai Tercapai: ${value}`;
    
    // 1. Kirim notifikasi Teks via Fonnte
    axios.post('https://api.fonnte.com/send', {
        target: WHATSAPP_PHONE_NUMBER,
        message: textMessage
    }, {
        headers: { 'Authorization': FONNTE_TOKEN }
    })
    .then(() => console.log(`BERHASIL: Notifikasi Teks (Fonnte) untuk alarm "${alarm.message}" terkirim.`))
    .catch(error => console.error('ERROR: Gagal mengirim notifikasi Fonnte:', error.response ? error.response.data.reason : error.message));

    // 2. Kirim notifikasi DARURAT via Pushover
    axios.post('https://api.pushover.net/1/messages.json', {
        token: PUSHOVER_API_TOKEN,
        user: PUSHOVER_USER_KEY,
        message: `Lokasi: ${alarm.location_name}\nSensor: ${alarm.sensor_name}\nNilai: ${value}`,
        title: `🚨 ALARM: ${alarm.message} 🚨`,
        priority: 1, sound: 'siren'
    })
    .then(() => console.log(`BERHASIL: Notifikasi Darurat (Pushover) untuk alarm "${alarm.message}" terkirim.`))
    .catch(error => console.error('ERROR: Gagal mengirim notifikasi Pushover:', error.response ? error.response.data : error.message));
    
    // 3. Simpan riwayat alarm ke database
    axios.post(`${LARAVEL_URL}/api/log-alarm`, {
        location_name: alarm.location_name,
        sensor_name: alarm.sensor_name,
        value: String(value),
        message: alarm.message,
    })
    .then(() => console.log('BERHASIL: Riwayat alarm berhasil disimpan ke database.'))
    .catch(error => console.error('ERROR: Gagal menyimpan riwayat alarm:', error.response ? error.response.data : error.message));
}

function processSensorData(sensorArray) {
    const processed = [];
    const nameMap = { 'Sensor_Level': 'Water Level', 'Sensor_Hujan': 'Curah Hujan', 'Kelembapan': 'Humidity', 'Tekanan Udara': 'Barometric Pressure' };
    sensorArray.forEach(sensor => {
        if (sensor.name === 'Sensor_Suhu') {
            try {
                const parts = String(sensor.data).split(',');
                if (parts.length >= 5) {
                    processed.push({ name: 'Suhu', value: (parseFloat(parts[0]) / 10).toFixed(1) });
                    processed.push({ name: 'Humidity', value: (parseFloat(parts[1]) / 10).toFixed(1) });
                    processed.push({ name: 'Barometric Pressure', value: (parseFloat(parts[4]) + 800).toFixed(1) });
                }
            } catch (e) { console.error("Gagal memproses data Sensor_Suhu:", e); }
        } else {
            let finalValue = sensor.data;
            if (sensor.name === 'Sensor_Level') {
                try { finalValue = (parseFloat(sensor.data) / 10).toFixed(1); } catch (e) {}
            }
            const displayName = nameMap[sensor.name] || sensor.name;
            processed.push({ name: displayName, value: finalValue });
        }
    });
    return { SENSOR_DATA: processed };
}

mqttClient.on('connect', () => {
    console.log('BERHASIL: Terhubung ke broker MQTT');
    mqttClient.subscribe(topics, (err) => {
        if (!err) {
            console.log(`Berhasil subscribe ke topik: ${topics.join(', ')}`);
        } else {
            console.error('Gagal subscribe ke topik:', err);
        }
    });
});

mqttClient.on('message', (topic, message) => {
    const locationConfig = locationMap[topic];
    if (!locationConfig) return;

    try {
        console.log(`INFO: Pesan MQTT diterima dari topik setiap 5 detik ${topic}`);
        const rawData = JSON.parse(message.toString());
        const sensorArray = rawData[locationConfig.jsonKey];

        if (sensorArray) {
            const processedData = processSensorData(sensorArray);
            const payload = {
                locationSlug: locationConfig.locationSlug,
                data: processedData.SENSOR_DATA
            };
            
            socket.emit(locationConfig.eventName, payload);
            console.log(`INFO: Data dari ${locationConfig.locationSlug} dikirim ke WebSocket.`);
            
            processedData.SENSOR_DATA.forEach(sensor => {
                checkAlarms(sensor.name, sensor.value);
            });
        }
    } catch (e) {
        console.error(`ERROR: Gagal memproses pesan dari topik ${topic}:`, e);
    }
});

async function main() {
    console.log("Memulai skrip alarm dan monitoring multi-lokasi...");
    await fetchAlarmSettings();
    setInterval(fetchAlarmSettings, 300000); 
    
    socket.on('connect', () => {
        console.log('BERHASIL: Terhubung ke WebSocket Server sebagai client:', socket.id);
    });
}

main();