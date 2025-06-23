@extends('layouts.main')
@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col">
        <h6 class="mb-0 text-uppercase">{{ $page_title }}</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                {{-- Tampilkan error validasi --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Form Edit Sensor --}}
                <form action="{{ route('sensor_settings.update', $sensor_setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="location_id" class="form-label">Nama Lokasi</label>
                        <select class="form-select" name="location_id" id="location_id" required>
                            <option value="" disabled>Pilih Lokasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" {{ $sensor_setting->location_id == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sensor_name" class="form-label">Nama Sensor</label>
                        <input type="text" class="form-control" id="sensor_name" name="sensor_name" value="{{ $sensor_setting->sensor_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" value="{{ $sensor_setting->unit }}"required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="1" {{ $sensor_setting->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $sensor_setting->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('sensor_settings.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
