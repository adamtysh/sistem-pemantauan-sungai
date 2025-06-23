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

                {{-- Pesan sukses --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                {{-- Pesan error --}}
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                {{-- Validasi error --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif


                <div class="mb-3 text-end">
                    <a href="{{ route('alarm_settings.create') }}" class="btn btn-success">
                        <i class="bx bx-location-plus"></i> Tambah Alarm
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="alarm_setting" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Lokasi</th>
                                <th>Sensor</th>
                                <th>Value</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($alarms as $alarm)
                              <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alarm->getLocationSensor($alarm->sensor_setting_id) }}</td>
                                    <td>{{ $alarm->sensorSetting->sensor_name }}</td>
                                    <td>{{ $alarm->threshold }}</td>
                                    <td>{{ $alarm->message }}</td>
                                    <td>
                                        <a href="{{ route('alarm_settings.edit', $alarm->id) }}" class="btn btn-warning btn-sm"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('alarm_settings.destroy', $alarm->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');"><i class="bx bx-trash"></i></button>
                                        </form>
                              </tr>
                          @endforeach
                        </tbody>      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#alarm_setting').DataTable();
    });
</script>
@endpush
