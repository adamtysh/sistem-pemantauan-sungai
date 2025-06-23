// resources/js/app.js

import './bootstrap';

window.Echo.channel('sensor-data')
    .listen('SensorDataReceived', (e) => {
        console.log(e); 

        // Menggunakan nama sensor yang ada di database Anda
        // Pastikan ID elemen di HTML juga sesuai

        if (e.sensor_name === 'Suhu') { //
            // Ganti 'suhu-value-id' dengan ID elemen span untuk suhu
            document.getElementById('suhu-value-id').innerText = e.data_value;
        }

        if (e.sensor_name === 'Sensor Water Level') { //
            // Ganti 'level-value-id' dengan ID elemen span untuk level air
            document.getElementById('level-value-id').innerText = e.data_value;
        }

        if (e.sensor_name === 'Curah Hujan') { //
            // Ganti 'hujan-value-id' dengan ID elemen span untuk curah hujan
            document.getElementById('hujan-value-id').innerText = e.data_value;
        }
        
        // ... lanjutkan untuk 'Kelembapan' dan 'Tekanan Udara'
    });