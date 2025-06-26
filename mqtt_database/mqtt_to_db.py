# File: mqtt_to_db.py
# Status: FINAL - Menyimpan data setiap 1 menit (60 detik)

import paho.mqtt.client as mqtt
import json
import time
from datetime import datetime
import pg8000.dbapi as pg
import pytz

# --- PENGATURAN ---
BROKER_ADDRESS = "public.grootech.id"
PROCESS_INTERVAL = 60  # Interval dalam detik (60 detik = 1 menit)
DB_CONFIG = {
    'host': "127.0.0.1",
    'database': "iot-banjir",
    'user': "adam",
    'password': "adam050504", # Ganti dengan password Anda
    'port': 5432
}
LOCATION_MAP = {
    "Polsri/panel_sensor_rumah_pompa": {"json_key": "RUMAH_POMPA", "location_id": 1},
    "Polsri/panel_sensor_hulu": {"json_key": "HULU", "location_id": 2},
    "Polsri/panel_sensor_hilir": {"json_key": "HILIR", "location_id": 3}
}
topics = list(LOCATION_MAP.keys())

# Variabel global untuk menyimpan data terbaru dari setiap topik
latest_data_buffer = {}

# --- FUNGSI-FUNGSI ---
def save_row_to_db(waktu, nilai, nama_sensor, location_id):
    db = None
    try:
        db = pg.connect(**DB_CONFIG)
        cursor = db.cursor()
        sql = "INSERT INTO sensor_readings (location_id, reading_time, data_value, sensor_name, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s)"
        now = datetime.now(pytz.utc)
        val = (location_id, waktu, str(nilai), nama_sensor, now, now)
        cursor.execute(sql, val)
        db.commit()
        print(f"  -> Data '{nama_sensor}'='{nilai}' dari Lokasi ID {location_id} berhasil disimpan.")
    except pg.Error as err:
        print(f"Error Database: {err}")
    finally:
        if db is not None:
            db.close()

def process_and_write_data():
    if not latest_data_buffer:
        print(f"[{datetime.now(pytz.timezone('Asia/Jakarta')).strftime('%H:%M:%S')}] Tidak ada data baru untuk disimpan, menunggu...")
        return

    print(f"--- Memproses Grup Data per {PROCESS_INTERVAL} detik ---")
    
    # Proses setiap data yang ada di buffer
    for topic, payload in latest_data_buffer.items():
        location_config = LOCATION_MAP.get(topic)
        if not location_config:
            continue

        waktu_grup = datetime.now(pytz.utc)
        units = {'Suhu': '° C', 'Kelembapan': ' RH', 'Tekanan Udara': ' hPa', 'Sensor_Water Level': 'cm', 'Sensor_Curah Hujan': ' mm'}
        name_map = {'Sensor_Hujan': 'Sensor_Curah Hujan', 'Sensor_Level': 'Sensor_Water Level'}
        
        list_sensor_data = payload.get(location_config['json_key'], [])

        for sensor_data in list_sensor_data:
            original_sensor_name = sensor_data.get('name', 'N/A')
            data_value = sensor_data.get('data')

            if original_sensor_name == 'Sensor_Suhu':
                try:
                    parts = str(data_value).split(',')
                    if len(parts) >= 5:
                        sub_sensors = {
                            'Suhu': float(parts[0]) / 10,
                            'Kelembapan': float(parts[1]) / 10,
                            'Tekanan Udara': float(parts[4]) + 800 
                        }
                        for name, calculated_value in sub_sensors.items():
                            unit = units.get(name, '')
                            display_value = f"{calculated_value}{unit}"
                            save_row_to_db(waktu_grup, display_value, name, location_config['location_id'])
                except Exception as e:
                    print(f"   -> Gagal memproses data Sensor Suhu: {e}")
            else:
                final_data_value = data_value
                if original_sensor_name != 'Sensor_Hujan':
                    try:
                        final_data_value = float(data_value) / 10
                    except (ValueError, TypeError):
                        pass
                
                unit = units.get(original_sensor_name, '')
                display_value = f"{final_data_value}{unit}"
                display_sensor_name = name_map.get(original_sensor_name, original_sensor_name)
                save_row_to_db(waktu_grup, display_value, display_sensor_name, location_config['location_id'])

    # Kosongkan buffer setelah selesai diproses
    latest_data_buffer.clear()


def on_message(client, userdata, msg):
    """Fungsi ini hanya akan menyimpan data terbaru ke buffer."""
    try:
        # Simpan seluruh payload dengan topiknya sebagai kunci
        latest_data_buffer[msg.topic] = json.loads(msg.payload.decode('utf-8'))
    except Exception as e:
        print(f"Gagal memproses pesan ke buffer: {e}")


def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Berhasil terhubung/rekoneksi ke broker MQTT!")
        for topic in topics:
            client.subscribe(topic)
            print(f" -> Berlangganan topik: {topic}")
    else:
        print(f"Gagal terhubung, kode hasil: {rc}")


def main():
    client = mqtt.Client("db_logger_interval_" + str(time.time()))
    client.on_connect = on_connect
    client.on_message = on_message
    
    try:
        client.connect(BROKER_ADDRESS, 1883, 60)
    except Exception as e:
        print(f"Gagal terhubung saat awal: {e}")
        return

    client.loop_start()  # Jalankan loop di thread terpisah

    print(f"Skrip berjalan. Data akan disimpan ke database setiap {PROCESS_INTERVAL} detik...")
    try:
        while True:
            # Tunggu interval waktu
            time.sleep(PROCESS_INTERVAL)
            # Proses data yang sudah terkumpul di buffer
            process_and_write_data()
            
    except KeyboardInterrupt:
        print("Skrip dihentikan oleh pengguna.")
    finally:
        client.loop_stop()
        print("Koneksi MQTT ditutup.")

if __name__ == '__main__':
    main()
