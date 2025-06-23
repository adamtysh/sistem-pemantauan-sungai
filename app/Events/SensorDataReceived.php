<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorDataReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Properti publik ini akan dikirim ke frontend
    public $location_name; // <-- TAMBAHKAN INI
    public $sensor_name;
    public $data_value;

    /**
     * Create a new event instance.
     */
    public function __construct($location_name, $sensor_name, $data_value) // <-- TAMBAHKAN INI
    {
        $this->location_name = $location_name; // <-- TAMBAHKAN INI
        $this->sensor_name = $sensor_name;
        $this->data_value = $data_value;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('sensor-data'),
        ];
    }
}