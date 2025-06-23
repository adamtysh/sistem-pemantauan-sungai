# File: mqtt_to_db.py
# Status: FINAL - Dengan Rumus Perhitungan yang Akurat

import paho.mqtt.client as mqtt
import json
import time
from datetime import datetime
import os
import pg8000.dbapi as pg

# --- Pengaturan ---
BROKER_ADDRESS = "public.grootech.id"
MQTT_TOPIC = "Polsri/panel_sensor_rumah_pompa"
BROKER_PORT = 1883
PROCESS_INTERVAL = 60

# --- PENGATURAN KONEKSI DATABASE POSTGRESQL ---
DB_CONFIG = {
    'host': "127.0.0.1",
    'database': "iot-banjir",
    'user': "postgres",
    'password': "adam050504",
    'port': 5432
}

latest_data = {}

def save_row_to_db(waktu, nilai, nama_sensor):
    db = None
    try:
        db = pg.connect(**DB_CONFIG)
        cursor = db.cursor()
        sql = "INSERT INTO sensor_readings (reading_time, data_value, sensor_name, created_at, updated_at) VALUES (%s, %s, %s, %s, %s)"
        now = datetime.now()
        val = (waktu, str(nilai), nama_sensor, now, now)
        cursor.execute(sql, val)
        db.commit()
        print(f" -> Data untuk '{nama_sensor}' dengan nilai '{nilai}' berhasil disimpan ke database.")
    except pg.Error as err:
        print(f"Error Database: {err}")
    finally:
        if db is not None:
            db.close()

def process_and_write_data():
    if not latest_data:
        print(f"[{datetime.now().strftime('%H:%M:%S')}] Tidak ada data baru, menunggu...")
        return

    print(f"--- Memproses Grup Data per Menit ---")
    waktu_grup = datetime.now()
    # DIUBAH: Satuan untuk Tekanan Udara diperbarui ke hPa
    units = {'Suhu': '° C', 'Kelembapan': ' RH', 'Tekanan Udara': ' hPa', 'Sensor_Level': 'cm', 'Sensor_Hujan': ' mm'}
    name_map = {'Sensor_Hujan': 'Sensor_Curah Hujan', 'Sensor_Level': 'Sensor_Water Level'}
    sensor_order = ['Sensor_Level', 'Sensor_Hujan', 'Sensor_Suhu']

    for sensor_name in sensor_order:
        if sensor_name in latest_data:
            sensor_data = latest_data[sensor_name]
            original_sensor_name = sensor_data.get('name', 'N/A')
            data_value = sensor_data.get('data')
            if data_value is None or str(data_value).strip() == "": continue
            
            if original_sensor_name == 'Sensor_Suhu':
                try:
                    parts = str(data_value).split(',')
                    if len(parts) >= 5:
                        # DIUBAH: Rumus perhitungan disesuaikan dengan buku panduan
                        sub_sensors = {
                            'Suhu': float(parts[0]) / 10,
                            'Kelembapan': float(parts[1]) / 10,
                            'Tekanan Udara': float(parts[4]) + 800 
                        }
                        for name, calculated_value in sub_sensors.items():
                            unit = units.get(name, '')
                            display_value = f"{calculated_value}{unit}"
                            save_row_to_db(waktu_grup.strftime('%Y-%m-%d %H:%M:%S'), display_value, name)
                except Exception as e:
                    print(f" -> Gagal memproses data Sensor Suhu: {e}")
            else:
                final_data_value = data_value
                if original_sensor_name != 'Sensor_Hujan':
                    try: final_data_value = float(data_value) / 10
                    except (ValueError, TypeError): pass
                
                unit = units.get(original_sensor_name, '')
                display_value = f"{final_data_value}{unit}"
                display_sensor_name = name_map.get(original_sensor_name, original_sensor_name)
                save_row_to_db(waktu_grup.strftime('%Y-%m-%d %H:%M:%S'), display_value, display_sensor_name)
            
    latest_data.clear()

# --- Sisa kode (on_message, on_connect, on_disconnect, main) tetap sama ---
def on_message(client, userdata, msg):
    try:
        data_dict = json.loads(msg.payload.decode('utf-8'))
        list_sensor_data = data_dict["RUMAH_POMPA"]
        for sensor_data in list_sensor_data:
            sensor_name = sensor_data.get('name')
            if sensor_name: latest_data[sensor_name] = sensor_data
    except Exception: pass

def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Berhasil terhubung/rekoneksi ke broker MQTT!")
        client.subscribe(MQTT_TOPIC)
    else: print(f"Gagal terhubung, kode hasil: {rc}")

def on_disconnect(client, userdata, rc):
    print(f"Koneksi terputus! (kode: {rc})")

def main():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1, "laravel_pg_writer_accurate")
    client.on_connect = on_connect
    client.on_disconnect = on_disconnect
    client.on_message = on_message
    is_connected = False
    while not is_connected:
        try:
            client.connect(BROKER_ADDRESS, BROKER_PORT, 60)
            is_connected = True
        except Exception as e:
            print(f"Gagal terhubung saat awal: {e}. Mencoba lagi dalam 5 detik...")
            time.sleep(5)
    client.loop_start() 
    last_processed_time = time.time()
    print("Skrip berjalan. Data akan disimpan ke database PostgreSQL setiap 1 menit...")
    try:
        while True:
            if time.time() - last_processed_time >= PROCESS_INTERVAL:
                process_and_write_data()
                last_processed_time = time.time()
            time.sleep(1)
    except KeyboardInterrupt:
        print("Skrip dihentikan oleh pengguna.")
    finally:
        client.loop_stop()
        print("Koneksi MQTT ditutup.")

if __name__ == '__main__':
    main()