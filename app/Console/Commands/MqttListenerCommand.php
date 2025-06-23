<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\SensorReading;
use App\Models\SensorSetting;
use PhpMqtt\Client\Facades\MQTT;

class MqttListenerCommand extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to MQTT topic and store sensor data';

    public function handle()
    {
        $mqtt = MQTT::connection();
        $topic = 'panel_sensor_rumah_pompa';

        $this->info("Listening to MQTT topic: " . $topic);

        $mqtt->subscribe($topic, function (string $topic, string $message) {
            $this->info("Message received on topic [{$topic}]");
            Log::info("MQTT Message: " . $message);

            try {
                $payload = json_decode($message, true);
                if (!isset($payload['RUMAH_POMPA']) || !is_array($payload['RUMAH_POMPA'])) {
                    $this->warn("Skipping message due to invalid format.");
                    return;
                }
                $sensorsData = $payload['RUMAH_POMPA'];

                foreach ($sensorsData as $item) {
                    $sensorName = $item['name'];
                    $sensorData = $item['data'];
                    $readingTime = date('Y-m-d H:i:s', $item['timestamp']);

                    switch ($sensorName) {
                        case 'Sensor_Suhu':
                            $values = explode(',', $sensorData);
                            $this->saveReading('Suhu', $values[0] / 10.0, $readingTime);
                            $this->saveReading('Humidity', $values[1] / 10.0, $readingTime);
                            break;
                        case 'Sensor_Level':
                            $this->saveReading('Level', $sensorData / 10.0, $readingTime);
                            break;
                        case 'Sensor_Hujan':
                            $this->saveReading('Hujan', $sensorData, $readingTime);
                            break;
                    }
                }
            } catch (\Exception $e) {
                $this->error("Failed to process MQTT message: " . $e->getMessage());
                Log::error("Failed to process MQTT message: " . $e->getMessage());
            }
        }, 1);

        $mqtt->loop(true);
    }

    private function saveReading(string $sensorName, float $value, string $readingTime)
    {
        // Pastikan Anda sudah punya data sensor dengan nama-nama ini 
        // di tabel sensor_settings Anda.
        $sensorSetting = SensorSetting::where('sensor_name', $sensorName)->first();
        if ($sensorSetting) {
            SensorReading::create([
                'sensor_id' => $sensorSetting->id,
                'value' => $value,
                'reading_time' => $readingTime
            ]);
            $this->info("Saved [{$sensorName}] reading: {$value}");
        } else {
            $this->warn("Sensor setting for '{$sensorName}' not found in database.");
        }
    }
}