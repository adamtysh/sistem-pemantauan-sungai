<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Memuat semua file CSS dan meta tag utama --}}
    @include('layouts.partials.head')

    @hasSection('favicon')
        @yield('favicon')
    @else
        <link rel="icon" href="{{ asset('assets/images/polsri/logo-pupr.png') }}" type="image/png">
    @endif

    <title>@yield('title', 'Sistem Pemantauan Sungai')</title>

</head>

<body>
	<div class="wrapper">
		<div class="header-wrapper">
			@include('layouts.partials.navbar')
			<div class="primary-menu">
                @include('layouts.partials.nav-menu')
			</div>
		</div>
		<div class="page-wrapper">
			<div class="page-content">
				@yield('content')
			</div>
		</div>
		

		<div class="overlay toggle-icon"></div>
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		@include('layouts.partials.footer')
	</div>

    {{-- ▼▼▼ BLOK KODE CDN DIHAPUS DARI SINI ▼▼▼ --}}
    {{-- Pemuatan skrip sekarang sepenuhnya ditangani oleh file foot.blade.php --}}

	@include('layouts.partials.foot')
	
</body>
</html>