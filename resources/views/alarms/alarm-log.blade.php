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

                {{-- ... (sisa pesan error tidak perlu diubah) ... --}}

                <div class="table-responsive">
                    <table id="alarm" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- ▼▼▼ TAMBAHKAN HEADER BARU UNTUK WAKTU ▼▼▼ --}}
                                <th>Waktu Kejadian</th>
                                <th>Lokasi</th>
                                <th>Sensor</th>
                                <th>Value</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($alarms as $alarm)
                              <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- ▼▼▼ TAMBAHKAN DATA WAKTU DENGAN FORMAT YANG MUDAH DIBACA ▼▼▼ --}}
                                    <td>{{ $alarm->created_at->format('d M Y, H:i:s') }}</td>
                                    <td>{{ $alarm->location_name }}</td>
                                    <td>{{ $alarm->sensor_name }}</td>
                                    <td>{{ $alarm->value }}</td>
                                    <td>{{ $alarm->message }}</td>
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
        $('#alarm').DataTable();
    });
</script>
@endpush