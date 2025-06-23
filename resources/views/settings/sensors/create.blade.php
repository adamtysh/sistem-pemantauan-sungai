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
                {{-- Form Tambah Lokasi --}}
                <form action="{{ route('sensor_settings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="location_id" class="form-label">Nama Lokasi</label>
                        <select class="form-select" name="location_id" id="location_id" required>
                            <option value="" disabled selected>Pilih Lokasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sensor_name" class="form-label">Nama Sensor</label>
                        <input type="text" class="form-control" id="sensor_name" name="sensor_name" placeholder="Masukkan nama sensor" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" placeholder="Masukkan unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option selected value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('sensor_settings.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
