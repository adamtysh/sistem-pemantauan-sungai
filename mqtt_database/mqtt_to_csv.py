# File: mqtt_to_csv.py
# Status: FINAL - Disesuaikan agar format & satuan sama dengan mqtt_to_db.py

import paho.mqtt.client as mqtt
import json
import csv
import os
import time
from datetime import datetime

# --- Pengaturan ---
BROKER_ADDRESS = "public.grootech.id"
MQTT_TOPIC = "Polsri/panel_sensor_rumah_pompa"
BROKER_PORT = 1883
PROCESS_INTERVAL = 60  # Interval dalam detik (1 menit)
CSV_FILE = 'data_mqtt.csv'
CSV_HEADER = ['waktu_terima', 'data_value', 'sensor_name']

# Variabel Global untuk menyimpan data terakhir
latest_data = {}

def save_row_to_csv(waktu, nilai, nama_sensor):
    """Fungsi untuk menyimpan satu baris data yang sudah diproses ke CSV."""
    try:
        new_row = [waktu, nilai, nama_sensor]
        with open(CSV_FILE, 'a', newline='', encoding='utf-8') as f:
            writer = csv.writer(f)
            writer.writerow(new_row)
        print(f" -> Data untuk '{nama_sensor}' dengan nilai '{nilai}' berhasil disimpan ke CSV.")
    except Exception as e:
        print(f"Error saat menulis ke CSV: {e}")

def process_and_write_data():
    """
    Fungsi ini mengambil semua data yang tersimpan, memprosesnya,
    dan menuliskannya ke file CSV.
    """
    if not latest_data:
        print(f"[{datetime.now().strftime('%H:%M:%S')}] Tidak ada data baru, menunggu...")
        return

    print(f"--- Memproses Grup Data per Menit untuk CSV ---")
    waktu_grup = datetime.now()
    
    # DIUBAH: Satuan untuk Tekanan Udara diperbarui ke hPa agar sama dengan skrip database
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
                        # DIUBAH: Rumus perhitungan disamakan persis dengan skrip mqtt_to_db.py
                        sub_sensors = {
                            'Suhu': float(parts[0]) / 10,
                            'Kelembapan': float(parts[1]) / 10,
                            'Tekanan Udara': float(parts[4]) + 800 
                        }
                        for name, calculated_value in sub_sensors.items():
                            unit = units.get(name, '')
                            display_value = f"{calculated_value}{unit}"
                            save_row_to_csv(waktu_grup.strftime('%Y-%m-%d %H:%M:%S'), display_value, name)
                except Exception as e:
                    print(f" -> Gagal memproses data Sensor Suhu: {e}")
            else:
                # Logika ini sudah sama dengan skrip database, jadi tidak perlu diubah
                final_data_value = data_value
                if original_sensor_name != 'Sensor_Hujan':
                    try: final_data_value = float(data_value) / 10
                    except (ValueError, TypeError): pass
                
                unit = units.get(original_sensor_name, '')
                display_value = f"{final_data_value}{unit}"
                display_sensor_name = name_map.get(original_sensor_name, original_sensor_name)
                save_row_to_csv(waktu_grup.strftime('%Y-%m-%d %H:%M:%S'), display_value, display_sensor_name)
            
    latest_data.clear()

# ===================================================================
# Sisa kode di bawah ini tidak perlu diubah karena sudah berfungsi dengan baik
# ===================================================================

def on_message(client, userdata, msg):
    """Fungsi ini hanya bertugas mengumpulkan data terbaru."""
    try:
        data_dict = json.loads(msg.payload.decode('utf-8'))
        list_sensor_data = data_dict["RUMAH_POMPA"]
        for sensor_data in list_sensor_data:
            sensor_name = sensor_data.get('name')
            if sensor_name:
                latest_data[sensor_name] = sensor_data
    except Exception:
        pass

def on_connect(client, userdata, flags, rc):
    """Callback untuk saat koneksi berhasil."""
    if rc == 0:
        print("Berhasil terhubung/rekoneksi ke broker MQTT!")
        client.subscribe(MQTT_TOPIC)
    else:
        print(f"Gagal terhubung, kode hasil: {rc}")

def on_disconnect(client, userdata, rc):
    """Callback untuk saat koneksi terputus."""
    print(f"Koneksi terputus! (kode: {rc})")

def main():
    if not os.path.exists(CSV_FILE):
        with open(CSV_FILE, 'w', newline='', encoding='utf-8') as f:
            writer = csv.writer(f)
            writer.writerow(CSV_HEADER)
        print(f"File {CSV_FILE} baru dibuat.")

    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1, "csv_writer_db_format")
    client.on_connect = on_connect
    client.on_disconnect = on_disconnect
    client.on_message = on_message

    print(f"Mencoba terhubung ke broker {BROKER_ADDRESS}...")
    
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
    print("Skrip berjalan. Data akan disimpan ke CSV setiap 1 menit...")
    
    try:
        while True:
            time.sleep(1)
            if time.time() - last_processed_time >= PROCESS_INTERVAL:
                process_and_write_data()
                last_processed_time = time.time()
            
    except KeyboardInterrupt:
        print("Skrip dihentikan oleh pengguna.")
    finally:
        client.loop_stop()
        print("Koneksi MQTT ditutup.")

if __name__ == '__main__':
    main()