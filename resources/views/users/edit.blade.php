@extends('layouts.main')

@push('css')

@endpush

@section('content')
    <div class="row">
        <div class="col">
            <h6 class="mb-0 text-uppercase">Edit Pengguna</h6>
            <hr/>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Perbarui informasi pengguna</h5>
                    <form class="row g-3" method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Nama Pengguna</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username', $user->username) }}" placeholder="Masukan nama pengguna">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-user"></i></span>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Masukan nama lengkap">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-user"></i></span>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Alamat Email</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Masukan alamat email">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-envelope"></i></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-lock"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Konfirmasi Password">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-lock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-light px-4">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
