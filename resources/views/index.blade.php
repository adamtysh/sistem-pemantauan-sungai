@extends('layouts.main')

@push('css')
<style>
    .dashboard-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
        cursor: pointer;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    .icon-bg-light-warning { background-color: rgba(255, 193, 7, 0.15); }
    .icon-bg-light-primary { background-color: rgba(13, 110, 253, 0.15); }
    .icon-bg-light-info { background-color: rgba(13, 202, 240, 0.15); }
    .icon-bg-light-success { background-color: rgba(25, 135, 84, 0.15); }
    .icon-bg-light-secondary { background-color: rgba(108, 117, 125, 0.15); }
    .sensor-name-title {
        font-weight: 600;
        color: #495057;
    }
</style>
@endpush

@section('content')
    
    @foreach ($locations as $location)
        <div class="d-flex align-items-center mt-4">
            <h5 class="mb-0 text-uppercase">{{ $location->name }}</h5>
            
            @if($location->latitude && $location->longitude)
                <a href="https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}" 
                   target="_blank" 
                   class="ms-3" 
                   title="Lihat di Google Maps">
                    <i class='bx bxs-map-pin bx-sm text-danger'></i>
                </a>
            @endif
        </div>
        <hr />

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            
            @foreach ($location->sensorSettings()->orderBy('id', 'asc')->get() as $sensor)
                @php
                    $displayName = $sensor->display_name ?? Str::replace('_', ' ', $sensor->sensor_name);
                    $icon = 'bx bx-chip'; 
                    $colorClass = 'text-secondary';
                    $bgClass = 'icon-bg-light-secondary';

                    if (Str::contains(strtolower($sensor->sensor_name), 'suhu')) { $icon = 'bx bxs-thermometer'; $colorClass = 'text-warning'; $bgClass = 'icon-bg-light-warning'; } 
                    elseif (Str::contains(strtolower($sensor->sensor_name), 'level')) { $icon = 'bx bx-water'; $colorClass = 'text-primary'; $bgClass = 'icon-bg-light-primary'; }
                    elseif (Str::contains(strtolower($sensor->sensor_name), 'humidity') || Str::contains(strtolower($sensor->sensor_name), 'kelembapan')) { $icon = 'bx bx-droplet'; $colorClass = 'text-info'; $bgClass = 'icon-bg-light-info'; }
                    elseif (Str::contains(strtolower($sensor->sensor_name), 'pressure') || Str::contains(strtolower($sensor->sensor_name), 'tekanan')) { $icon = 'bx bx-wind'; $colorClass = 'text-success'; $bgClass = 'icon-bg-light-success'; }
                    elseif (Str::contains(strtolower($sensor->sensor_name), 'hujan')) { $icon = 'bx bx-cloud-rain'; $colorClass = 'text-secondary'; $bgClass = 'icon-bg-light-secondary'; }
                @endphp
        
                <div class="col">
                    <div class="card h-100 dashboard-card" onclick="window.location.href='{{ route('trending.index', ['sensorName' => $sensor->display_name ?? $sensor->sensor_name]) }}'">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="widgets-icons-2 rounded-circle {{ $bgClass }} {{ $colorClass }} p-3">
                                    <i class='{{ $icon }}' style="font-size: 2em;"></i>
                                </div>
                                <div class="ms-4">
                                    <p class="mb-0 sensor-name-title">{{ $displayName }}</p>
                                    
                                    <h4 class="my-1" data-sensor-id="{{ Str::slug($location->name) }}-{{ Str::slug($sensor->sensor_name) }}">
                                        <span class="sensor-value">-</span> 
                                        <small class="fs-6">{{ $sensor->unit }}</small>
                                    </h4>
                                    
                                    <p class="mb-0 font-13 {{ ($sensor->status == 1) ? 'text-success' : 'text-danger' }}">
                                        <i class='bx bxs-circle align-middle'></i> {{ $sensor->status ? 'Aktif' : 'Nonaktif' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection

@push('js')
<script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
<script>
    const socket = io("{{ env('WEBSOCKET_SERVER_URL', 'http://127.0.0.1:3001') }}", {
        transports: ['websocket'],
    });

    socket.on("connect", () => console.log("BERHASIL: Terhubung ke WebSocket Server dari browser."));
    socket.on("disconnect", () => console.log("PERINGATAN: Terputus dari WebSocket Server."));

    function updateSensorValue(locationSlug, sensorName, sensorValue) {
        const sensorSlug = sensorName.toLowerCase().replace(/ /g, '-').replace(/_/g, '-');
        const uniqueId = `${locationSlug}-${sensorSlug}`;
        
        const element = document.querySelector(`[data-sensor-id="${uniqueId}"]`);
        
        if (element) {
            const valueSpan = element.querySelector('.sensor-value');
            if (valueSpan) {
                valueSpan.textContent = sensorValue;
            }
        }
    }

    socket.on('data_from_mqtt', (payload) => {
        if (payload && payload.locationSlug && Array.isArray(payload.data)) {
            payload.data.forEach(sensor => {
                updateSensorValue(payload.locationSlug, sensor.name, sensor.value);
            });
        }
    });
</script>
@endpush