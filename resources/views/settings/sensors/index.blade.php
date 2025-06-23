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
                    <a href="{{ route('sensor_settings.create') }}" class="btn btn-success">
                        <i class="bx bx-location-plus"></i> Tambah Sensor
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="location" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Lokasi</th>
                                <th>Sensor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sensor_settings as $sensor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sensor->location->name }}</td>
                                    <td>{{ $sensor->sensor_name }}</td>
                                    <td>
                                        <a href="{{ route('sensor_settings.edit', $sensor->id) }}" class="btn btn-primary btn-sm">Ubah</a>
                                        <form action="{{ route('sensor_settings.destroy', $sensor->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
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
        $('#location').DataTable();
    });
</script>
@endpush
