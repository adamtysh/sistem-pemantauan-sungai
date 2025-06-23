@extends('layouts.main')

@push('css')
<style>
    .sensor-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
        cursor: pointer;
        background-color: #fff;
    }
    .sensor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .sensor-card .card-body i {
        font-size: 3rem;
        /* ▼▼▼ PERUBAHAN 1: Menghapus warna biru yang di-hardcode agar warna dinamis bisa diterapkan ▼▼▼ */
        /* color: #0d6efd; */
    }
</style>
@endpush

@section('content')
<h6 class="mb-0 text-uppercase">{{ $page_title ?? 'Pilih Grafik Historis' }}</h6>
<hr/>

@forelse ($locationsWithSensors as $locationName => $sensors)
    
    <h5 class="mb-3 mt-4 text-uppercase">{{ $locationName }}</h5>

    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-4">
        @foreach ($sensors as $sensor)
            @php
                $displayName = $sensor->display_name ?? Str::replace('_', ' ', $sensor->sensor_name);
                
                // ▼▼▼ PERUBAHAN 2: Menambahkan logika untuk menentukan kelas warna dinamis ▼▼▼
                $icon = 'bx bx-chip';
                $colorClass = 'text-secondary'; // Warna default
                $sensorNameLower = strtolower($displayName);

                if (Str::contains($sensorNameLower, 'suhu')) { 
                    $icon = 'bx bxs-thermometer'; 
                    $colorClass = 'text-warning'; 
                }
                elseif (Str::contains($sensorNameLower, 'water level')) { 
                    $icon = 'bx bx-water'; 
                    $colorClass = 'text-primary'; 
                }
                elseif (Str::contains($sensorNameLower, 'humidity')) { 
                    $icon = 'bx bx-droplet'; 
                    $colorClass = 'text-info'; 
                }
                elseif (Str::contains($sensorNameLower, 'barometric pressure')) { 
                    $icon = 'bx bx-wind'; 
                    $colorClass = 'text-success'; 
                }
                elseif (Str::contains($sensorNameLower, 'curah hujan')) { 
                    $icon = 'bx bx-cloud-rain'; 
                    $colorClass = 'text-muted'; // Gunakan 'text-muted' agar sesuai dengan dasbor
                }
            @endphp
            <div class="col">
                <a href="{{ route('trending.index', ['sensorName' => $displayName]) }}" class="text-decoration-none">
                    <div class="card h-100 sensor-card">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            {{-- Menerapkan kelas ikon dan kelas warna di sini --}}
                            <i class="{{ $icon }} {{ $colorClass }}"></i>
                            <h6 class="card-title mt-3 mb-0">{{ $displayName }}</h6>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@empty
    <div class="alert alert-warning text-center">
        Tidak ada sensor yang ditemukan. Silakan tambahkan sensor di menu Pengaturan.
    </div>
@endforelse

@endsection