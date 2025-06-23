<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/polsri/logo-polsri.png') }}" type="image/png" />
    <title>Sistem Pemantauan Sungai - Registrasi</title>
    
    <link href="{{asset('assets')}}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="{{asset('assets')}}/css/pace.min.css" rel="stylesheet" />
    <script src="{{asset('assets')}}/js/pace.min.js"></script>
    <link href="{{asset('assets')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('assets')}}/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets')}}/css/app.css" rel="stylesheet">
    <link href="{{asset('assets')}}/css/icons.css" rel="stylesheet">
</head>

<body class="bg-login">
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="mb-3 text-center">
                                        <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                                            <img src="{{asset('assets')}}/images/polsri/logo-polsri.png" width="70" alt="Logo Polsri" />
                                            <img src="{{asset('assets')}}/images/polsri/logo-palembang.png" width="70" alt="Logo Palembang" />
                                            <img src="{{asset('assets')}}/images/polsri/logo-pupr.png" width="70" alt="Logo PUPR" />
                                        </div>
                                        </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Sistem Pemantauan Sungai</h5>
                                        <p class="mb-0">Silakan isi form untuk membuat akun baru</p>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="col-12">
                                                <label for="username" class="form-label">Nama Pengguna</label>
                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Masukan nama pengguna" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                                @error('username')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama lengkap" name="name" value="{{ old('name') }}" required autocomplete="name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukan Password" required> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                                <div class="input-group" id="show_hide_password_confirm">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Masukan Confirm Password" required> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-lg btn-danger">Daftar</button>
                                                </div>
                                            </div>
                                             <div class="col-12">
                                                <div class="text-center mt-4">
                                                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets')}}/js/jquery.min.js"></script>
    <script>
        // Script untuk show/hide password
        $(document).ready(function () {
            $("#show_hide_password a, #show_hide_password_confirm a").on('click', function (event) {
                event.preventDefault();
                var inputGroup = $(this).closest('.input-group');
                var input = inputGroup.find('input');
                var icon = inputGroup.find('i');
                if (input.attr("type") == "text") {
                    input.attr('type', 'password');
                    icon.addClass("bx-hide").removeClass("bx-show");
                } else if (input.attr("type") == "password") {
                    input.attr('type', 'text');
                    icon.removeClass("bx-hide").addClass("bx-show");
                }