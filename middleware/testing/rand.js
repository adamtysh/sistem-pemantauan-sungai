const mqtt = require('mqtt');

const brokerUrl = 'mqtt://public.grootech.id'; // Ganti dengan broker kamu
const topic = 'Polsri/panel_sensor_rumah_pompa';

const client = mqtt.connect(brokerUrl);

// Nilai awal
let payload = {"RUMAH_POMPA":[{"timestamp":1744093476,"date":"08/04/2025 06:24:36","bdate":null,"server_id":3,"bserver_id":3,"addr":1,"baddr":null,"full_addr":"400001","size":4,"data":"1533","raw_data":null,"server_name":"Level","ip":"192.168.5.2","name":"Sensor_Level"},{"timestamp":1744093476,"date":"08/04/2025 06:24:36","bdate":null,"server_id":1,"bserver_id":1,"addr":1,"baddr":null,"full_addr":"400001","size":15,"data":"342,680,0,0,274","raw_data":null,"server_name":"Suhu","ip":"192.168.5.2","name":"Sensor_Suhu"},{"timestamp":1744093476,"date":"08/04/2025 06:24:36","bdate":null,"server_id":2,"bserver_id":2,"addr":1,"baddr":null,"full_addr":"400001","size":4,"data":"9880","raw_data":null,"server_name":"Hujan","ip":"192.168.5.2","name":"Sensor_Hujan"}]};

// Saat terkoneksi ke broker
client.on('connect', () => {
  console.log('Connected to MQTT broker');

  // Publish setiap 5 detik
  const interval = setInterval(() => {
    client.publish(topic, JSON.stringify(payload), { qos: 0 }, (err) => {
      if (err) {
        console.error('Publish error:', err);
      } else {
        console.log('Published:', payload);
      }
    });
  }, 5000);

  // Setelah 2 menit, ubah semua nilai 1 menjadi 2
  setTimeout(() => {
    for (let key in payload) {
      if (payload[key] === 1) {
        payload[key] = 0;
      }
    }
    console.log('Payload updated after 2 minutes:', payload);
  }, 120000); // 120000 ms = 2 menit
});

// Tangani error MQTT
client.on('error', (err) => {
  console.error('MQTT Error:', err);
  client.end();
});
