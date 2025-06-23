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
                <form action="{{ route('alarm_settings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="sensor_name" class="form-label">Nama Sensor</label>
                        <select name="sensor_setting_id" id="sensor_setting_id" class="form-select">
                            <option value="" disabled selected>Pilih Sensor</option>
                            @foreach ($sensors as $sensor)
                                <option value="{{ $sensor->id }}">{{$sensor->location->name .' | '.$sensor->sensor_name }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <label for="" class="form-label">Operator</label>
                        <select name="operator" id="operator" class="form-select">
                            <option value="" disabled selected>Pilih Operator</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                            <option value="==">==</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Threshold</label>
                        <input type="number" class="form-control" id="threshold" name="threshold" placeholder="Masukkan threshold" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Message</label>
                        <input type="text" class="form-control" id="message" name="message" placeholder="Masukkan pesan" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status</label>
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
