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
                {{-- Tampilkan pesan sukses/error jika ada --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Form Edit Lokasi --}}
                <form action="{{ route('locations.update', $location->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $location->name) }}" 
                               placeholder="Masukkan nama lokasi" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
