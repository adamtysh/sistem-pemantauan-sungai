<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;
use App\Models\AlarmSetting;
use App\Models\AlarmLog;
use Illuminate\Support\Facades\Http;
use App\Events\SensorDataReceived; // Pastikan ini ada

class SensorReadingController extends Controller
{
    /**
     * Menerima dan menyimpan data sensor, lalu memicu pengecekan alarm.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari Node.js
        $validatedData = $request->validate([
            'location_name' => 'required|string',
            'sensor_name' => 'required|string',
            'data_value' => 'required|string', // Menerima data value sebagai string
        ]);

        // Simpan pembacaan sensor ke database (Opsional, tapi baik untuk ada)
        SensorReading::create([
            'sensor_name' => $validatedData['sensor_name'],
            'data_value' => $validatedData['data_value'],
            'reading_time' => now()
        ]);

        // Panggil fungsi untuk memeriksa alarm dan mengirim notifikasi
        $this->checkAndTriggerAlarms($validatedData);

        return response()->json([
            'message' => 'Data received and processed by Laravel.',
        ], 201); // 201 artinya Created, menandakan sukses
    }

    /**
     * Memeriksa data sensor terhadap semua pengaturan alarm yang aktif.
     */
    private function checkAndTriggerAlarms(array $data)
    {
        // Cari semua pengaturan alarm yang aktif dan cocok dengan nama sensor
        $alarmSettings = AlarmSetting::whereHas('sensorSetting', function ($query) use ($data) {
            $query->where('sensor_name', $data['sensor_name']);
        })->where('status', 1)->get();

        foreach ($alarmSettings as $setting) {
            // Membersihkan satuan dari data_value sebelum perbandingan
            $cleanedValue = preg_replace('/[^0-9.]/', '', $data['data_value']);
            $value = floatval($cleanedValue);
            
            $threshold = floatval($setting->threshold);
            $operator = $setting->operator;

            $isTriggered = false;
            switch ($operator) {
                case '>': if ($value > $threshold) $isTriggered = true; break;
                case '<': if ($value < $threshold) $isTriggered = true; break;
                case '>=': if ($value >= $threshold) $isTriggered = true; break;
                case '<=': if ($value <= $threshold) $isTriggered = true; break;
                case '==': if ($value == $threshold) $isTriggered = true; break;
            }

            if ($isTriggered) {
                // Catat ke log alarm
                AlarmLog::create([
                    'location_name' => $data['location_name'],
                    'sensor_name' => $data['sensor_name'],
                    'value' => $data['data_value'], // Simpan nilai asli dengan satuannya
                    'message' => $setting->message,
                ]);

                // Kirim notifikasi ke WhatsApp
                $this->sendWhatsAppNotification($data['location_name'], $data['sensor_name'], $data['data_value'], $setting->message);
            }
        }
    }

    /**
     * Mengirim notifikasi WhatsApp menggunakan API Fonnte.
     */
    private function sendWhatsAppNotification($location, $sensor, $value, $message)
    {
        $recipient = env('WA_RECIPIENT');
        $apiKey = env('FONNTE_API_KEY');

        if (!$recipient || !$apiKey) {
            // Jika konfigurasi .env tidak ada, hentikan fungsi agar tidak error
            return;
        }

        // Siapkan format pesan notifikasi
        $notificationMessage = "🚨 *ALARM SISTEM PEMANTAUAN SUNGAI* 🚨\n\n" .
                               "Pesan: *" . $message . "*\n\n" .
                               "Lokasi: *" . $location . "*\n" .
                               "Sensor: *" . $sensor . "*\n" .
                               "Nilai Terbaca: *" . $value . "*\n\n" .
                               "Harap segera ditindaklanjuti.";

        // Kirim request ke API Fonnte
        Http::withHeaders([
            'Authorization' => $apiKey,
        ])->post('https://api.fonnte.com/send', [
            'target' => $recipient,
            'message' => $notificationMessage,
        ]);
    }
}