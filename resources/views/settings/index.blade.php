@extends('layouts.main')


@push('css')
<style>
 .setting-card {
 background-color: #fff;
 border-radius: 0.75rem; /* 12px */
 padding: 2rem 1.5rem;
 text-align: center;
 box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
 transition: transform 0.2s ease-in-out;
 text-decoration: none;
 color: #374151;
 border-top: 5px solid transparent; /* Untuk efek warna di hover */
 }


 .setting-card:hover {
 transform: translateY(-3px);
 box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
 }


 .setting-card i {
 font-size: 2.5rem; /* 40px */
 margin-bottom: 1rem;
 display: block;
 }


 .setting-card h5 {
 font-size: 1.125rem; /* 18px */
 font-weight: 600;
 margin-bottom: 0;
 }


 /* Warna spesifik untuk setiap kartu */
 .card-lokasi {
 border-top-color: #4299e1; /* Blue-500 */
 }
 .card-lokasi i {
 color: #4299e1;
 }


 .card-sensor {
 border-top-color: #48bb78; /* Green-500 */
 }
 .card-sensor i {
 color: #48bb78;
 }


 .card-alarm {
 border-top-color: #e53e3e; /* Red-500 */
 }
 .card-alarm i {
 color: #e53e3e;
 }
</style>
@endpush


@section('content')
<h4 class="mb-4 text-uppercase" style="color: #6c757d;">Pengaturan Sistem</h4>


<div class="row row-cols-1 row-cols-md-3 g-4">
 <div class="col">
 <a href="{{ route('locations.index') }}" class="setting-card card-lokasi">
 <i class="fa-solid fa-map-location-dot"></i>
 <h5>Manajemen Lokasi</h5>
 </a>
 </div>
 <div class="col">
 <a href="{{ route('sensor_settings.index') }}" class="setting-card card-sensor">
 <i class="fa-solid fa-microchip"></i>
 <h5>Manajemen Sensor</h5>
 </a>
 </div>
 <div class="col">
 <a href="{{ route('alarm_settings.index') }}" class="setting-card card-alarm">
 <i class="fa-solid fa-bell"></i>
 <h5>Manajemen Alarm</h5>
 </a>
 </div>
</div>
@endsection


@push('js')
@endpush
