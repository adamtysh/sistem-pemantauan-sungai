@extends('layouts.main')

@section('content')
<h6 class="mb-0 text-uppercase">{{ $page_title }}</h6>
<hr/>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

    {{-- Kartu untuk Manajemen Lokasi --}}
    <div class="col">
        <a href="{{ route('locations.index') }}" class="text-decoration-none">
            <div class="card h-100 dashboard-card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class='bx bx-map-alt bx-lg text-primary'></i>
                    <h6 class="card-title mt-3 mb-0">Manajemen Lokasi</h6>
                </div>
            </div>
        </a>
    </div>

    {{-- Kartu untuk Manajemen Sensor --}}
    <div class="col">
        <a href="{{ route('sensor_settings.index') }}" class="text-decoration-none">
            <div class="card h-100 dashboard-card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class='bx bx-chip bx-lg text-success'></i>
                    <h6 class="card-title mt-3 mb-0">Manajemen Sensor</h6>
                </div>
            </div>
        </a>
    </div>

    {{-- Kartu untuk Manajemen Alarm --}}
    <div class="col">
        <a href="{{ route('alarm_settings.index') }}" class="text-decoration-none">
            <div class="card h-100 dashboard-card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class='bx bxs-bell-ring bx-lg text-danger'></i>
                    <h6 class="card-title mt-3 mb-0">Manajemen Alarm</h6>
                </div>
            </div>
        </a>
    </div>

</div>
@endsection

@push('css')
<style>
    .dashboard-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
