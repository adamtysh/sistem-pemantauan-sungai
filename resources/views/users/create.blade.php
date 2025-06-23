@extends('layouts.main')
@push('css')
 
@endpush
@section('content')
    <div class="row">
        <div class="col">
            <h6 class="mb-0 text-uppercase">{{$page_title}}</h6>
            <hr/>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Isi informasi di bawah untuk daftar akun</h5>
                    <form class="row g-3" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="input42" class="col-sm-3 col-form-label">Masukan nama pengguna <br> <small>*nama ini akan digunakan untuk login</small></label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="input42" placeholder="Masukan nama pengguna">
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
                            <label for="input42" class="col-sm-3 col-form-label">Masukan nama lengkap</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="input42" placeholder="Masukan nama lengkap">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-user"></i></span>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 d-none">
                            <label for="input43" class="col-sm-3 col-form-label">Phone No</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="input43" placeholder="Phone No">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bx bx-phone"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input44" class="col-sm-3 col-form-label">Alamat Email</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="input44" placeholder="Masukan alamat email">
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
                            <label for="input45" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="input45" placeholder="Masukan Password">
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
                            <label for="input45" class="col-sm-3 col-form-label">Konfirmasi Password</label>
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
                                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                    {{-- <button type="button" class="btn btn-light px-4">Reset</button> --}}
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