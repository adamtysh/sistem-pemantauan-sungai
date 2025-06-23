@extends('layouts.main')

@push('css')
<!-- Tambahkan CSS tambahan jika diperlukan -->
@endpush

@section('content')
<div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
    <div class="col">
        <div class="card radius-10 shadow-md cursor-pointer" onclick="window.location.href='{{ route('locations.index') }}'" style="transition: transform 0.3s ease; cursor: pointer;">
            <div class="card-body">
                <div class="text-center">
                    <h4 class="my-1">Titik Lokasi</h4>
                    <p class="mb-0 text-secondary">Pengaturan titik lokasi</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 shadow-md cursor-pointer" onclick="window.location.href='{{ route('sensor_settings.index') }}'" style="transition: transform 0.3s ease; cursor: pointer;">
            <div class="card-body">
                <div class="text-center">
                    <h4 class="my-1">Sensor</h4>
                    <p class="mb-0 text-secondary">Pengaturan sensor</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 shadow-md cursor-pointer" onclick="window.location.href='{{ route('alarm_settings.index') }}'" style="transition: transform 0.3s ease; cursor: pointer;">
            <div class="card-body">
                <div class="text-center">
                    <h4 class="my-1">Alarm</h4>
                    <p class="mb-0 text-secondary">Pengaturan alarm</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Tambahkan JavaScript tambahan jika diperlukan -->
@endpush
